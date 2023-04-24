<?php

namespace App\Controller\Admin\Pages;

use App\View\View;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    public static function getAdminContentPage(): string
    {
        $arguments = [
            'title' => 'Nova Página',
            'baseUrl' => URL . '/admin',
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
