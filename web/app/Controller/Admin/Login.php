<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;

class Login extends AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Blog: Admin Login',
            'actionFormUrl' => '',
            'registerPath' => 'register'
        ];

        return View::render(
            'login',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }
}
