<?php

namespace App\Controller\Admin\Pages;

use App\View\View;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    public static function getAdminContentPage(): string
    {
        $arguments = [
            'title' => 'Listagem das Páginas',
            'baseUrl' => URL . '/admin',
            'pageSavePath' => 'pages/save',
            'pageDeletePath' => 'pages/delete',
            'pageListingPath' => 'pages/listing'
        ];

        $content = View::render(
            'contents/pages/listing',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
