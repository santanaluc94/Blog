<?php

namespace App\Controller\Admin\Categories;

use App\View\View;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    public static function getAdminContentPage(): string
    {
        $arguments = [
            'title' => 'Listagem das Categorias',
            'baseUrl' => URL . '/admin',
            'categorySavePath' => 'categories/save',
            'categoryDeletePath' => 'categories/delete',
            'categoryListingPath' => 'categories/listing'
        ];

        $content = View::render(
            'contents/categories/listing',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
