<?php

namespace App\Controller\Admin\Categories;

use App\View\View;
use App\Http\Request;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Listagem das Categorias',
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
