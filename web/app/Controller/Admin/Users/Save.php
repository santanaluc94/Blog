<?php

namespace App\Controller\Admin\Users;

use App\Http\Request;
use App\Model\Role\Repository as RoleRepository;
use App\Model\User\Repository as UserRepository;
use App\View\View;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    protected static string $options = '';

    public static function execute(Request $request): string
    {
        $roleRepository = new RoleRepository();
        $roleCollection = $roleRepository->getCollection();

        if ($roleCollection) {
            self::$options = self::renderOptions($roleCollection);
        }

        $arguments = [
            'title' => 'Novo Usuário',
            'userSavePath' => 'users/save',
            'userSavePost' => 'users/savePost',
            'userDeletePath' => 'users/delete',
            'userListingPath' => 'users/listing',
            'options' => self::$options,
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'role_id' => '',
        ];

        $userRepository = new UserRepository();
        $entityRole = $userRepository->load((int) $request->getQueryParam('id'));

        if ($entityRole && $entityRole->getId()) {
            $arguments['title'] = 'Editar usuário';
            $arguments['firstname'] = $entityRole->getFirstname();
            $arguments['lastname'] = $entityRole->getLastname();
            $arguments['email'] = $entityRole->getEmail();
            $arguments['role_id'] = $entityRole->getRoleId();
        }

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

    protected static function renderOptions(
        array $roleCollection,
        int $userRoleId = 0
    ): string {
        /** @var Entity $role */
        foreach ($roleCollection as $role) {
            self::$options .= View::render(
                'contents/users/option',
                self::AREA_ADMIN_HOMEPAGE,
                [
                    'roleId' => $role->getId(),
                    'roleName' => $role->getName(),
                    'idSelected' => ($role->getId() === $userRoleId) ? 'selected' : ''
                ]
            );
        }

        return self::$options;
    }
}
