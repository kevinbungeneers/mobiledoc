<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

use Bungerous\Mobiledoc\Model\Marker\Marker;
use Bungerous\Mobiledoc\Renderer\RendererInterface;

class MarkupSection extends Section
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var array|Marker[]
     */
    private $markers;

    /**
     * MarkupSection constructor.
     *
     * @param string $tagName
     * @param array|Marker[] $markers
     */
    public function __construct(string $tagName, array $markers)
    {
        $this->tagName = $tagName;
        $this->markers = $markers;
    }

    /**
     * @return int
     */
    public function getTypeIdentifier(): int
    {
        return Section::TYPE_MARKUP;
    }

    /**
     * @param RendererInterface $renderer
     *
     * @return string
     */
    public function render(RendererInterface $renderer): string
    {
        return $renderer->render($this);
    }
}