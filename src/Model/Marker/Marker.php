<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Marker;

abstract class Marker
{
    const TYPE_TEXT = 0;
    const TYPE_ATOM = 1;

    /**
     * @var array
     */
    private $openMarkupsIndexes;

    /**
     * @var int
     */
    private $numberOfClosedMarkups;

    /**
     * @var string|int
     */
    private $value;

    /**
     * Marker constructor.
     * @param array $openMarkupsIndexes
     * @param int $numberOfClosedMarkups
     * @param int|string $value
     */
    public function __construct(array $openMarkupsIndexes, int $numberOfClosedMarkups, $value)
    {
        $this->openMarkupsIndexes = $openMarkupsIndexes;
        $this->numberOfClosedMarkups = $numberOfClosedMarkups;
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getOpenMarkupsIndexes(): array
    {
        return $this->openMarkupsIndexes;
    }

    /**
     * @return int
     */
    public function getNumberOfClosedMarkups(): int
    {
        return $this->numberOfClosedMarkups;
    }

    /**
     * @return int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public abstract function getTypeIdentifier(): int;
}