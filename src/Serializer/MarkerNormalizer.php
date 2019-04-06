<?php

namespace Bungerous\Mobiledoc\Serializer;

use Bungerous\Mobiledoc\Exception\SerializeException;
use Bungerous\Mobiledoc\Model\Marker\AtomMarker;
use Bungerous\Mobiledoc\Model\Marker\Marker;
use Bungerous\Mobiledoc\Model\Marker\TextMarker;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MarkerNormalizer implements NormalizerInterface, DenormalizerInterface
{
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
        return $data instanceof Marker;
    }

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

        switch ($typeIdentifier) {
            case Marker::TYPE_TEXT:
                return $this->denormalizeTextMarker($data, $class, $format, $context);
            case Marker::TYPE_ATOM:
                return $this->denormalizeAtomMarker($data, $class, $format, $context);
            default:
                throw new SerializeException(sprintf("Unsupported marker identifier: %s", $typeIdentifier));
        }
    }

    private function denormalizeTextMarker($data, $class, $format = null, array $context = [])
    {
        $marker = new TextMarker($data[1], $data[2], $data[3]);

        return $marker;
    }

    private function denormalizeAtomMarker($data, $class, $format = null, array $context = [])
    {
        $marker = new AtomMarker($data[1], $data[2], $data[3]);

        return $marker;
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
        return
            Marker::class === $type ||
            AtomMarker::class === $type ||
            TextMarker::class === $type
        ;
    }
}