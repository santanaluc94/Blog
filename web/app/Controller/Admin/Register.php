<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;

class Register extends AbstractAdminPage
{
    public static function execute(Request $request): string
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
