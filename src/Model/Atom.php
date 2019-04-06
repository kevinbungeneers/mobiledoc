<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model;

use Bungerous\Mobiledoc\Renderer\RendererInterface;

class Atom implements RenderableInterface
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