<?php

namespace App\Controller\Admin;

use App\View\View;

class Register extends AbstractAdminPage
{
    public static function getAdminContentPage(): string
    {
        $arguments = [
            'title' => 'Blog: Register',
            'actionFormUrl' => '',
            'loginPath' => 'login'
        ];

        return View::render(
            'register',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }
}
