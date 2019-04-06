<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

use Bungerous\Mobiledoc\Model\RenderableInterface;

abstract class Section implements RenderableInterface
{
    const TYPE_MARKUP =  1;
    const TYPE_IMAGE  =  2;
    const TYPE_LIST   =  3;
    const TYPE_CARD   = 10;

    /**
     * @return int
     */
    public abstract function getTypeIdentifier(): int;
}