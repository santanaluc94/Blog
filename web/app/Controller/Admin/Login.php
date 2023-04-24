<?php

namespace App\Controller\Admin;

use App\View\View;

class Login extends AbstractAdminPage
{
    public static function getAdminContentPage(): string
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
