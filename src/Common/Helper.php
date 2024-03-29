<?php
/**
 * Helper class
 */

namespace Corals\Modules\Payment\Common;

use InvalidArgumentException;

/**
 * Helper class
 *
 * This class defines various static utility functions that are in use
 * throughout the Payment system.
 */
class Helper
{
    /**
     * Convert a string to camelCase. Strings already in camelCase will not be harmed.
     *
     * @param  string $str The input string
     * @return string camelCased output string
     */
    public static function camelCase($str)
    {
        $str = self::convertToLowercase($str);

        return preg_replace_callback(
            '/_([a-z])/',
            function ($match) {
                return strtoupper($match[1]);
            },
            $str
        );
    }

    /**
     * Convert strings with underscores to be all lowercase before camelCase is preformed.
     *
     * @param  string $str The input string
     * @return string The output string
     */
    protected static function convertToLowercase($str)
    {
        $explodedStr = explode('_', $str);
        $lowercasedStr = [];

        if (count($explodedStr) > 1) {
            foreach ($explodedStr as $value) {
                $lowercasedStr[] = strtolower($value);
            }
            $str = implode('_', $lowercasedStr);
        }

        return $str;
    }

    /**
     * Validate a card number according to the Luhn algorithm.
     *
     * @param  string $number The card number to validate
     * @return bool True if the supplied card number is valid
     */
    public static function validateLuhn($number)
    {
        $str = '';
        foreach (array_reverse(str_split($number)) as $i => $c) {
            $str .= $i % 2 ? $c * 2 : $c;
        }

        return array_sum(str_split($str)) % 10 === 0;
    }

    /**
     * Initialize an object with a given array of parameters
     *
     * Parameters are automatically converted to camelCase. Any parameters which do
     * not match a setter on the target object are ignored.
     *
     * @param mixed $target The object to set parameters on
     * @param array $parameters An array of parameters to set
     */
    public static function initialize($target, array $parameters = null)
    {
        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $method = 'set' . ucfirst(static::camelCase($key));
                if (method_exists($target, $method)) {
                    $target->$method($value);
                }
            }
        }
    }

    /**
     * Resolve a gateway class to a short name.
     *
     * The short name can be used with GatewayFactory as an alias of the gateway class,
     * to create new instances of a gateway.
     */
    public static function getGatewayShortName($className)
    {
        if (0 === strpos($className, '\\')) {
            $className = substr($className, 1);
        }

        if (0 === strpos($className, 'Corals\Modules\Payment\\')) {
            return trim(str_replace('\\', '_', substr($className, 8, -7)), '_');
        }

        return '\\' . $className;
    }

    /**
     * Resolve a short gateway name to a full namespaced gateway class.
     *
     * Class names beginning with a namespace marker (\) are left intact.
     * Non-namespaced classes are expected to be in the \Corals\Modules\Payment namespace, e.g.:
     *
     *      \Custom\Gateway     => \Custom\Gateway
     *      \Custom_Gateway     => \Custom_Gateway
     *      Stripe              => \Corals\Modules\Payment\Stripe\Gateway
     *      PayPal\Express      => \Corals\Modules\Payment\PayPal\ExpressGateway
     *      PayPal_Express      => \Corals\Modules\Payment\PayPal\ExpressGateway
     *
     * @param  string $shortName The short gateway name
     * @return string  The fully namespaced gateway class name
     */
    public static function getGatewayClassName($shortName)
    {
        if (0 === strpos($shortName, '\\')) {
            return $shortName;
        }

        // replace underscores with namespace marker, PSR-0 style
        $shortName = str_replace('_', '\\', $shortName);
        if (false === strpos($shortName, '\\')) {
            $shortName .= '\\';
        }

        return '\\Corals\Modules\Payment\\' . $shortName . 'Gateway';
    }

    /**
     * Convert an amount into a float.
     * The float datatype can then be converted into the string
     * format that the remote gateway requies.
     *
     * @var string|int|float The value to convert.
     * @throws InvalidArgumentException on a validation failure.
     * @return float The amount converted to a float.
     */
    public static function toFloat($value)
    {
        if (! is_string($value) && ! is_int($value) && ! is_float($value)) {
            throw new InvalidArgumentException(trans('Payment::exception.messages_exception_common.data_not_valid'));
        }

        if (is_string($value)) {
            // Validate generic number, with optional sign and decimals.
            if (! preg_match('/^[-]?[0-9]+(\.[0-9]*)?$/', $value)) {
                throw new InvalidArgumentException(trans('Payment::exception.messages_exception_common.string_not_valid'));
            }
        }

        return (float)$value;
    }
}
