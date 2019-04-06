<?php

declare(strict_types=1);

namespace Bungerous\Mobiledoc\Serializer;

use Bungerous\Mobiledoc\Exception\SerializeException;
use Bungerous\Mobiledoc\Model\Marker\Marker;
use Bungerous\Mobiledoc\Model\Section\CardSection;
use Bungerous\Mobiledoc\Model\Section\ImageSection;
use Bungerous\Mobiledoc\Model\Section\ListSection;
use Bungerous\Mobiledoc\Model\Section\MarkupSection;
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

class SectionNormalizer implements NormalizerInterface, DenormalizerInterface, NormalizerAwareInterface, DenormalizerAwareInterface
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
        $typeIdentifier = $data[0];
        $section = null;

        switch ($typeIdentifier) {
            case Section::TYPE_MARKUP:
                $section = new MarkupSection($data[1], $this->denormalizeMarkers($data[2], $class, $format, $context));
                break;

            case Section::TYPE_IMAGE:
                $section = new ImageSection($data[1]);
                break;

            case Section::TYPE_LIST:
                $section = new ListSection($data[1], $this->denormalizeListSectionMarkers($data[2], $class, $format, $context));
                break;

            case Section::TYPE_CARD:
                $section = new CardSection($data[1]);
                break;

            default:
                throw new SerializeException(sprintf('Unsupported section identifier: "%s"', $typeIdentifier));
        }

        return $section;
    }

    /**
     * @param array $listItems
     *
     * @return array
     */
    private function denormalizeListSectionMarkers(array $listItems, $class, $format, $context): array
    {
        $markers = [];

        foreach ($listItems as $listItem) {
            $markers[] = $this->denormalizeMarkers($listItem, $class, $format, $context);
        }

        return $markers;
    }

    /**
     * @param array $markers
     *
     * @return array
     */
    private function denormalizeMarkers(array $markers, $class, $format, $context): array
    {
        $denormalizedMarkers = [];

        foreach ($markers as $marker) {
            $denormalizedMarkers[] = $this->denormalizer->denormalize($marker, Marker::class, $format, $context);
        }

        return $denormalizedMarkers;
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
        return Section::class === $type;
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
        return $data instanceof Section;
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

    /**
     * Sets the owning Normalizer object.
     *
     * @param NormalizerInterface $normalizer
     */
    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }
}