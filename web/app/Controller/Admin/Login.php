<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;
use App\Model\AdminSession;

class Login extends AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        if (AdminSession::isLoggedIn()) {
            $request->getRouter()->redirect('/admin/index');
            exit();
        }

        $arguments = [
            'title' => 'Admin Login',
            'actionFormUrl' => 'loginPost',
            'registerPath' => 'register'
        ];

        return View::render(
            'login',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }
}
