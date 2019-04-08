<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model\Section;

class ImageSection extends Section
{
    /**
     * @var string
     */
    private $imageSource;

    /**
     * ImageSection constructor.
     *
     * @param string $imageSource
     */
    public function __construct(string $imageSource)
    {
        $this->imageSource = $imageSource;
    }

    /**
     * @return string
     */
    public function getImageSource(): string
    {
        return $this->imageSource;
    }

    /**
     * @return int
     */
    public function getTypeIdentifier(): int
    {
        return Section::TYPE_IMAGE;
    }
}