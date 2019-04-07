<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model;

class Markup
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var array
     */
    private $attributes;

    /**
     * Markup constructor.
     * @param string $tagName
     * @param array $attributes
     */
    public function __construct(string $tagName, array $attributes = [])
    {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}