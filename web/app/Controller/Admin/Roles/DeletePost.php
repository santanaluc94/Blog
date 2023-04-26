<?php

namespace App\Controller\Admin\Roles;

use App\Http\Request;
use App\Model\Role\Entity;
use App\Model\Role\Repository;
use Exception;

class DeletePost extends \App\Controller\Admin\AbstractAdminPost
{
    public static function execute(Request $request): string
    {
        try {
            $entityId = (int) $request->getQueryParam('id');

            if (!$entityId) {
                throw new Exception('Não é possível deletar um objeto sem passar o ID.', 400);
            }

            $roleRepository = new Repository();
            if (!$roleRepository->removeById($entityId)) {
                throw new Exception(
                    "Não foi possível deletar o usuário com o ID {$entityId}.",
                    404
                );
            }
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages
        }

        return URL . '/admin/roles/listing';
    }
}
