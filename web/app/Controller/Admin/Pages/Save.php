<?php

namespace App\Controller\Admin\Pages;

use App\View\View;
use App\Http\Request;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Nova Página',
            'pageSavePath' => 'pages/save',
            'pageSavePost' => '',
            'pageDeletePath' => 'pages/delete',
            'pageListingPath' => 'pages/listing'
        ];

        $content = View::render(
            'contents/pages/save',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
