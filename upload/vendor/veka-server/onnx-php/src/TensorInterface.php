<?php

declare(strict_types=1);

namespace Onnx;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface TensorInterface extends ArrayAccess, Countable, IteratorAggregate
{
    public function shape(): array;

    public function ndim(): int;

    public function dtype();

    public function buffer();

    public function size(): int;

    public static function fromArray(array $array, $dtype, $shape);

    public static function fromString(string $string, $dtype, array $shape);

    public function toArray(): array;

    public function toString(): string;
}