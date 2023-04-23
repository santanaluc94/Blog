<?php

namespace App\Controller;

use App\View\View;

class AllPosts extends AbstractPage
{
    public static function getContentPage(): string
    {
        $arguments = [
            'title' => 'Blog: Totos as postagens',
            'baseUrl' => 'http://localhost/'
        ];

        $content = View::render(
            'contents/all_posts',
            self::AREA_FRONT_HOMEPAGE,
            $arguments
        );

        return parent::getPage($arguments['title'], $content);
    }
}
