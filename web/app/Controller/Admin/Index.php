<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;
use Exception;

class Index extends AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);

            $arguments = [
                'title' => 'Página Inicial',
                'sidebar' => self::getAdminSidebar(),
                'footer' => self::getAdminFooter()
            ];
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages

            $request->getRouter()->redirect('/admin/login');
        }

        return View::render(
            'index',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }
}
