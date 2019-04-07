<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model;

class Card
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $payload;

    /**
     * Card constructor.
     *
     * @param string $name
     * @param array $payload
     */
    public function __construct(string $name, array $payload = [])
    {
        $this->name = $name;
        $this->payload = $payload;
    }
}