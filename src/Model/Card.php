<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Model;

use Bungerous\Mobiledoc\Renderer\RendererInterface;

class Card implements RenderableInterface
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