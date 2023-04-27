<?php

namespace App\Controller\Site;

use App\View\View;
use App\Http\Request;
use App\Model\Category\Repository;
use App\Model\Category\Entity;

abstract class AbstractPage
{
    public const AREA_FRONT_HOMEPAGE = 'front';
    protected static Request $request;
    protected static string $categoryItems = '';

    abstract public static function execute(Request $request): string;

    public static function getPage(
        string $title,
        string $content
    ): string {
        $arguments = [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ];

        return View::render(
            'page',
            self::AREA_FRONT_HOMEPAGE,
            $arguments
        );
    }

    protected static function getHeader(): string
    {
        $categoryRepository = new Repository();
        $categoryCollection = $categoryRepository->getCollection();

        return View::render(
            'header',
            self::AREA_FRONT_HOMEPAGE,
            [
                'isHomeActive' => self::$request->getUri() === '/' ? 'active' : '',
                'categoriesList' => !empty($categoryCollection) ? self::renderCategoryItems($categoryCollection) : ''
            ]
        );
    }

    protected static function getFooter(): string
    {
        return View::render('footer');
    }

    protected static function setRequest($request)
    {
        self::$request = $request;
    }

    protected static function renderCategoryItems(array $collection): string
    {
        /** @var Entity $category */
        foreach ($collection as $category) {
            self::$categoryItems .= View::render(
                'navbarDropdownItem',
                self::AREA_FRONT_HOMEPAGE,
                [
                    'id' => $category->getId(),
                    'categorySlug' => 'categories/' .$category->getSlug(),
                    'categoryName' => $category->getName()
                ]
            );
        }

        return self::$categoryItems;
    }
}
