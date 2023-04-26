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
            $arguments['id'] = $entityRole->getId();
            $arguments['title'] = 'Editar usuário';
            $arguments['roleSavePost'] = 'roles/savePost/' . $entityRole->getId();
            $arguments['name'] = $entityRole->getName();
            $arguments['enabled'] = $entityRole->isEnabled() ? 'checked' : '';
            $arguments['disabled'] = !$entityRole->isEnabled() ? 'checked' : '';
            $arguments['role_permissions_site'] = '';
            $arguments['role_permissions_admin'] = '';
            $arguments['role_permissions_admin_category'] = '';
            $arguments['role_permissions_admin_category_save'] = '';
            $arguments['role_permissions_admin_category_delete'] = '';
            $arguments['role_permissions_admin_page'] = '';
            $arguments['role_permissions_admin_page_save'] = '';
            $arguments['role_permissions_admin_page_delete'] = '';
            $arguments['role_permissions_admin_post'] = '';
            $arguments['role_permissions_admin_post_save'] = '';
            $arguments['role_permissions_admin_post_delete'] = '';
            $arguments['role_permissions_admin_user'] = '';
            $arguments['role_permissions_admin_user_save'] = '';
            $arguments['role_permissions_admin_user_delete'] = '';

            self::mapPermissions(json_decode($entityRole->getPermissions(), true), $arguments);
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

    protected static function mapPermissions(array $permissions, &$arguments): array
    {
        // Permission site
        if (isset($permissions['site']) && $permissions['site']) {
            $arguments['role_permissions_site'] = 'checked';
        }

        // Permission Admin
        if (isset($permissions['admin']) && $permissions['admin']) {
            $arguments['role_permissions_admin'] = 'checked';

            // Permission Category
            if (isset($permissions['admin']['category']) && $permissions['admin']['category']) {
                $arguments['role_permissions_admin_category'] = 'checked';

                if (isset($permissions['admin']['category']['save']) && $permissions['admin']['category']['save']) {
                    $arguments['role_permissions_admin_category_save'] = 'checked';
                }

                if (isset($permissions['admin']['category']['delete']) && $permissions['admin']['category']['delete']) {
                    $arguments['role_permissions_admin_category_delete'] = 'checked';
                }
            }

            // Permission Page
            if (isset($permissions['admin']['page']) && $permissions['admin']['page']) {
                $arguments['role_permissions_admin_page'] = 'checked';

                if (isset($permissions['admin']['page']['save']) && $permissions['admin']['page']['save']) {
                    $arguments['role_permissions_admin_page_save'] = 'checked';
                }

                if (isset($permissions['admin']['page']['delete']) && $permissions['admin']['page']['delete']) {
                    $arguments['role_permissions_admin_page_delete'] = 'checked';
                }
            }

            // Permission Post
            if (isset($permissions['admin']['post']) && $permissions['admin']['post']) {
                $arguments['role_permissions_admin_post'] = 'checked';

                if (isset($permissions['admin']['post']['save']) && $permissions['admin']['post']['save']) {
                    $arguments['role_permissions_admin_post_save'] = 'checked';
                }

                if (isset($permissions['admin']['post']['delete']) && $permissions['admin']['post']['delete']) {
                    $arguments['role_permissions_admin_post_delete'] = 'checked';
                }
            }

            // Permission User
            if (isset($permissions['admin']['user']) && $permissions['admin']['user']) {
                $arguments['role_permissions_admin_user'] = 'checked';

                if (isset($permissions['admin']['user']['save']) && $permissions['admin']['user']['save']) {
                    $arguments['role_permissions_admin_user_save'] = 'checked';
                }

                if (isset($permissions['admin']['user']['delete']) && $permissions['admin']['user']['delete']) {
                    $arguments['role_permissions_admin_user_delete'] = 'checked';
                }
            }
        }

        return $arguments;
    }
}
