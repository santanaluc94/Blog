<?php

namespace App\Controller\Admin\Posts;

use App\View\View;
use App\Http\Request;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Listagem das Postasgens',
            'postSavePath' => 'posts/save',
            'postDeletePath' => 'posts/delete',
            'postListingPath' => 'posts/listing'
        ];

        $content = View::render(
            'contents/posts/listing',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
