<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

class CardSection extends Section
{
    /**
     * @var int
     */
    private $cardIndex;

    /**
     * CardSection constructor.
     *
     * @param int $cardIndex
     */
    public function __construct(int $cardIndex)
    {
        $this->cardIndex = $cardIndex;
    }

    public function getTypeIdentifier(): int
    {
        return Section::TYPE_CARD;
    }

    /**
     * @return int
     */
    public function getCardIndex(): int
    {
        return $this->cardIndex;
    }
}