<?php

namespace App\Model\Role;

use App\Model\RepositoryInterface;
use App\Model\EntityInterface;
use App\Model\AbstractDatabase;
use App\Model\Role\Entity;

class Repository extends AbstractDatabase implements RepositoryInterface
{
    public const TABLE_NAME = 'role';

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
                throw new \Exception(
                    "Não foi possível salvar o objeto para a tabela {$this->table}."
                );
            }

            return $this->populateEntityWithData($entityData);
        } catch (\Exception $exception) {
            // TODO: Implementar Log
        }

        return null;
    }

    public function load(int $id): ?Entity
    {
        try {
            $entityData = $this->selectById($id);

            if (is_bool($entityData) || !isset($entityData['id']) && is_null($entityData['id'])) {
                throw new \Exception(
                    "Não foi possível encontrar um objeto com o ID {$id} para a tabela {$this->table}."
                );
            }

            return $this->populateEntityWithData($entityData);
        } catch (\Exception $exception) {
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
        } catch (\Exception $exception) {
            // TODO: Implementar Log
        }

        return null;
    }

    protected function populateEntityWithData(array $entityData): Entity
    {
        return new Entity(
            $entityData[Entity::NAME],
            $entityData[Entity::PERMISSIONS],
            $entityData[Entity::IS_ENABLED],
            $entityData[Entity::ID]
        );
    }
}
