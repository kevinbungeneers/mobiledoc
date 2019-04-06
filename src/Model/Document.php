<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model;

use Bungerous\Mobiledoc\Model\Section\Section;
use Bungerous\Mobiledoc\Renderer\RendererInterface;

class Document implements RenderableInterface
{
    const VERSION_031 = '0.3.1';

    const VERSION = self::VERSION_031;

    /**
     * @var array | Atom[]
     */
    private $atoms = [];

    /**
     * @var array | Card[]
     */
    private $cards = [];

    /**
     * @var array | Markup[]
     */
    private $markups = [];

    /**
     * @var array | Section[]
     */
    private $sections = [];

    /**
     * Document constructor.
     * @param array|Atom[] $atoms
     * @param array|Card[] $cards
     * @param array|Markup[] $markups
     * @param array|Section[] $sections
     */
    public function __construct(array $atoms = [], array $cards = [], array $markups = [], array $sections = [])
    {
        $this->atoms = $atoms;
        $this->cards = $cards;
        $this->markups = $markups;
        $this->sections = $sections;
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

    /**
     * @return array|Atom[]
     */
    public function getAtoms()
    {
        return $this->atoms;
    }

    /**
     * @return array|Card[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @return array|Markup[]
     */
    public function getMarkups()
    {
        return $this->markups;
    }

    /**
     * @return array|Section[]
     */
    public function getSections()
    {
        return $this->sections;
    }
}