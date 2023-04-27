<?php

namespace App\Controller\Admin\Posts;

use App\Http\Request;
use App\Model\Post\Repository;
use App\Model\Pagination;
use App\View\View;
use App\Model\Post\Entity;

class Listing extends \App\Controller\Admin\AbstractAdminPage
{
    protected const QTY_COLUMNS = 7;

    public static function execute(Request $request): string
    {
        $currentPage = (int) $request->getQueryParam('p') ?? 1;

        $postRepository = new Repository();
        $tableSize = $postRepository->count();

        $pagination = new Pagination('posts/listing', $tableSize, $currentPage);

        $postCollection = $postRepository->getCollection(
            '*',
            null,
            null,
            $pagination->getLimit()
        );

        $postCollection ?
            self::$items = self::renderItems($postCollection) :
            self::$emptyList = self::getEmptyItems();

        $arguments = [
            'title' => 'Listagem das Postasgens',
            'postSavePath' => 'posts/save',
            'postDeletePath' => 'posts/delete',
            'postListingPath' => 'posts/listing',
            'items' => self::$items,
            'emptyList' => self::$emptyList,
            'pagination' => $pagination->isPaginationNeedToBeRendered() ? $pagination->getPaginationHtml() : ''
        ];

        $content = View::render(
            'contents/posts/listing',
            self::AREA_ADMIN_HOMEPAGE,
            $arguments
        );

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }

    protected static function renderItems(array $postCollection): string
    {
        /** @var Entity $post */
        foreach ($postCollection as $post) {
            self::$items .= View::render(
                'contents/posts/item',
                self::AREA_ADMIN_HOMEPAGE,
                [
                    'postSavePath' => 'posts/save',
                    'postDeletePath' => 'posts/deletePost',
                    'id' => $post->getId(),
                    'title' => $post->getTitle(),
                    'userName' => $post->getUserName(),
                    'categoryName' => $post->getCategoryName(),
                    'status' => $post->getStatusName(),
                    'createdAt' => $post->getCreatedAt(),
                    'updatedAt' => $post->getUpdatedAt()
                ]
            );
        }

        return self::$items;
    }
}
