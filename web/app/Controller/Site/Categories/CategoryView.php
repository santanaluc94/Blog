<?php

namespace App\Controller\Site\Categories;

use App\View\View;
use App\Http\Request;
use App\Model\Category\Repository;
use App\Model\Post\Repository as PostRepository;
use App\Model\Post\Entity;

class CategoryView extends \App\Controller\Site\AbstractPage
{
    protected const POST_CONTENT_WORDS_LIMIT = 30;
    protected static Request $request;
    protected static string $items = '';

    public static function execute(Request $request): string
    {
        self::setRequest($request);

        $slug = $request->getQueryParam('id');

        $categoryRepository = new Repository();
        $category = $categoryRepository->getBySlug($slug);

        $postRepository = new PostRepository();
        $postCollection = $postRepository->getPostCollectionByCategoryId(
            $category->getId(),
            3
        );

        $arguments = [
            'title' => $category->getName(),
            'posts' => !empty($postCollection) ? self::renderItems($postCollection) : ''
        ];

        $content = View::render(
            'contents/categories/view',
            self::AREA_FRONT_HOMEPAGE,
            $arguments
        );

        return parent::getPage($arguments['title'], $content);
    }

    protected static function renderItems(array $collection): string
    {
        /** @var Entity $post */
        foreach ($collection as $post) {
            if ($post->isShowInSite()) {
                if (str_word_count($post->getContent(), 0) > self::POST_CONTENT_WORDS_LIMIT) {
                    $words = str_word_count($post->getContent(), 2);
                    $pos = array_keys($words);
                    $text = substr($post->getContent(), 0, $pos[self::POST_CONTENT_WORDS_LIMIT]) . '...';
                }

                self::$items .= View::render(
                    'contents/posts/card',
                    self::AREA_FRONT_HOMEPAGE,
                    [
                        'id' => $post->getId(),
                        'postTitle' => $post->getTitle(),
                        'postCategoryName' => $post->getCategoryName(),
                        'postUserName' => $post->getUserName(),
                        'postContent' => $text,
                        'postPath' => 'posts/view'
                    ]
                );
            }
        }

        return self::$items;
    }
}
