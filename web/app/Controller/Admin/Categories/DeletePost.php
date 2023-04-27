<?php

namespace App\Controller\Admin\Categories;

use App\Http\Request;
use App\Model\Category\Repository;
use Exception;

class DeletePost extends \App\Controller\Admin\AbstractAdminPost
{
    protected static array $aclAreaMandatory = [
        'area' => 'category',
        'permission' => 'delete'
    ];

    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);

            $entityId = $request->getQueryParam('id');

            if (!$entityId) {
                throw new Exception(
                    'Não é possível deletar uma categoria sem passar o ID.',
                    400
                );
            }

            if (!filter_var($entityId, FILTER_VALIDATE_INT)) {
                throw new Exception('O ID informado não é válido.', 400);
            }

            $repository = new Repository();

            if (!$repository->removeById($entityId)) {
                throw new Exception(
                    "Não foi possível deletar a categoria com o ID {$entityId}.",
                    400
                );
            }

            // TODO: Implementar Log
            // TODO: Implementar flash messages
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages

            $request->getRouter()->redirect('/admin/categories/listing');
            exit();
        }

        return URL . '/admin/categories/listing';
    }
}
