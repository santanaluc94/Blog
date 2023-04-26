<?php

namespace App\Controller\Admin\Posts;

use App\View\View;
use App\Http\Request;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Nova Postagem',
            'postSavePath' => 'posts/save',
            'postSavePost' => '',
            'postDeletePath' => 'posts/delete',
            'postListingPath' => 'posts/listing'
        ];

        $content = View::render(
            'contents/posts/save',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
