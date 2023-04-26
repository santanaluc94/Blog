<?php

namespace App\Controller\Admin\Categories;

use App\View\View;
use App\Http\Request;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Nova Categoria',
            'categorySavePath' => 'categories/save',
            'categorySavePost' => '',
            'categoryDeletePath' => 'categories/delete',
            'categoryListingPath' => 'categories/listing'
        ];

        $content = View::render(
            'contents/categories/save',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
