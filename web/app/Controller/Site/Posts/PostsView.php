<?php

namespace App\Controller\Site\Posts;

use App\View\View;
use App\Http\Request;
use App\Model\Post\Repository;
use Exception;

class PostsView extends \App\Controller\Site\AbstractPage
{
    protected static Request $request;

    public static function execute(Request $request): string
    {
        try {
            self::setRequest($request);

            $entityId = $request->getQueryParam('id');

            if (!$entityId) {
                throw new Exception(
                    'Não é possível deletar uma postagem sem passar o ID.',
                    400
                );
            }

            if (!filter_var($entityId, FILTER_VALIDATE_INT)) {
                throw new Exception('O ID informado não é válido.', 400);
            }

            $postRepository = new Repository();
            $post = $postRepository->load($entityId);

            if (!$post->isShowInSite()) {
                throw new Exception('Esta postagem não pode ser acessada.', 401);
            }

            $arguments = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'postCategoryName' => $post->getCategoryName(),
                'postUserName' => $post->getUserName(),
                'postContent' => $post->getContent(),
                'categorySlug' => 'categories/' . $post->getCategory()->getSlug(),
            ];

            $content = View::render(
                'contents/posts/view',
                self::AREA_FRONT_HOMEPAGE,
                $arguments
            );

            return parent::getPage($arguments['title'], $content);
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages
        }

        $request->getRouter()->redirect('/admin/posts/listing');
        exit();
    }
}
