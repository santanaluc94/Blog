<?php

namespace App\Model;

interface EntityInterface
{
    public function getId(): ?int;

    public function getData(): array;
}
