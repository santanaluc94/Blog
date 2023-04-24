<?php

namespace App\Controller\Admin\Categories;

use App\View\View;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    public static function getAdminContentPage(): string
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
