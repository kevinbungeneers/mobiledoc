<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model;

use Bungerous\Mobiledoc\Renderer\RendererInterface;

interface RenderableInterface
{
    /**
     * @param RendererInterface $renderer
     *
     * @return string
     */
    public function render(RendererInterface $renderer): string;
}