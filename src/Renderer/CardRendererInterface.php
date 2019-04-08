<?php

namespace Bungerous\Mobiledoc\Renderer;

use Bungerous\Mobiledoc\Model\Card;

interface CardRendererInterface
{
    public function render(Card $card): string;

    public function supports(string $cardName, string $format): bool;
}