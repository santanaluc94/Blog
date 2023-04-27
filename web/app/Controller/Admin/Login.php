<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;

class Login extends AbstractAdminPage
{
    protected static array $aclAreaMandatory = [];

    public static function execute(Request $request): string
    {
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
