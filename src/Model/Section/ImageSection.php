<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

use Bungerous\Mobiledoc\Renderer\RendererInterface;

class ImageSection extends Section
{
    /**
     * @var string
     */
    private $imageSource;

    /**
     * ImageSection constructor.
     *
     * @param string $imageSource
     */
    public function __construct(string $imageSource)
    {
        $this->imageSource = $imageSource;
    }

    /**
     * @return int
     */
    public function getTypeIdentifier(): int
    {
        return Section::TYPE_IMAGE;
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