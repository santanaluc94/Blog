<?php

namespace App\Controller\Admin\Roles;

use App\Controller\Admin\{
    AbstractAdminPost,
    PostInterface
};
use App\Http\Request;
use App\Model\Role\{
    Entity,
    Repository
};
use Exception;

class SavePost extends AbstractAdminPost implements PostInterface
{
    public static function execute(Request $request): string
    {
        try {
            $roleData = $request->getPostVars();
            self::sanitizeFields($roleData);
            $roleRepository = new Repository();

            if (isset($roleData['id']) && $roleData['id']) {
                if (!filter_var($roleData['id'], FILTER_VALIDATE_INT)) {
                    throw new Exception('O campo id não foi preenchido corretamente.', 400);
                }

                $id = (int) $roleData['id'];

                $entity = $roleRepository->load($id);
                $entity->setId($id)
                    ->setName($roleData['role_name'])
                    ->setPermissions($roleData['role_permissions'])
                    ->setEnabled($roleData['role_is_enabled']);
            } else {
                $entity = new Entity(
                    $roleData['role_name'],
                    $roleData['role_permissions'],
                    $roleData['role_is_enabled']
                );
            }

            if (!$roleRepository->save($entity)) {
                throw new Exception(
                    "Não foi possível salvar o papel de usuário com os dados passados.",
                    400
                );
            }
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages
        }

        return URL . '/admin/roles/listing';
    }

    public static function sanitizeFields(array &$data): void
    {
        if (
            !isset($data['role_name']) ||
            !is_string($data['role_name'])
        ) {
            throw new Exception('O campo nome não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['role_permissions']) ||
            !filter_var_array($data['role_permissions'])
        ) {
            throw new Exception('O campo de permissões não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['role_is_enabled']) ||
            !is_string($data['role_is_enabled'])
        ) {
            throw new Exception('O campo status não foi preenchido corretamente.', 400);
        }

        $data['role_name'] = htmlspecialchars($data['role_name']);
        $data['role_permissions'] = str_replace('"on"', 'true', json_encode($data['role_permissions']));
        $data['role_is_enabled'] = (json_decode($data['role_is_enabled'])) ? 1 : 0;
    }
}
