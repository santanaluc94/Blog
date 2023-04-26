<?php

namespace App\Controller\Admin\Users;

use App\Http\Request;
use App\Model\User\Entity;
use App\Model\User\Repository;
use Exception;

class SavePost extends \App\Controller\Admin\AbstractAdminPost
{
    public static function execute(Request $request): string
    {
        try {
            $userData = $request->getPostVars();

            if (
                !isset($userData['user_firstname']) ||
                !isset($userData['user_lastname']) ||
                !isset($userData['user_email']) ||
                !isset($userData['user_role_id'])
            ) {
                throw new Exception('Você precisa preencher todos os campos.', 400);
            }

            $firstname = htmlspecialchars($userData['user_firstname']);
            $lastname = htmlspecialchars($userData['user_lastname']);
            $email = filter_var($userData['user_email'], FILTER_SANITIZE_EMAIL);
            $roleId = htmlspecialchars($userData['user_role_id']);

            $user = new Entity(
                $firstname,
                $lastname,
                $email,
                $roleId
            );

            $userRepository = new Repository();
            $userRepository->save($user);
        } catch (Exception $exception) {
            // TODO: Implementar Log
        }

        return URL . '/admin/users/save';
    }
}
