<?php

declare(strict_types=1);

namespace Onnx;

use EmptyIterator;
use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;
use Traversable;

class Tensor implements TensorInterface
{
    protected $buffer;
    protected $shape;
    protected $dtype;

    /**
     * Construct a new Tensor instance.
     *
     * @param array $buffer A flat buffer containing tensor data.
     * @param array $shape The shape of the tensor.
     * @param DType $dtype The data type of the tensor.
     */
    public function __construct(
        array $buffer,
        array $shape,
        $dtype
    ) {
        $this->dtype = $dtype;
        $this->shape = $shape;
        $this->buffer = $buffer;
    }

    /**
     * Create a Tensor instance from a PHP array.
     *
     * @param array $array The input array.
     * @param mixed $dtype The data type of the tensor (optional).
     * @param array|null $shape The shape of the tensor (optional).
     * @return static The created Tensor instance.
     * @throws InvalidArgumentException If the shape isn't provided when the array is empty.
     */
    public static function fromArray(array $array, $dtype = null,  $shape = null)
    {
        if (empty($array) && $shape === null) {
            throw new InvalidArgumentException('Shape must be provided when the array is empty');
        }

        if (!isset($shape)) {
            $shape = self::generateShape($array);
        }
        $buffer = [];
        $index = 0;

        self::flattenArray($array, $buffer, $index, $dtype);

        return new static($buffer, $shape, $dtype);
    }

    /**
     * Create a Tensor instance from a packed binary string.
     *
     * @param string $string The packed binary string containing the tensor data (flat)
     * @param DType $dtype The data type of the tensor.
     * @param array $shape The shape of the tensor.
     * @return static The created Tensor instance.
     * @throws RuntimeException If an error occurs during string unpacking.
     * @throws InvalidArgumentException If the number of elements in the string does not match the shape.
     * @throws \Exception
     */
    public static function fromString(string $string, $dtype, array $shape)
    {
        $data = unpack(DType::packFormat($dtype), $string);

        if ($data === false) {
            throw new RuntimeException('Error unpacking string data');
        }

        if (count($data) != array_product($shape)) {
            throw new InvalidArgumentException('The number of elements in the string does not match the shape');
        }

        $buffer = [];
        foreach ($data as $i => $value) {
            $buffer[$i - 1] = DType::castValue($dtype, $value);
        }

        return new static($buffer, $shape, $dtype);
    }

    public function shape() :array
    {
        return $this->shape;
    }

    public function ndim() :int
    {
        return count($this->shape);
    }

    public function dtype()
    {
        return $this->dtype;
    }

    public function buffer() :array
    {
        return $this->buffer;
    }

    public function size() :int
    {
        return array_product($this->shape);
    }

    public function reshape(array $shape)
    {
        if (array_product($shape) != array_product($this->shape)) {
            throw new InvalidArgumentException('New shape must have the same number of elements');
        }

        return new static($this->buffer, $shape, $this->dtype);
    }

    public function toArray() :array
    {
        $i = 0;
        return self::unflattenArray($this->buffer, $this->shape, $i);
    }

    public function toString() :string
    {
        // Récupération du format de pack avant la boucle pour éviter de l'appeler à chaque itération
        $packFormat = DType::packFormat($this->dtype);

        $packedValues = '';

        foreach ($this->buffer as $value) {
            // Stockage des valeurs packées dans le tableau
            $packedValues .= pack($packFormat, $value);
        }

        return $packedValues;
    }

    public function count() :int
    {
        return $this->shape[0];
    }

    public static function generateShape(array $array) :array
    {
        $shape = [];

        while (is_array($array)) {
            $shape[] = count($array);
            $array = reset($array);
        }

        return $shape;
    }

    public static function flattenArray(array $nestedArray, array &$buffer, int &$index,  $dtype)
    {
        foreach ($nestedArray as $value) {
            if (is_array($value)) {
                self::flattenArray($value, $buffer, $index, $dtype);
            } else {
                $buffer[$index++] = $value;
            }
        }
    }

    public static function unflattenArray(array &$buffer, array $shape, int &$index) :array
    {
        if (array_product($shape) === 0) {
            return [];
        }

        $nestedArray = [];
        $size = array_shift($shape);

        for ($i = 0; $i < $size; $i++) {
            $nestedArray[] = empty($shape) ? $buffer[$index++] : self::unflattenArray($buffer, $shape, $index);
        }

        return $nestedArray;
    }

    public function getIterator() :Traversable
    {
        if (empty($this->shape)) {
            return new EmptyIterator();
        }

        for ($i = 0; $i < $this->count(); $i++) {
            yield $i => $this->offsetGet($i);
        }
    }

    public function offsetExists($offset) :bool
    {
        return $offset >= 0 && $offset < $this->shape[0];
    }

    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new OutOfBoundsException('Index out of bounds');
        }

        if (count($this->shape) === 1) {
            return $this->buffer[$offset];
        }

        $newShape = array_slice($this->shape, 1);
        $newSize = array_product($newShape);
        $buffer = [];

        for ($i = 0; $i < $newSize; $i++) {
            $buffer[$i] = $this->buffer[$offset * $newSize + $i];
        }

        return new self($buffer, $newShape, $this->dtype);
    }

    public function offsetSet($offset, $value)
    {
        if (!$this->offsetExists($offset)) {
            throw new OutOfBoundsException('Index out of bounds');
        }

        if (count($this->shape) === 0) {
            if (!is_scalar($value)) {
                throw new InvalidArgumentException('Value must be scalar');
            }
            $this->buffer[$offset] = $value;
            return;
        }

        if (!($value instanceof self) || $value->shape() !== array_slice($this->shape, 1)) {
            throw new InvalidArgumentException('Value must be a tensor with the same sub-shape');
        }

        $buffer = $value->buffer();
        $newSize = array_product(array_slice($this->shape, 1));

        for ($i = 0; $i < $newSize; $i++) {
            $this->buffer[$offset * $newSize + $i] = $buffer[$i];
        }
    }

    public function offsetUnset( $offset)
    {
        throw new RuntimeException('Cannot unset tensor elements');
    }


    /**
     * Transpose tensor data from BHWC to BCHW.
     *
     * @return static The transposed Tensor instance.
     * @throws InvalidArgumentException If the tensor does not have exactly 4 dimensions.
     */
    public function transposeBhwcToBchw()
    {
        if (count($this->shape) !== 4) {
            throw new InvalidArgumentException('Tensor must have exactly 4 dimensions to transpose from BHWC to BCHW');
        }

        list($batch, $height, $width, $channels) = $this->shape;
        $newShape = [$batch, $channels, $height, $width];
        $newBuffer = array_fill(0, array_product($newShape), 0);

        for ($b = 0; $b < $batch; $b++) {
            for ($h = 0; $h < $height; $h++) {
                for ($w = 0; $w < $width; $w++) {
                    for ($c = 0; $c < $channels; $c++) {
                        $oldIndex = (($b * $height + $h) * $width + $w) * $channels + $c;
                        $newIndex = (($b * $channels + $c) * $height + $h) * $width + $w;
                        $newBuffer[$newIndex] = $this->buffer[$oldIndex];
                    }
                }
            }
        }

        return new static($newBuffer, $newShape, $this->dtype);
    }

}
