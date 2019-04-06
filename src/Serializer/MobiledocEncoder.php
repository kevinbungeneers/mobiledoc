<?php

namespace Bungerous\Mobiledoc\Serializer;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

class MobiledocEncoder implements EncoderInterface, DecoderInterface
{
    const FORMAT = 'mobiledoc';

    /**
     * @var JsonEncoder
     */
    private $jsonEncoder;

    /**
     * MobiledocEncoder constructor.
     */
    public function __construct()
    {
        $this->jsonEncoder = new JsonEncoder();
    }

    /**
     * Decodes a string into PHP data.
     *
     * @param string $data Data to decode
     * @param string $format Format name
     * @param array $context Options that decoders have access to
     *
     * The format parameter specifies which format the data is in; valid values
     * depend on the specific implementation. Authors implementing this interface
     * are encouraged to document which formats they support in a non-inherited
     * phpdoc comment.
     *
     * @return mixed
     *
     * @throws UnexpectedValueException
     */
    public function decode($data, $format, array $context = [])
    {
        return $this->jsonEncoder->decode($data, 'json', $context);
    }

    /**
     * Checks whether the deserializer can decode from given format.
     *
     * @param string $format Format name
     *
     * @return bool
     */
    public function supportsDecoding($format)
    {
        return self::FORMAT === $format;
    }

    /**
     * Encodes data into the given format.
     *
     * @param mixed $data Data to encode
     * @param string $format Format name
     * @param array $context Options that normalizers/encoders have access to
     *
     * @return string|int|float|bool
     *
     * @throws UnexpectedValueException
     */
    public function encode($data, $format, array $context = [])
    {
        return $this->jsonEncoder->encode($data, 'json', $context);
    }

    /**
     * Checks whether the serializer can encode to given format.
     *
     * @param string $format Format name
     *
     * @return bool
     */
    public function supportsEncoding($format)
    {
        return self::FORMAT === $format;
    }
}