<?php

namespace App\Controller\Admin;

use App\Model\AdminSession;
use App\Model\Role\Entity as RoleEntity;
use Exception;

abstract class AbstractAdmin
{
    public const AREA_ADMIN_HOMEPAGE = 'admin';

    protected static array $aclAreaMandatory = [
        'area' => 'admin',
        'permission' => 'read'
    ];

    protected static function init(array $aclAreaMandatory = []): void
    {
        if (!empty($aclAreaMandatory)) {
            self::$aclAreaMandatory = $aclAreaMandatory;
        }

        if (!AdminSession::isLoggedIn()) {
            throw new Exception(
                'Este usuário não possui acesso a essa rota.',
                401
            );
        }

        /** @var RoleEntity $roleSession */
        $roleSession = AdminSession::getSession()['role'];

        if (
            !$roleSession->getId() ||
            !self::isAllowed($roleSession->getPermissionsArray(), self::$aclAreaMandatory)
        ) {
            throw new Exception(
                'Este usuário não possui acesso a essa rota.',
                401
            );
        }
    }

    protected static function isAllowed(array $permissions): bool
    {
        if (empty(self::$aclAreaMandatory)) {
            return true;
        }

        if (
            isset($permissions[self::AREA_ADMIN_HOMEPAGE]) &&
            isset($permissions[self::AREA_ADMIN_HOMEPAGE])
        ) {
            $adminPermissions = $permissions[self::AREA_ADMIN_HOMEPAGE];

            if (
                self::$aclAreaMandatory['area'] === 'admin' &&
                self::$aclAreaMandatory['permission'] === 'read' &&
                $adminPermissions == true
            ) {
                return true;
            }

            if (
                self::$aclAreaMandatory['permission'] === 'read' &&
                isset($adminPermissions[self::$aclAreaMandatory['area']]) &&
                ($adminPermissions[self::$aclAreaMandatory['area']] == true ||
                    is_array($adminPermissions[self::$aclAreaMandatory['area']])
                )
            ) {
                return true;
            }

            if (
                (self::$aclAreaMandatory['permission'] === 'save' || self::$aclAreaMandatory['permission'] === 'delete') &&
                isset($adminPermissions[self::$aclAreaMandatory['area']]) &&
                is_array($adminPermissions[self::$aclAreaMandatory['area']]) &&
                isset($adminPermissions[self::$aclAreaMandatory['area']]['read'][self::$aclAreaMandatory['permission']]) &&
                $adminPermissions[self::$aclAreaMandatory['area']]['read'][self::$aclAreaMandatory['permission']] == true
            ) {
                return true;
            }
        }

        return false;
    }
}
