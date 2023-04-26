<?php

namespace App\Controller\Admin\Users;

use App\View\View;
use App\Http\Request;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Listagem dos Usuários',
            'userSavePath' => 'users/save',
            'userDeletePath' => 'users/delete',
            'userListingPath' => 'users/listing'
        ];

        $content = View::render(
            'contents/users/listing',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
