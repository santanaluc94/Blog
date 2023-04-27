<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;
use App\Model\AdminSession;
use App\Model\Role\Entity as RoleEntity;
use Exception;

class Index extends AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        try {
            /** @var RoleEntity $roleSession */
            $roleSession = AdminSession::getSession()['role'];

            if (
                !AdminSession::isLoggedIn() ||
                !$roleSession->getId() ||
                !self::isAllowed($roleSession->getPermissionsArray())
            ) {
                throw new Exception(
                    'Este usuário não possui acesso a essa rota.',
                    401
                );
            }

            $arguments = [
                'title' => 'Página Inicial',
                'sidebar' => self::getAdminSidebar(),
                'footer' => self::getAdminFooter()
            ];
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages

            $request->getRouter()->redirect(URL . '/admin/login');
        }

        return View::render(
            'index',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }
}
