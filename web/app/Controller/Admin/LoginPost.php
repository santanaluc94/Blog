<?php

namespace App\Controller\Admin;

use App\Controller\Admin\{
    AbstractAdminPost,
    PostInterface
};
use App\Http\Request;
use App\Model\User\Repository;
use App\Model\AdminSession;
use Exception;

class LoginPost extends AbstractAdminPost implements PostInterface
{
    public static function execute(Request $request): string
    {
        try {
            $data = $request->getPostVars();
            self::sanitizeFields($data);

            $repository = new Repository();
            $entity = $repository->getByEmail($data['admin_email']);

            if (!password_verify($data['admin_password'], $entity->getPassword())) {
                throw new Exception(
                    "Usuário e/ou senha incorreto.",
                    401
                );
            }

            if (!$entity->getRole()->isEnabled()) {
                throw new Exception(
                    "Usuário sem acesso para fazer login.",
                    401
                );
            }

            AdminSession::setSession($entity);

            return URL . '/admin/index';
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages
        }

        return URL . '/admin/login';
    }

    public static function sanitizeFields(array &$data): void
    {
        if (
            !isset($data['admin_email']) ||
            !filter_var($data['admin_email'], FILTER_VALIDATE_EMAIL)
        ) {
            throw new Exception('O campo email não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['admin_password']) ||
            !is_string($data['admin_password'])
        ) {
            throw new Exception('O campo senha não foi preenchido corretamente.', 400);
        }

        $data['admin_email'] = htmlspecialchars($data['admin_email']);
        $data['admin_password'] = htmlspecialchars($data['admin_password']);
    }
}
