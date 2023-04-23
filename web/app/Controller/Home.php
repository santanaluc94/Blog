<?php

namespace App\Controller;

use App\View\View;

class Home extends AbstractPage
{
    public static function getContentPage(): string
    {
        $arguments = [
            'title' => 'Blog: Página Inicial',
            'baseUrl' => 'http://localhost/'
        ];

        $content = View::render(
            'contents/home',
            self::AREA_FRONT_HOMEPAGE,
            $arguments
        );

        return parent::getPage($arguments['title'], $content);
    }
}
