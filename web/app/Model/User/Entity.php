<?php

namespace App\Model\User;

use App\Model\EntityInterface;
use App\Model\Role\Repository as RoleRepository;

class Entity implements EntityInterface
{
    public const ID = 'id';
    public const FIRSTNAME = 'firstname';
    public const LASTNAME = 'lastname';
    public const EMAIL = 'email';
    public const ROLE_ID = 'role_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected ?string $createdAt;
    protected ?string $updatedAt;

    public function __construct(
        protected string $firstname,
        protected string $lastname,
        protected string $email,
        protected int $roleId,
        protected ?int $id = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt ?? null;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt ?? null;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getFullname(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    public function getRoleName(): string
    {
        $roleId = $this->getRoleId();

        $roleRepository = new RoleRepository();
        $role = $roleRepository->load($roleId);
        return $role->getName();
    }

    public function getData(): array
    {
        $data = [
            self::FIRSTNAME => $this->getFirstname(),
            self::LASTNAME => $this->getLastname(),
            self::EMAIL => $this->getEmail(),
            self::ROLE_ID => $this->getRoleId()
        ];

        if ($this->getId()) {
            $data[self::ID] = $this->getId();
        }

        if ($this->getCreatedAt()) {
            $data[self::CREATED_AT] = $this->getCreatedAt();
        }

        if ($this->getUpdatedAt()) {
            $data[self::UPDATED_AT] = $this->getUpdatedAt();
        }

        return $data;
    }
}
