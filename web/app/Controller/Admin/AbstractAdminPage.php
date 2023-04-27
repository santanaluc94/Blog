<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\View\View;

abstract class AbstractAdminPage extends AbstractAdmin
{
    protected const QTY_COLUMNS = 0;

    protected static string $items = '';
    protected static string $emptyList = '';

    abstract public static function execute(Request $request): string;

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
            'generateUrlDump' => 'dump'
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

    protected static function getEmptyItems(): string
    {
        return View::render(
            'emptyList',
            self::AREA_ADMIN_HOMEPAGE,
            ['qtyColumns' => self::QTY_COLUMNS]
        );
    }
}
