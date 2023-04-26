<?php

namespace App\Controller\Admin\Users;

use App\Http\Request;
use App\Model\User\Repository;
use App\Model\Pagination;
use App\Model\User\Entity;
use App\View\View;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    protected const QTY_COLUMNS = 6;

    public static function execute(Request $request): string
    {
        $currentPage = (int) $request->getQueryParam('p') ?? 1;

        $userRepository = new Repository();
        $tableSize = $userRepository->count();

        $pagination = new Pagination('users/listing', $tableSize, $currentPage);

        $userCollection = $userRepository->getCollection(
            '*',
            null,
            null,
            $pagination->getLimit(),
        );

        $userCollection ?
            self::$items = self::renderItems($userCollection) :
            self::$emptyList = self::getEmptyItems();

        $arguments = [
            'title' => 'Listagem dos Usuários',
            'userSavePath' => 'users/save',
            'userDeletePath' => 'users/delete',
            'userListingPath' => 'users/listing',
            'items' => self::$items,
            'emptyList' => self::$emptyList,
            'pagination' => $pagination->getPaginationHtml()
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

    protected static function renderItems(array $userCollection): string
    {
        /** @var Entity $user */
        foreach ($userCollection as $user) {
            self::$items .= View::render(
                'contents/users/item',
                self::AREA_ADMIN_HOMEPAGE,
                [
                    'userSavePath' => 'users/save',
                    'userDeletePath' => 'users/deletePost',
                    'id' => $user->getId(),
                    'fullname' => $user->getFullname(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRoleName(),
                    'createdAt' => $user->getCreatedAt(),
                    'updatedAt' => $user->getUpdatedAt()
                ]
            );
        }

        return self::$items;
    }

    protected static function getEmptyItems(): string
    {
        return View::render(
            'emptyList',
            self::AREA_ADMIN_HOMEPAGE,
            ['qtyColumns' => self::QTY_COLUMNS]
        );
    }
}
