<?php

namespace App\Model\Post;

use App\Model\Category\Entity as CategoryEntity;
use App\Model\EntityInterface;
use App\Model\User\Repository as UserRepository;
use App\Model\Category\Repository as CategoryRepository;

class Entity implements EntityInterface
{
    public const ID = 'id';
    public const TITLE = 'title';
    public const CATEGORY_ID = 'category_id';
    public const USER_ID = 'user_id';
    public const STATUS = 'status';
    public const CONTENT = 'content';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const VALID_STATUS = [
        0 => 'Rascunho',
        1 => 'Aguardando Aprovação',
        2 => 'Aprovado',
        3 => 'Publicado',
        4 => 'Reprovado'
    ];

    protected ?string $createdAt;
    protected ?string $updatedAt;

    public function __construct(
        protected string $title,
        protected int $categoryId,
        protected int $userId,
        protected int $status,
        protected string $content,
        protected ?int $id = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
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

    public function getUserName(): string
    {
        $userId = $this->getUserId();

        $userRepository = new UserRepository();
        $user = $userRepository->load($userId);
        return $user->getFullname();
    }

    public function getCategory(): CategoryEntity
    {
        $categoryId = $this->getCategoryId();

        $categoryRepository = new CategoryRepository();
        return $categoryRepository->load($categoryId);
    }

    public function getCategoryName(): string
    {
        return $this->getCategory()->getName();
    }

    public function getStatusName(): string
    {
        $status = $this->getStatus();

        if (array_key_exists($status, self::VALID_STATUS)) {
            return self::VALID_STATUS[$status];
        }

        return 'Sem status válido';
    }

    public function isShowInSite(): bool
    {
        return self::VALID_STATUS[$this->getStatus()] === self::VALID_STATUS[3];
    }

    public function getData(): array
    {
        $data = [
            self::TITLE => $this->getTitle(),
            self::CATEGORY_ID => $this->getCategoryId(),
            self::CONTENT => $this->getContent(),
            self::STATUS => $this->getStatus(),
            self::USER_ID => $this->getUserId()
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
