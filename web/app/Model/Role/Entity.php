<?php

namespace App\Model\Role;

use App\Model\EntityInterface;

class Entity implements EntityInterface
{
    public const ID = 'id';
    public const NAME = 'name';
    public const PERMISSIONS = 'permissions';
    public const IS_ENABLED = 'is_enabled';
    protected const HAS_PERMISSION = 'on';

    public function __construct(
        protected string $name,
        protected string $permissions,
        protected int $isEnabled,
        protected ?int $id = null
    ) {
        $this->permissions = $this->setMinifyJson($permissions);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPermissions(): string
    {
        return $this->permissions;
    }

    public function setPermissions(string $permissions): self
    {
        $this->permissions = $permissions;
        return $this;
    }

    public function isEnabled(): int
    {
        return $this->isEnabled;
    }

    public function setEnabled(int $isEnabled): self
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->isEnabled() ? 'Ativo' : 'Inativo';
    }

    protected function setMinifyJson(string $permissions): string
    {
        return str_replace(["\r", "\n", ' '], '', $permissions);
    }

    public function getData(): array
    {
        $data = [
            self::NAME => $this->getName(),
            self::PERMISSIONS => $this->getPermissions(),
            self::IS_ENABLED => $this->isEnabled()
        ];

        if ($this->getId()) {
            $data[self::ID] = $this->getId();
        }

        return $data;
    }
}
