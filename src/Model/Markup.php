<?php

namespace Bungerous\Mobiledoc\Model;

use Bungerous\Mobiledoc\Renderer\RendererInterface;

class Markup implements RenderableInterface
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
     * @param RendererInterface $renderer
     *
     * @return string
     */
    public function render(RendererInterface $renderer): string
    {
        // TODO: Implement render() method.
    }
}