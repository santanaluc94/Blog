<?php

namespace App\Model;

use PDO;
use PDOStatement;
use Exception;
use PDOException;

abstract class AbstractDatabase
{
    protected string $db;
    protected PDO $connection;

    public function __construct(
        protected string $table = ''
    ) {
        $this->db = getenv('DB_NAME');
        $this->table = $this->getTableName();
        $this->setConnection();
    }

    protected abstract function setTableName(): void;

    protected abstract function getTableName(): string;

    protected function setConnection(): void
    {
        try {
            $this->connection = new PDO(
                'mysql:host=db;dbname=' . getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASSWORD')
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $exception) {
            // TODO: Implementar Log (Não funcionou a conexão com o banco'.)
        }
    }

    protected function execute(string $query, array $params = []): PDOStatement
    {
        try {
            $pdoStatement = $this->connection->prepare($query);
            $pdoStatement->execute($params);
            return $pdoStatement;
        } catch (Exception $exception) {
            // TODO: Implementar Log (Não foi possíel persistir no banco'.)
        }
    }

    protected function select(
        string $fields = '*',
        ?string $where = null,
        ?string $order = null,
        ?string $limit = null
    ): array {
        $query = "SELECT {$fields} FROM {$this->db}.{$this->table}";

        if ($where) {
            $query .= " {$where}";
        }

        if ($order) {
            $query .= "ORDER BY {$order}";
        }

        if ($limit) {
            $query .= " LIMIT {$limit}";
        }

        $query .= ';';

        return $this->execute($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function selectById(?int $id): array|bool
    {
        if (!$id) {
            throw new Exception(
                'É necessário um ID para buscar um objeto específico do tipo entidade.',
                400
            );
        }

        $query = "SELECT * FROM {$this->db}.{$this->table} WHERE id = {$id};";

        return $this->execute($query)->fetch(PDO::FETCH_ASSOC);
    }

    protected function insert(array $values): array
    {
        $fields = implode(',', array_keys($values));
        $binds = implode(',', array_pad([], count($values), '?'));

        $query = "INSERT INTO {$this->db}.{$this->table} ({$fields}) VALUES ({$binds});";

        $this->execute($query, array_values($values));

        if (!is_numeric($this->connection->lastInsertId())) {
            throw new PDOException("Erro ao salvar entidade na tabela {$this->table}.", 400);
        }

        return $this->selectById((int) $this->connection->lastInsertId());
    }

    protected function update(array $values): array
    {
        if (!isset($values['id']) || !$values['id']) {
            throw new Exception(
                'É necessário um ID para atualizar um objeto do tipo entidade.',
                400
            );
        }

        $id = $values['id'];
        unset($values['id']);
        $fields = implode('=?,', array_keys($values)) . '=?';

        $query = "UPDATE {$this->db}.{$this->table} SET {$fields} WHERE id = {$id};";

        $this->execute($query, array_values($values));

        return $this->selectById($id);
    }

    protected function deleteById(int $id): bool
    {
        try {
            $query = "DELETE FROM {$this->db}.{$this->table} WHERE id = {$id};";

            $this->execute($query);

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    protected function count(): int
    {
        $query = "SELECT COUNT(*) FROM {$this->db}.{$this->table};";

        return $this->execute($query)->fetchColumn();
    }
}
