<?php

namespace App\Controller\Admin\Users;

use App\Http\Request;
use App\Model\User\Repository;
use Exception;

class DeletePost extends \App\Controller\Admin\AbstractAdminPost
{
    public static function execute(Request $request): string
    {
        try {
            $entityId = $request->getQueryParam('id');

            if (!$entityId) {
                throw new Exception(
                    'Não é possível deletar um usuário sem passar o ID.',
                    400
                );
            }

            if (!filter_var($entityId, FILTER_VALIDATE_INT)) {
                throw new Exception('O ID informado não é válido.', 400);
            }

            $repository = new Repository();

            if (!$repository->removeById($entityId)) {
                throw new Exception(
                    "Não foi possível deletar o usuário com o ID {$entityId}.",
                    400
                );
            }

            // TODO: Implementar Log
            // TODO: Implementar flash messages
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages
        }

        return URL . '/admin/users/listing';
    }
}
