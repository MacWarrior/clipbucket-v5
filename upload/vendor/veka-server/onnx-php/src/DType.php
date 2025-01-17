<?php

namespace Onnx;

class DType
{
    const BOOL = 'bool';
    const INT8 = 'int8';
    const INT16 = 'int16';
    const INT32 = 'int32';
    const INT64 = 'int64';
    const UINT8 = 'uint8';
    const UINT16 = 'uint16';
    const UINT32 = 'uint32';
    const UINT64 = 'uint64';
    const FLOAT8 = 'float8';
    const FLOAT16 = 'float16';
    const FLOAT32 = 'float32';
    const FLOAT64 = 'float64';
    const STRING = 'string';
    const COMPLEX64 = 'complex64';
    const COMPLEX128 = 'complex128';
    const BFLOAT16 = 'bfloat16';

    public static function packFormat($dtype)
    {
        switch ($dtype) {
            case self::BOOL:
                return 'C*';
            case self::INT8:
                return 'c*';
            case self::INT16:
                return 's*';
            case self::INT32:
                return 'l*';
            case self::INT64:
                return 'q*';
            case self::UINT8:
                return 'C*';
            case self::UINT16:
                return 'S*';
            case self::UINT32:
                return 'L*';
            case self::UINT64:
                return 'Q*';
            case self::FLOAT8:
                return 'C*';
            case self::FLOAT16:
                return 'S*';
            case self::FLOAT32:
                return 'g*';
            case self::FLOAT64:
                return 'e*';
            case self::STRING:
                return 'a*';
            default:
                throw new \InvalidArgumentException('Unsupported data type');
        }
    }

    public static function inferFrom($value)
    {
        if (is_bool($value)) {
            return self::BOOL;
        } elseif (is_int($value)) {
            return self::INT32;
        } elseif (is_float($value)) {
            return self::FLOAT64;
        } elseif (is_string($value)) {
            return self::STRING;
        } else {
            throw new \InvalidArgumentException('Unsupported data type');
        }
    }

    public static function castValue($dtype, $value)
    {
        switch ($dtype) {
            case self::BOOL:
                return (bool)$value;
            case self::INT8:
            case self::INT16:
            case self::INT32:
            case self::INT64:
            case self::UINT8:
            case self::UINT16:
            case self::UINT32:
            case self::UINT64:
                return (int)$value;
            case self::FLOAT8:
            case self::FLOAT16:
            case self::FLOAT32:
            case self::FLOAT64:
                return (float)$value;
            case self::STRING:
                return (string)$value;
            case self::COMPLEX64:
            case self::COMPLEX128:
            case self::BFLOAT16:
                throw new \Exception('To be implemented');
            default:
                throw new \InvalidArgumentException('Unsupported data type');
        }
    }
}
