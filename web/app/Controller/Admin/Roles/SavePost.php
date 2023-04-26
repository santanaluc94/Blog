<?php

namespace App\Controller\Admin\Roles;

use App\Http\Request;
use App\Model\Role\Entity;
use App\Model\Role\Repository;
use Exception;

class SavePost extends \App\Controller\Admin\AbstractAdminPost
{
    public static function execute(Request $request): string
    {
        try {
            $roleData = $request->getPostVars();

            if (
                !isset($roleData['role_name']) ||
                !isset($roleData['role_permissions']) ||
                !isset($roleData['role_is_enabled'])
            ) {
                throw new Exception('Você precisa preencher todos os campos.', 400);
            }

            $name = htmlspecialchars($roleData['role_name']);
            $permissions = str_replace('"on"', 'true', json_encode(filter_var_array($roleData['role_permissions'])));
            $isEnabled = (filter_var($roleData['role_is_enabled'], FILTER_VALIDATE_BOOL)) ? 1 : 0;
            $roleRepository = new Repository();

            if (isset($roleData['id']) && is_numeric($roleData['id'])) {
                $id = filter_var($roleData['id'], FILTER_VALIDATE_INT);

                $entity = $roleRepository->load((int) $roleData['id']);
                $entity->setId($id)
                    ->setName($name)
                    ->setPermissions($permissions)
                    ->setEnabled($isEnabled);
            } else {
                $entity = new Entity(
                    $name,
                    $permissions,
                    $isEnabled
                );
            }

            if (!$roleRepository->save($entity)) {
                throw new Exception(
                    "Não foi possível salvar o usuário.",
                    400
                );
            }
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages
        }

        return URL . '/admin/roles/listing';
    }
}
