<?php

namespace App\Model\Role;

use App\Model\EntityInterface;

class Entity implements EntityInterface
{
    public const ID = 'id';
    public const NAME = 'name';
    public const ROLES = 'roles';
    public const IS_ENABLED = 'is_enabled';

    public function __construct(
        protected string $name,
        protected string $roles,
        protected bool $isEnabled,
        protected ?int $id = null
    ) {
        $this->roles = $this->setMinifyJson($roles);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRoles(): string
    {
        return $this->roles;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    protected function setMinifyJson(string $roles): string
    {
        return str_replace(["\r", "\n", ' '], '', $roles);
    }

    public function getData(): array
    {
        $data = [
            self::NAME => $this->getName(),
            self::ROLES => $this->getRoles(),
            self::IS_ENABLED => $this->isEnabled()
        ];

        if ($this->getId()) {
            $data[self::ID] = $this->getId();
        }

        return $data;
    }
}
