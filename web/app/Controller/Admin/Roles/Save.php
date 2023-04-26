<?php

namespace App\Controller\Admin\Roles;

use App\Http\Request;
use App\Model\Role\Repository;
use App\View\View;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        $arguments = [
            'title' => 'Novo Usuário',
            'roleSavePath' => 'roles/save',
            'roleSavePost' => 'roles/savePost',
            'roleDeletePath' => 'roles/delete',
            'roleListingPath' => 'roles/listing',
            'name' => '',
            'enabled' => '',
            'disabled' => '',
        ];

        $roleRepository = new Repository();
        $entityRole = $roleRepository->load((int) $request->getQueryParam('id'));

        if ($entityRole && $entityRole->getId()) {
            $arguments['title'] = 'Editar usuário';
            $arguments['name'] = $entityRole->getName();
            $arguments['enabled'] = $entityRole->isEnabled() ? 'checked' : '';
            $arguments['disabled'] = !$entityRole->isEnabled() ? 'checked' : '';
        }

        $content = View::render(
            'contents/roles/save',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
