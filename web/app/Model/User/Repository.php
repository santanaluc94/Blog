<?php

namespace App\Model\User;

use App\Model\RepositoryInterface;
use App\Model\EntityInterface;
use App\Model\AbstractDatabase;
use App\Model\User\Entity;
use Exception;

class Repository extends AbstractDatabase implements RepositoryInterface
{
    public const TABLE_NAME = 'user';

    protected function setTableName(): void
    {
        $this->table = self::TABLE_NAME;
    }

    public function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    public function save(Entity|EntityInterface $entity): ?Entity
    {
        try {
            $entityData = $entity->getId() ?
                $this->update($entity->getData()) :
                $this->insert($entity->getData());

            if (!isset($entityData['id']) && is_null($entityData['id'])) {
                throw new Exception(
                    "Não foi possível salvar o objeto para a tabela {$this->table}."
                );
            }

            return $this->populateEntityWithData($entityData);
        } catch (Exception $exception) {
            // TODO: Implementar Log
        }

        return null;
    }

    public function load(int $id): ?Entity
    {
        try {
            $entityData = $this->selectById($id);

            if (!isset($entityData['id']) && is_null($entityData['id'])) {
                throw new Exception(
                    "Não foi possível encontrar um objeto com o ID {$id} para a tabela {$this->table}."
                );
            }

            return $this->populateEntityWithData($entityData);
        } catch (Exception $exception) {
            // TODO: Implementar Log
        }

        return null;
    }

    public function removeById(int $id): bool
    {
        return $this->deleteById($id);
    }

    public function getCollection(
        string $fields = '*',
        ?string $where = null,
        ?string $order = null,
        ?string $limit = null,
        ?string $offset = null
    ): ?array {
        try {
            $collectionData = $this->select(
                $fields,
                $where,
                $order,
                $limit,
                $offset
            );

            $collection = [];

            if (!count($collectionData)) {
                return $collection;
            }

            foreach ($collectionData as $entityData) {
                $collection[] = $this->populateEntityWithData($entityData);
            }

            return $collection;
        } catch (Exception $exception) {
            // TODO: Implementar Log
        }

        return null;
    }

    protected function populateEntityWithData(array $entityData): Entity
    {
        $entity = new Entity(
            $entityData[Entity::FIRSTNAME],
            $entityData[Entity::LASTNAME],
            $entityData[Entity::EMAIL],
            $entityData[Entity::ROLE_ID],
            '',
            $entityData[Entity::ID]
        );
        return $entity->setCreatedAt($entityData[Entity::CREATED_AT])
            ->setUpdatedAt($entityData[Entity::UPDATED_AT]);
    }

    public function getByEmail(string $email): ?Entity
    {
        try {
            $entityData = $this->select(
                '*',
                "email = '{$email}'",
            );

            if (
                empty($entityData) ||
                !is_array($entityData)
            ) {
                throw new Exception(
                    "Não foi possível encontrar um objeto com o email '{$email}' na tabela {$this->table}.",
                    400
                );
            }

            $entityData = reset($entityData);

            if (
                empty($entityData) ||
                !isset($entityData['id']) &&
                is_null($entityData['id'])
            ) {
                throw new Exception(
                    "Não foi possível encontrar um objeto com o email '{$email}' na tabela {$this->table}.",
                    400
                );
            }

            $entity = $this->populateEntityWithData($entityData);
            return $entity->setPassword($entityData[Entity::PASSWORD]);
        } catch (Exception $exception) {
            // TODO: Implementar Log
        }

        return null;
    }
}
