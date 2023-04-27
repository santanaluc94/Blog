<?php

namespace App\Controller\Admin\Posts;

use App\Http\Request;
use App\Model\Post\Repository;
use App\Model\Post\Entity;
use App\Model\Category\Repository as CategoryRepository;
use App\Model\Category\Entity as CategoryEntity;
use App\View\View;
use Exception;

class Save extends \App\Controller\Admin\AbstractAdminPage
{
    protected static string $categoryOptions = '';
    protected static string $statusOptions = '';
    protected static bool $categoryFlag = true;
    protected static bool $statusFlag = true;
    protected static array $aclAreaMandatory = [
        'area' => 'post',
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

            $categoryId = 0;
            $statusId = -1;
            $arguments = [
                'title' => 'Nova Postagem',
                'postSavePath' => 'posts/save',
                'postSavePost' => 'posts/savePost',
                'postDeletePath' => 'posts/delete',
                'postListingPath' => 'posts/listing',
                'id' => '',
                'postTitle' => '',
                'categoryId' => '',
                'content' => '',
                'categoryOptions' => '',
                'categoryOptionsSelected' => '',
                'statusId' => '',
                'status' => '',
                'statusOptionsSelected' => ''
            ];

            $postRepository = new Repository();
            $entityRole = $postRepository->load((int) $id);

            if ($entityRole && $entityRole->getId()) {
                $arguments['title'] = 'Editar Postagem';
                $arguments['id'] = $entityRole->getId();
                $arguments['postTitle'] = $entityRole->getTitle();
                $arguments['lastname'] = $categoryId = $entityRole->getCategoryId();
                $arguments['statusId'] = $statusId = $entityRole->getStatus();
                $arguments['status'] = $entityRole->getStatusName();
                $arguments['content'] = $entityRole->getContent();
            }

            $arguments['categoryOptions'] = self::renderCategoryOptions($categoryId);
            $arguments['statusOptions'] = self::renderStatusOptions($statusId);

            if (self::$categoryFlag) {
                $arguments['optionsSelected'] = 'selected';
            }

            if (self::$statusFlag) {
                $arguments['statusOptionsSelected'] = 'selected';
            }

            $content = View::render(
                'contents/posts/save',
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

    protected static function renderCategoryOptions(int $categoryId): string
    {
        $categoryRepository = new CategoryRepository();
        $categoryCollection = $categoryRepository->getCollection();

        if ($categoryCollection) {
            /** @var CategoryEntity $category */
            foreach ($categoryCollection as $category) {
                $isSelected = '';

                if ($category->getId() === $categoryId) {
                    $isSelected = 'selected';
                    self::$categoryFlag = false;
                }

                self::$categoryOptions .= View::render(
                    'option',
                    self::AREA_ADMIN_HOMEPAGE,
                    [
                        'id' => $category->getId(),
                        'name' => $category->getName(),
                        'idSelected' => $isSelected
                    ]
                );
            }
        }

        return self::$categoryOptions;
    }

    protected static function renderStatusOptions(int $statusId): string
    {
        foreach (Entity::VALID_STATUS as $id => $name) {
            $isSelected = '';
            if ($id === $statusId) {
                $isSelected = 'selected';
                self::$statusFlag = false;
            }

            self::$statusOptions .= View::render(
                'option',
                self::AREA_ADMIN_HOMEPAGE,
                [
                    'id' => $id,
                    'name' => $name,
                    'idSelected' => $isSelected
                ]
            );
        }

        return self::$statusOptions;
    }
}
