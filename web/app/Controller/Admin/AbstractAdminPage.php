<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;

abstract class AbstractAdminPage
{
    public const AREA_ADMIN_HOMEPAGE = 'admin';

    protected static string $items = '';
    protected static string $emptyList = '';

    public static function getAdminPage(
        string $title,
        string $content
    ): string {
        $arguments = [
            'title' => $title,
            'sidebar' => self::getAdminSidebar(),
            'content' => $content,
            'footer' => self::getAdminFooter()
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
            'categoriesListingPath' => 'categories/listing',
            'pagesListingPath' => 'pages/listing',
            'postListingPath' => 'posts/listing',
            'rolesListingPath' => 'roles/listing',
            'usersListingPath' => 'users/listing',
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

    abstract public static function execute(Request $request): string;
}
