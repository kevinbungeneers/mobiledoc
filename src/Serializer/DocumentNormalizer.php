<?php

namespace Bungerous\Mobiledoc\Serializer;

use Bungerous\Mobiledoc\Exception\SerializeException;
use Bungerous\Mobiledoc\Model\Atom;
use Bungerous\Mobiledoc\Model\Card;
use Bungerous\Mobiledoc\Model\Document;
use Bungerous\Mobiledoc\Model\Markup;
use Bungerous\Mobiledoc\Model\Section\Section;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DocumentNormalizer implements NormalizerInterface, DenormalizerInterface, NormalizerAwareInterface, DenormalizerAwareInterface
{
    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $class The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return object
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     * @throws ExceptionInterface       Occurs for all the other cases of errors
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $defaults = [
            'version' => Document::VERSION,
            'markups' => [],
            'atoms' => [],
            'cards' => [],
            'sections' => [],
        ];

        foreach ($data as $type => $list) {
            switch ($type) {
                case 'markups' === $type:
                    $defaults[$type] = $this->denormalizeMarkups($list, $format, $context);
                    break;

                case 'atoms' === $type:
                    $defaults[$type] = $this->denormalizeAtoms($list, $format, $context);
                    break;

                case 'cards' === $type:
                    $defaults[$type] = $this->denormalizeCards($list, $format, $context);
                    break;

                case 'sections' === $type:
                    $defaults[$type] = $this->denormalizeSections($list, $format, $context);
                    break;

                case 'version' === $type:
                    $defaults[$type] = $list;
                    break;

                default:
                    throw new SerializeException(sprintf('Unsupported type %s', $type));
            }
        }

        return new Document(
            $defaults['atoms'],
            $defaults['cards'],
            $defaults['markups'],
            $defaults['sections']
        );
    }

    /**
     * @param array $markups
     * @param $format
     * @param array $context
     *
     * @throws ExceptionInterface
     *
     * @return array
     */
    private function denormalizeMarkups(array $markups, $format, array $context): array
    {
        $data = [];

        foreach ($markups as $markup) {
            $data[] = $this->denormalizer->denormalize($markup, Markup::class, $format, $context);
        }

        return $data;
    }

    /**
     * @param array $atoms
     * @param $format
     * @param array $context
     *
     * @throws ExceptionInterface
     *
     * @return array
     */
    private function denormalizeAtoms(array $atoms, $format, array $context): array
    {
        $data = [];

        foreach ($atoms as $atom) {
            $data[] = $this->denormalizer->denormalize($atom, Atom::class, $format, $context);
        }

        return $data;
    }

    /**
     * @param array $cards
     * @param $format
     * @param array $context
     *
     * @throws ExceptionInterface
     *
     * @return array
     */
    private function denormalizeCards(array $cards, $format, array $context): array
    {
        $data = [];

        foreach ($cards as $card) {
            $data[] = $this->denormalizer->denormalize($card, Card::class, $format, $context);
        }

        return $data;
    }

    /**
     * @param array $sections
     * @param $format
     * @param $context
     *
     * @throws ExceptionInterface
     *
     * @return array
     */
    private function denormalizeSections(array $sections, $format, $context): array
    {
        $data = [];

        foreach ($sections as $section) {
            $data[] = $this->denormalizer->denormalize($section, Section::class, $format, $context);
        }

        return $data;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from
     * @param string $type The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Document::class === $type;
    }

    /**
     * Sets the owning Normalizer object.
     *
     * @param NormalizerInterface $normalizer
     */
    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param mixed $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|int|float|bool
     *
     * @throws InvalidArgumentException   Occurs when the object given is not an attempted type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     * @throws ExceptionInterface         Occurs for all the other cases of errors
     */
    public function normalize($object, $format = null, array $context = [])
    {
        // TODO: Implement normalize() method.
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Document;
    }

    /**
     * Sets the owning Denormalizer object.
     *
     * @param DenormalizerInterface $denormalizer
     */
    public function setDenormalizer(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }
}