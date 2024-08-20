<?php
// src/Entity/BlogPost.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

class BlogPost
{
    // ...

    #[ORM\Column(type: Types::STRING)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $draft = false;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'blogPosts')]
    private ?Category $category = null;
}