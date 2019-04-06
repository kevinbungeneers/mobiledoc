<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

use Bungerous\Mobiledoc\Renderer\RendererInterface;

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