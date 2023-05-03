<?php

namespace App\Controller\Admin\Roles;

use App\Http\Request;
use App\Model\Role\Repository;
use App\View\View;
use Exception;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    protected static array $aclAreaMandatory = [
        'area' => 'role',
        'permission' => 'read'
    ];

    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);

            $id = $request->getQueryParam('id');

            if ($id && !is_numeric($id)) {
                throw new Exception('O ID informado não é válido.', 400);
            }

            $arguments = [
                'title' => 'Novo Papel de Usuário',
                'roleSavePath' => 'roles/save',
                'roleSavePost' => 'roles/savePost',
                'roleDeletePath' => 'roles/delete',
                'roleListingPath' => 'roles/listing',
                'name' => '',
                'enabled' => '',
                'disabled' => '',
                'id' => ''
            ];

            $roleRepository = new Repository();
            $entityRole = $roleRepository->load((int) $id);

            if ($entityRole && $entityRole->getId()) {
                $arguments['id'] = $entityRole->getId();
                $arguments['title'] = 'Editar Papel de Usuário';
                $arguments['roleSavePost'] = 'roles/savePost/' . $entityRole->getId();
                $arguments['name'] = $entityRole->getName();
                $arguments['enabled'] = $entityRole->isEnabled() ? 'checked' : '';
                $arguments['disabled'] = !$entityRole->isEnabled() ? 'checked' : '';
                $arguments['role_permissions_site'] = '';
                $arguments['role_permissions_admin'] = '';
                $arguments['role_permissions_admin_category'] = '';
                $arguments['role_permissions_admin_category_save'] = '';
                $arguments['role_permissions_admin_category_delete'] = '';
                $arguments['role_permissions_admin_post'] = '';
                $arguments['role_permissions_admin_post_save'] = '';
                $arguments['role_permissions_admin_post_delete'] = '';
                $arguments['role_permissions_admin_user'] = '';
                $arguments['role_permissions_admin_user_save'] = '';
                $arguments['role_permissions_admin_user_delete'] = '';
                $arguments['role_permissions_admin_role'] = '';
                $arguments['role_permissions_admin_role_save'] = '';
                $arguments['role_permissions_admin_role_delete'] = '';

                self::mapPermissions(json_decode($entityRole->getPermissions(), true), $arguments);
            }

            $content = View::render(
                'contents/roles/save',
                self::AREA_ADMIN_HOMEPAGE,
                $arguments
            );
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages

            $request->getRouter()->redirect('/admin/index');
            exit();
        }

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

            // Permission Role
            if (isset($permissions['admin']['role']) && $permissions['admin']['role']) {
                $arguments['role_permissions_admin_role'] = 'checked';

                if (isset($permissions['admin']['role']['save']) && $permissions['admin']['role']['save']) {
                    $arguments['role_permissions_admin_role_save'] = 'checked';
                }

                if (isset($permissions['admin']['role']['delete']) && $permissions['admin']['role']['delete']) {
                    $arguments['role_permissions_admin_role_delete'] = 'checked';
                }
            }
        }

        return $arguments;
    }
}
