<?php

namespace App\Model\Post;

use App\Model\EntityInterface;

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
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
