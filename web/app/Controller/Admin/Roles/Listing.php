<?php

namespace App\Controller\Admin\Roles;

use App\Http\Request;
use App\Model\Role\Repository;
use App\Model\Pagination;
use App\View\View;
use App\Model\Role\Entity;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    protected const QTY_COLUMNS = 4;

    public static function execute(Request $request): string
    {
        $currentPage = (int) $request->getQueryParam('p') ?? 1;

        $roleRepository = new Repository();
        $tableSize = $roleRepository->count();

        $pagination = new Pagination('roles/listing', $tableSize, $currentPage);

        $roleCollection = $roleRepository->getCollection(
            '*',
            null,
            null,
            $pagination->getLimit()
        );

        $roleCollection ?
            self::$items = self::renderItems($roleCollection) :
            self::$emptyList = self::getEmptyItems();

        $arguments = [
            'title' => 'Listagem dos Papéis de Usuário',
            'roleListingPath' => 'roles/listing',
            'roleSavePath' => 'roles/save',
            'items' => self::$items,
            'emptyList' => self::$emptyList,
            'pagination' => $pagination->isPaginationNeedToBeRendered() ? $pagination->getPaginationHtml() : ''
        ];

        $content = View::render(
            'contents/roles/listing',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }

    protected static function renderItems(array $roleCollection): string
    {
        /** @var Entity $role */
        foreach ($roleCollection as $role) {
            self::$items .= View::render(
                'contents/roles/item',
                self::AREA_ADMIN_HOMEPAGE,
                [
                    'roleSavePath' => 'roles/save',
                    'roleDeletePath' => 'roles/deletePost',
                    'id' => $role->getId(),
                    'name' => $role->getName(),
                    'isEnabled' => $role->getStatus()
                ]
            );
        }

        return self::$items;
    }
}
