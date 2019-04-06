<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Renderer;

use Bungerous\Mobiledoc\Model\RenderableInterface;

interface RendererInterface
{
    public function render(RenderableInterface $renderable): string;
}