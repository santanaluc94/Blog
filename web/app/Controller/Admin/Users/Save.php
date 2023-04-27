<?php

namespace App\Controller\Admin\Users;

use App\Http\Request;
use App\Model\Role\Repository as RoleRepository;
use App\Model\User\Repository as UserRepository;
use App\View\View;
use Exception;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    protected static string $options = '';
    protected static bool $flag = true;

    public static function execute(Request $request): string
    {
        $id = $request->getQueryParam('id');

        if ($id && !is_numeric($id)) {
            throw new Exception('O ID informado não é válido.', 400);
        }

        $roleId = 0;
        $arguments = [
            'title' => 'Novo Usuário',
            'userSavePath' => 'users/save',
            'userSavePost' => 'users/savePost',
            'userDeletePath' => 'users/delete',
            'userListingPath' => 'users/listing',
            'id' => '',
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'roleId' => '',
            'optionsSelected' => ''
        ];

        $userRepository = new UserRepository();
        $entityRole = $userRepository->load((int) $id);

        if ($entityRole && $entityRole->getId()) {
            $arguments['title'] = 'Editar Usuário';
            $arguments['id'] = $entityRole->getId();
            $arguments['firstname'] = $entityRole->getFirstname();
            $arguments['lastname'] = $entityRole->getLastname();
            $arguments['email'] = $entityRole->getEmail();
            $arguments['roleId'] = $entityRole->getRoleId();
            $roleId = $entityRole->getRoleId();
        }

        $arguments['options'] = self::renderOptions($roleId);

        if (self::$flag) {
            $arguments['optionsSelected'] = 'selected';
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

    protected static function renderOptions(int $userRoleId): string
    {
        $roleRepository = new RoleRepository();
        $roleCollection = $roleRepository->getCollection();

        if ($roleCollection) {
            /** @var Entity $role */
            foreach ($roleCollection as $role) {
                $isSelected = '';

                if ($role->getId() === $userRoleId) {
                    $isSelected = 'selected';
                    self::$flag = false;
                }

                self::$options .= View::render(
                    'option',
                    self::AREA_ADMIN_HOMEPAGE,
                    [
                        'id' => $role->getId(),
                        'name' => $role->getName(),
                        'idSelected' => $isSelected
                    ]
                );
            }
        }

        return self::$options;
    }
}
