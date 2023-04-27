<?php

namespace App\Controller\Site;

use App\View\View;
use App\Http\Request;

class Login extends AbstractPage
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
            self::AREA_FRONT_HOMEPAGE,
            $arguments
        );
    }
}
