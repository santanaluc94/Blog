<?php

namespace App\Controller\Admin\Users;

use App\View\View;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    public static function getAdminContentPage(): string
    {
        $arguments = [
            'title' => 'Novo Usuário',
            'userSavePath' => 'users/save',
            'userSavePost' => '',
            'userDeletePath' => 'users/delete',
            'userListingPath' => 'users/listing'
        ];

        $content = View::render(
            'contents/users/save',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
