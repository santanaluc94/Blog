<?php

namespace App\Controller\Admin\Users;

use App\Controller\Admin\{
    AbstractAdminPost,
    PostInterface
};
use App\Http\Request;
use App\Model\User\{
    Entity,
    Repository
};
use App\Model\Role\Repository as RoleRepository;
use Exception;

class SavePost extends AbstractAdminPost implements PostInterface
{
    public static function execute(Request $request): string
    {
        try {
            $userData = $request->getPostVars();
            self::sanitizeFields($userData);
            $userRepository = new Repository();

            if (isset($userData['id']) && $userData['id']) {
                if (!filter_var($userData['id'], FILTER_VALIDATE_INT)) {
                    throw new Exception('O campo id não foi preenchido corretamente.', 400);
                }

                $id = (int) $userData['id'];

                $entity = $userRepository->load($id);
                $entity->setId($id)
                    ->setFirstname($userData['user_firstname'])
                    ->setLastname($userData['user_lastname'])
                    ->setEmail($userData['user_email'])
                    ->setRoleId($userData['user_role_id']);

                if (isset($userData['user_password'])) {
                    $entity->setPassword($userData['user_password']);
                }
            } else {
                $entity = new Entity(
                    $userData['user_firstname'],
                    $userData['user_lastname'],
                    $userData['user_email'],
                    $userData['user_role_id'],
                    $userData['user_password']
                );
            }

            if (!$userRepository->save($entity)) {
                throw new Exception(
                    "Não foi possível salvar o usuário com os dados passados.",
                    400
                );
            }
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages
        }

        return URL . '/admin/users/listing';
    }

    public static function sanitizeFields(array &$data): void
    {
        if (
            !isset($data['user_firstname']) ||
            !is_string($data['user_firstname'])
        ) {
            throw new Exception('O campo nome não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['user_lastname']) ||
            !is_string($data['user_lastname'])
        ) {
            throw new Exception('O campo sobrenome não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['user_email']) ||
            !filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)
        ) {
            throw new Exception('O campo email não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['user_role_id']) ||
            !filter_var($data['user_role_id'], FILTER_VALIDATE_INT)
        ) {
            throw new Exception('O campo cargo não foi preenchido corretamente.', 400);
        }

        if (
            isset($data['user_password']) &&
            !is_string($data['user_password'])
        ) {
            throw new Exception('O campo senha não foi preenchido corretamente.', 400);
        } elseif (
            isset($data['user_password']) &&
            is_string($data['user_password']) &&
            $data['user_password']
        ) {
            $data['user_password'] = password_hash(htmlspecialchars($data['user_password']), PASSWORD_ARGON2ID);
        }

        $roleId = (int) $data['user_role_id'];
        $roleRepository = new RoleRepository();
        $role = $roleRepository->load($roleId);

        $data['user_firstname'] = htmlspecialchars($data['user_firstname']);
        $data['user_lastname'] = htmlspecialchars($data['user_lastname']);
        $data['user_email'] = htmlspecialchars($data['user_email']);
        $data['user_role_id'] = $role->getId();
    }
}
