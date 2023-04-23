<?php

namespace App\Controller\Admin;

use App\View\View;

abstract class AbstractAdminPage
{
    public const AREA_ADMIN_HOMEPAGE = 'admin';

    public static function getAdminPage(
        string $title,
        string $content
    ): string {
        $arguments = [
            'title' => $title,
            'header' => self::getAdminHeader(),
            'content' => $content,
            'footer' => self::getAdminFooter(),
            'baseUrl' => 'http://localhost/'
        ];

        return View::render(
            'admin/page',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }

    protected static function getAdminHeader(): string
    {
        return View::render('header');
    }

    protected static function getAdminFooter(): string
    {
        return View::render('footer');
    }

    abstract public static function getAdminContentPage(): string;
}
