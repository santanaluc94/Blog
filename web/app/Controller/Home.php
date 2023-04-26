<?php

namespace App\Controller;

use App\View\View;
use App\Http\Request;

class Home extends AbstractPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Blog: Página Inicial'
        ];

        $content = View::render(
            'contents/home',
            self::AREA_FRONT_HOMEPAGE,
            $arguments
        );

        return parent::getPage($arguments['title'], $content);
    }
}
