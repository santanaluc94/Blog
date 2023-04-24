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
            'sidebar' => self::getAdminSidebar(),
            'content' => $content,
            'footer' => self::getAdminFooter(),
            'baseUrl' => URL . '/admin'
        ];

        return View::render(
            'page',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }

    protected static function getAdminSidebar(): string
    {
        $arguments = [
            'postListingPath' => 'posts/listing',
            'categoriesListingPath' => 'categories/listing',
            'usersListingPath' => 'users/listing',
            'pagesListingPath' => 'pages/listing',
            'logoutPath' => 'logout'
        ];

        return View::render(
            'sidebar',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );
    }

    protected static function getAdminFooter(): string
    {
        return View::render('footer', self::AREA_ADMIN_HOMEPAGE);
    }

    abstract public static function getAdminContentPage(): string;
}
