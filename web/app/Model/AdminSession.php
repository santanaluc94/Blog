<?php

namespace App\Model;

use App\Model\User\Entity as UserEntity;

class AdminSession
{
    protected static function init(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function setSession(UserEntity $userEntity): void
    {
        self::init();

        $_SESSION['admin']['user'] = $userEntity;
        $_SESSION['admin']['role'] = $userEntity->getRole();
    }

    public static function getSession(): array
    {
        self::init();

        return isset($_SESSION['admin']) ? $_SESSION['admin'] : [];
    }

    public static function unsetSession(): void
    {
        if (self::isLoggedIn()) {
            unset($_SESSION['admin']);
        }
    }

    public static function isLoggedIn(): bool
    {
        self::init();

        if (
            !isset($_SESSION['admin']) ||
            !isset($_SESSION['admin']['user']) ||
            !isset($_SESSION['admin']['role'])
        ) {
            return false;
        }

        /** @var UserEntity $userEntity */
        $userEntity = $_SESSION['admin']['user'];

        return $userEntity->getId() ? true : false;
    }
}
