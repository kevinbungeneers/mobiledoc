<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

use Bungerous\Mobiledoc\Model\Marker\Marker;

class ListSection extends Section
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var array|Marker[]
     */
    private $markers;

    /**
     * MarkupSection constructor.
     *
     * @param string $tagName
     * @param array|Marker[] $markers
     */
    public function __construct(string $tagName, array $markers)
    {
        $this->tagName = $tagName;
        $this->markers = $markers;
    }

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * @return array|Marker[]
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * @return int
     */
    public function getTypeIdentifier(): int
    {
        return Section::TYPE_LIST;
    }
}