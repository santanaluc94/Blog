<?php

namespace App\Controller\Admin\Categories;

use App\Http\Request;
use App\Model\Category\Repository;
use App\View\View;
use Exception;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    protected static array $aclAreaMandatory = [
        'area' => 'category',
        'permission' => 'read'
    ];

    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);

            $id = $request->getQueryParam('id');

            if ($id && !is_numeric($id)) {
                throw new Exception('O ID informado não é válido.', 400);
            }

            $arguments = [
                'title' => 'Nova Categoria',
                'categorySavePath' => 'categories/save',
                'categorySavePost' => 'categories/savePost',
                'categoryDeletePath' => 'categories/delete',
                'categoryListingPath' => 'categories/listing',
                'id' => '',
                'name' => '',
                'slug' => ''
            ];

            $categoryRepository = new Repository();
            $entityRole = $categoryRepository->load((int) $id);

            if ($entityRole && $entityRole->getId()) {
                $arguments['title'] = 'Editar Categoria';
                $arguments['id'] = $entityRole->getId();
                $arguments['name'] = $entityRole->getName();
                $arguments['slug'] = $entityRole->getSlug();
            }

            $content = View::render(
                'contents/categories/save',
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
}
