<?php

namespace Bungerous\Mobiledoc\Renderer;

use Bungerous\Mobiledoc\Exception\UnsupportedCardException;
use Bungerous\Mobiledoc\Model\Card;
use Bungerous\Mobiledoc\Model\Document;
use Bungerous\Mobiledoc\Model\Marker\Marker;
use Bungerous\Mobiledoc\Model\Markup;
use Bungerous\Mobiledoc\Model\Section\CardSection;
use Bungerous\Mobiledoc\Model\Section\ImageSection;
use Bungerous\Mobiledoc\Model\Section\ListSection;
use Bungerous\Mobiledoc\Model\Section\MarkupSection;

class HtmlRenderer implements RendererInterface
{
    const FORMAT = 'html';

    /**
     * @var array
     */
    private $tagStack = [];

    /**
     * @var array|CardRendererInterface[]
     */
    private $cardRenderers;

    /**
     * HtmlRenderer constructor.
     * @param array $cardRenderers
     */
    public function __construct($cardRenderers = [])
    {
        $this->cardRenderers = $cardRenderers;
    }

    public function renderDocument(Document $document): string
    {
        $renderedSections = [];

        foreach ($document->getSections() as $section) {
            switch(true) {
                case $section instanceof MarkupSection:
                    $renderedSections[] = $this->renderMarkupSection($section, $document->getMarkups());
                    break;

                case $section instanceof ImageSection:
                    $renderedSections[] = $this->renderImageSection($section);
                    break;

                case $section instanceof ListSection:
                    $renderedSections[] = $this->renderListSection($section, $document->getMarkups());
                    break;

                case $section instanceof CardSection:
                    $renderedSections[] = $this->renderCardSection($section, $document->getCards());
                    break;

                default:
                    break;
            }
        }

        return implode('', $renderedSections);
    }

    public function addCardRenderer(CardRendererInterface $cardRenderer): void
    {
        $this->cardRenderers[] = $cardRenderer;
    }

    private function renderMarkupSection(MarkupSection $section, array $markups): string
    {
        return "<{$section->getTagName()}>{$this->renderMarkers($section->getMarkers(), $markups)}</{$section->getTagName()}>";
    }

    private function renderImageSection(ImageSection $section): string
    {
        return '<img src="' . $section->getImageSource() . '">';
    }

    private function renderListSection(ListSection $section, array $markups): string
    {
        $list = [];

        $list[] = '<'.$section->getTagName().'>';

        foreach ($section->getMarkers() as $markers) {
            $list[] = '<li>';
            $list[] = $this->renderMarkers($markers, $markups);
            $list[] = '</li>';
        }

        $list[] = '</' . $section->getTagName() . '>';

        return implode('', $list);
    }

    private function renderCardSection(CardSection $section, array $cards): string
    {
        $card = $cards[$section->getCardIndex()];
        $cardRenderer = $this->getCardRenderer($card);

        if (!$cardRenderer instanceof CardRendererInterface) {
            throw new UnsupportedCardException(sprintf('No card renderer found for card "%s"', $card->getName()));
        }

        return $cardRenderer->render($card);
    }

    private function getCardRenderer(Card $card): ?CardRendererInterface
    {
        foreach ($this->cardRenderers as $cardRenderer) {
            if (!$cardRenderer->supports($card->getName(), self::FORMAT)) {
                continue;
            }

            return $cardRenderer;
        }

        return null;
    }

    private function renderMarkers(array $markers, array $markups): string
    {
        $content = [];

        foreach ($markers as $marker) {
            $content[] = $this->renderMarker($marker, $markups);
        }

        return implode('', $content);
    }

    private function renderMarker(Marker $marker, $markups): string
    {
        $openingTags = [];
        $closingTags = [];

        if (!empty($marker->getOpenMarkupsIndexes())) {
            foreach ($marker->getOpenMarkupsIndexes() as $openMarkupsIndex) {
                /** @var Markup $markup */
                $markup = $markups[$openMarkupsIndex];

                $tag = '<' . $markup->getTagName();

                if (!empty($markup->getAttributes())) {
                    foreach ($markup->getAttributes() as $key => $value) {
                        $tag .= ' ' . $key . '="' . $value . '"';
                    }
                }

                $tag .= '>';

                $openingTags[] = $tag;
                $this->tagStack[] = $markup->getTagName();
            }
        }

        for ($i = 0; $i < $marker->getNumberOfClosedMarkups(); $i++) {
            $closingTags[] = '</' . array_pop($this->tagStack) . '>';
        }

        return implode('', $openingTags) . $marker->getValue() . implode('', $closingTags);
    }

    public function supports(string $format): bool
    {
        return self::FORMAT === $format;
    }
}