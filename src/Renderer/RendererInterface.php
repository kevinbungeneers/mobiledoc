<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Renderer;

use Bungerous\Mobiledoc\Model\Document;

interface RendererInterface
{
    public function renderDocument(Document $document): string;

    public function supports(string $format): bool;
}