<?php

namespace Bungerous\Mobiledoc\Model\Marker;

use Bungerous\Mobiledoc\Renderer\RendererInterface;

class AtomMarker extends Marker
{
    /**
     * @return int
     */
    public function getTypeIdentifier(): int
    {
        return Marker::TYPE_ATOM;
    }
}