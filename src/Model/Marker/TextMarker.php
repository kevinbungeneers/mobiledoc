<?php

namespace Bungerous\Mobiledoc\Model\Marker;

class TextMarker extends Marker
{
    /**
     * @return int
     */
    public function getTypeIdentifier(): int
    {
        return Marker::TYPE_TEXT;
    }
}