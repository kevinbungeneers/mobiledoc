<?php

namespace BungerousTests;

use Bungerous\Mobiledoc\Model\Document;
use Bungerous\Mobiledoc\Renderer\HtmlRenderer;
use Bungerous\Mobiledoc\Serializer\AtomNormalizer;
use Bungerous\Mobiledoc\Serializer\CardNormalizer;
use Bungerous\Mobiledoc\Serializer\DocumentNormalizer;
use Bungerous\Mobiledoc\Serializer\MarkerNormalizer;
use Bungerous\Mobiledoc\Serializer\MobiledocEncoder;
use Bungerous\Mobiledoc\Serializer\MarkupNormalizer;
use Bungerous\Mobiledoc\Serializer\SectionNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

class SerializerTest extends TestCase
{

    public function testSerializer()
    {
        $encoders = [
            new MobiledocEncoder()
        ];

        $normalizers = [
            new DocumentNormalizer(),
            new MarkupNormalizer(),
            new AtomNormalizer(),
            new SectionNormalizer(),
            new CardNormalizer(),
            new MarkerNormalizer(),
        ];

        $file = __DIR__ . "/fixtures/simple_document.json";

        $serializer = new Serializer($normalizers, $encoders);
        $renderer = new HtmlRenderer();



        try {
            $document = $serializer->deserialize(file_get_contents($file), Document::class,'mobiledoc', []);
            dump($document->render($renderer));
        } catch (\Exception $e) {
            dump('oei');
            dump($e);
            exit;
        }
    }
}