<?php

namespace Aternos\Licensee\Exception;

class RegExpException extends LicenseeException
{
    /**
     * @return static
     */
    public static function last(): static
    {
        $code = preg_last_error();
        $message = preg_last_error_msg();

        return new static($message, $code);
    }

    /**
     * @template T
     * @param T $result
     * @param mixed $errorResult
     * @return T
     * @throws RegExpException
     */
    public static function handle(mixed $result, mixed $errorResult): mixed
    {
        if ($result === $errorResult) {
            throw static::last();
        }
        return $result;
    }

    /**
     * @template T
     * @param T $result
     * @return T
     * @throws RegExpException
     */
    public static function handleNull(mixed $result): mixed
    {
        return static::handle($result, null);
    }

    /**
     * @template T
     * @param T $result
     * @return T
     * @throws RegExpException
     */
    public static function handleFalse(mixed $result): mixed
    {
        return static::handle($result, false);
    }
}
