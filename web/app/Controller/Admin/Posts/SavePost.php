<?php

namespace App\Controller\Admin\Posts;

use App\Controller\Admin\{
    AbstractAdminPost,
    PostInterface
};
use App\Http\Request;
use App\Model\AdminSession;
use App\Model\User\Entity as UserEntity;
use App\Model\Post\{
    Entity,
    Repository
};
use App\Model\Category\Repository as CategoryRepository;
use Exception;

class SavePost extends AbstractAdminPost implements PostInterface
{
    protected static array $aclAreaMandatory = [
        'area' => 'post',
        'permission' => 'save'
    ];

    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);

            /** @var UserEntity $userSession */
            $userSession = AdminSession::getSession()['user'];
            $postData = $request->getPostVars();
            self::sanitizeFields($postData);
            $postRepository = new Repository();

            if (isset($postData['id']) && $postData['id']) {
                if (!filter_var($postData['id'], FILTER_VALIDATE_INT)) {
                    throw new Exception('O campo id não foi preenchido corretamente.', 400);
                }

                $id = (int) $postData['id'];

                $entity = $postRepository->load($id);
                $entity->setId($id)
                    ->setTitle($postData['post_title'])
                    ->setCategoryId($postData['post_category_id'])
                    ->setUserId($userSession->getId())
                    ->setStatus($postData['post_status_id'])
                    ->setContent($postData['post_content']);
            } else {
                $entity = new Entity(
                    $postData['post_title'],
                    $postData['post_category_id'],
                    $userSession->getId(),
                    $postData['post_status_id'],
                    $postData['post_content']
                );
            }

            if (!$postRepository->save($entity)) {
                throw new Exception(
                    "Não foi possível salvar a postagem com os dados passados.",
                    400
                );
            }
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages

            $request->getRouter()->redirect('/admin/posts/save');
            exit();
        }

        return URL . '/admin/posts/listing';
    }

    public static function sanitizeFields(array &$data): void
    {
        if (
            !isset($data['post_title']) ||
            !is_string($data['post_title'])
        ) {
            throw new Exception('O campo título não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['post_category_id']) ||
            !filter_var($data['post_category_id'], FILTER_VALIDATE_INT)
        ) {
            throw new Exception('O campo categoria não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['post_status_id']) ||
            !is_numeric($data['post_status_id'])
        ) {
            throw new Exception('O campo status não foi preenchido corretamente.', 400);
        }

        if (
            !isset($data['post_content']) ||
            !is_string($data['post_content'])
        ) {
            throw new Exception('O campo conteúdo não foi preenchido corretamente.', 400);
        }

        $categoryId = (int) $data['post_category_id'];
        $categoryRepository = new CategoryRepository();
        $category = $categoryRepository->load($categoryId);

        $data['post_title'] = htmlspecialchars($data['post_title']);
        $data['post_category_id'] = $category->getId();
        $data['post_status_id'] = (int) $data['post_status_id'];
        $data['post_content'] = htmlspecialchars($data['post_content']);
    }
}
