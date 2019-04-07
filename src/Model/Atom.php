<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model;

class Atom
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var array
     */
    private $payload;

    /**
     * Atom constructor.
     *
     * @param string $name
     * @param string $value
     * @param array $payload
     */
    public function __construct(string $name, string $value, array $payload = [])
    {
        $this->name = $name;
        $this->value = $value;
        $this->payload = $payload;
    }
}