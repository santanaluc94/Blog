<?php

namespace App\Controller;

use App\View\View;

abstract class AbstractPage
{
    public const AREA_FRONT_HOMEPAGE = 'front';

    public static function getPage(
        string $title,
        string $content
    ): string {
        $arguments = [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ];

        return View::render(
            'page',
            self::AREA_FRONT_HOMEPAGE,
            $arguments
        );
    }

    protected static function getHeader(): string
    {
        return View::render('header');
    }

    protected static function getFooter(): string
    {
        return View::render('footer');
    }

    abstract public static function getContentPage(): string;
}
