<?php

namespace App\Controller\Admin\Categories;

use App\Http\Request;
use App\Model\Category\Repository;
use App\Model\Pagination;
use App\View\View;
use App\Model\Category\Entity;
use Exception;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    protected const QTY_COLUMNS = 5;

    protected static array $aclAreaMandatory = [
        'area' => 'category',
        'permission' => 'read'
    ];

    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);

            $currentPage = (int) $request->getQueryParam('p') ?? 1;

            $categoryRepository = new Repository();
            $tableSize = $categoryRepository->count();

            $pagination = new Pagination('categories/listing', $tableSize, $currentPage);

            $categoryCollection = $categoryRepository->getCollection(
                '*',
                null,
                null,
                $pagination->getLimit()
            );

            $categoryCollection ?
                self::$items = self::renderItems($categoryCollection) :
                self::$emptyList = self::getEmptyItems();

            $arguments = [
                'title' => 'Listagem das Categorias',
                'categorySavePath' => 'categories/save',
                'categoryDeletePath' => 'categories/delete',
                'categoryListingPath' => 'categories/listing',
                'items' => self::$items,
                'emptyList' => self::$emptyList,
                'pagination' => $pagination->isPaginationNeedToBeRendered() ? $pagination->getPaginationHtml() : ''
            ];

            $content = View::render(
                'contents/categories/listing',
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

    protected static function renderItems(array $categoryCollection): string
    {
        /** @var Entity $category */
        foreach ($categoryCollection as $category) {
            self::$items .= View::render(
                'contents/categories/item',
                self::AREA_ADMIN_HOMEPAGE,
                [
                    'categorySavePath' => 'categories/save',
                    'categoryDeletePath' => 'categories/deletePost',
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'slug' => $category->getSlug(),
                    'createdAt' => $category->getCreatedAt(),
                    'updatedAt' => $category->getUpdatedAt()
                ]
            );
        }

        return self::$items;
    }
}
