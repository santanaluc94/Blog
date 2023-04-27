<?php

namespace App\Controller\Admin\Categories;

use App\Controller\Admin\{
    AbstractAdminPost,
    PostInterface
};
use App\Http\Request;
use App\Model\Category\{
    Entity,
    Repository
};
use Exception;

class SavePost extends AbstractAdminPost implements PostInterface
{
    protected static array $aclAreaMandatory = [
        'area' => 'category',
        'permission' => 'save'
    ];

    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);
            $categoryData = $request->getPostVars();
            self::sanitizeFields($categoryData);
            $categoryRepository = new Repository();

            if (isset($categoryData['id']) && $categoryData['id']) {
                if (!filter_var($categoryData['id'], FILTER_VALIDATE_INT)) {
                    throw new Exception('O campo id não foi preenchido corretamente.', 400);
                }

                $id = (int) $categoryData['id'];

                $entity = $categoryRepository->load($id);
                $entity->setId($id)
                    ->setName($categoryData['category_name'])
                    ->setSlug($categoryData['category_slug']);
            } else {
                $entity = new Entity(
                    $categoryData['category_name'],
                    $categoryData['category_slug']
                );
            }

            if (!$categoryRepository->save($entity)) {
                throw new Exception(
                    "Não foi possível salvar a categoria com os dados passados.",
                    400
                );
            }
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages

            $request->getRouter()->redirect('/admin/categories/save');
            exit();
        }

        return URL . '/admin/categories/listing';
    }

    public static function sanitizeFields(array &$data): void
    {
        if (
            !isset($data['category_name']) ||
            !is_string($data['category_name'])
        ) {
            throw new Exception('O campo nome não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['category_slug']) ||
            !is_string($data['category_slug'])
        ) {
            throw new Exception('O campo slug não foi preenchido corretamente.', 400);
        }

        $data['category_name'] = htmlspecialchars($data['category_name']);
        $data['category_slug'] = htmlspecialchars($data['category_slug']);
    }
}
