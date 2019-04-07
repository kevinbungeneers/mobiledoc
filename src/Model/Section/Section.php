<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

abstract class Section
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