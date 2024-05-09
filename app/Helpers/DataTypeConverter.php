<?php

namespace App\Helpers;

//use DateTime;
//use DateTimeZone;
//use Exception;

use Exception;

class DataTypeConverter
{
    /**
     * Convierte una cadena que representa una fracción o un número a float.
     *
     * @param string $fraction La cadena a convertir.
     * @return float|null El resultado de la conversión, o null si no es válido.
     */
    public static function convertToFloat(string $fraction): ?float
    {
        try {
            // Comprobar si es una fracción
            if (str_contains($fraction, '/')) {
                $parts = explode('/', $fraction);

                if (count($parts) == 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                    $numerator = floatval($parts[0]);
                    $denominator = floatval($parts[1]);

                    if ($denominator != 0) {
                        return $numerator / $denominator;
                    }
                }
            }

            // Comprobar si es un número
            if (is_numeric($fraction)) {
                return floatval($fraction);
            }

            // Si no es una fracción válida ni un número, devuelve null
            return null;
        } catch (Exception $e) {
            // Manejo de excepciones
            return null;
        }
    }

//    /**
//     * Convierte una cadena en formato string a un entero.
//     *
//     * @param string $value La cadena a convertir.
//     * @return int|null El entero convertido o null si la conversión falla.
//     */
//    public static function convertToInt(string $value): ?int
//    {
//        if (ctype_digit($value)) {
//            return intval($value);
//        }
//        return null;
//    }
//
//    /**
//     * Convierte un valor a una cadena.
//     *
//     * @param mixed $value El valor a convertir.
//     * @return string|null La cadena resultante o null si la conversión falla.
//     */
//    public static function convertToString(mixed $value): ?string
//    {
//        if (is_scalar($value)) {
//            return strval($value);
//        }
//        return null;
//    }
//
//    /**
//     * Convierte un valor a un array.
//     *
//     * @param mixed $value El valor a convertir.
//     * @return array|null El array resultante o null si la conversión falla.
//     */
//    public static function convertToArray(mixed $value): ?array
//    {
//        if (is_array($value)) {
//            return $value;
//        } elseif (is_object($value) && method_exists($value, 'toArray')) {
//            return $value->toArray();
//        } elseif (is_iterable($value)) {
//            return iterator_to_array($value);
//        }
//        return null;
//    }
//
//    /**
//     * Convierte un valor a formato JSON.
//     *
//     * @param mixed $value El valor a convertir.
//     * @return string|null El JSON resultante o null si la conversión falla.
//     */
//    public static function convertToJson(mixed $value): ?string
//    {
//        if (is_array($value) || is_object($value)) {
//            return json_encode($value);
//        }
//        return null;
//    }
//
//    /**
//     * Convierte una cadena en formato string a un objeto DateTime.
//     *
//     * @param string $dateString La cadena a convertir.
//     * @param string $format El formato de la fecha (opcional, por defecto 'Y-m-d H:i:s').
//     * @param string $timezone La zona horaria (opcional, por defecto 'UTC').
//     * @return DateTime|null El objeto DateTime resultante o null si la conversión falla.
//     */
//    public static function convertStringToDate(string $dateString, string $format = 'Y-m-d H:i:s', string $timezone = 'UTC'): ?DateTime
//    {
//        try {
//            $date = DateTime::createFromFormat($format, $dateString, new DateTimeZone($timezone));
//            if ($date && $date->format($format) === $dateString) {
//                return $date;
//            }
//        } catch (Exception $e) {
//            // Log error or handle it as needed
//        }
//        return null;
//    }
//
//    /**
//     * Convierte un objeto DateTime a una cadena.
//     *
//     * @param DateTime $date El objeto DateTime a convertir.
//     * @param string $format El formato de la fecha (opcional, por defecto 'Y-m-d H:i:s').
//     * @return string|null La cadena resultante o null si la conversión falla.
//     */
//    public static function convertDateToString(DateTime $date, string $format = 'Y-m-d H:i:s'): ?string
//    {
//        try {
//            return $date->format($format);
//        } catch (Exception $e) {
//            // Log error or handle it as needed
//        }
//        return null;
//    }
//
//    /**
//     * Convierte un timestamp a un objeto DateTime.
//     *
//     * @param int $timestamp El timestamp a convertir.
//     * @param string $timezone La zona horaria (opcional, por defecto 'UTC').
//     * @return DateTime|null El objeto DateTime resultante o null si la conversión falla.
//     */
//    public static function convertTimestampToDate(int $timestamp, string $timezone = 'UTC'): ?DateTime
//    {
//        try {
//            $date = new DateTime("@$timestamp");
//            $date->setTimezone(new DateTimeZone($timezone));
//            return $date;
//        } catch (Exception $e) {
//            // Log error or handle it as needed
//        }
//        return null;
//    }
//
//    /**
//     * Convierte un objeto DateTime a un timestamp.
//     *
//     * @param DateTime $date El objeto DateTime a convertir.
//     * @return int|null El timestamp resultante o null si la conversión falla.
//     */
//    public static function convertDateToTimestamp(DateTime $date): ?int
//    {
//        try {
//            return $date->getTimestamp();
//        } catch (Exception $e) {
//            // Log error or handle it as needed
//        }
//        return null;
//    }
//
//    /**
//     * Convierte una cadena en formato ISO8601 a un objeto DateTime.
//     *
//     * @param string $isoString La cadena en formato ISO8601 a convertir.
//     * @return DateTime|null El objeto DateTime resultante o null si la conversión falla.
//     */
//    public static function convertISOToDate(string $isoString): ?DateTime
//    {
//        try {
//            return new DateTime($isoString);
//        } catch (Exception $e) {
//            // Log error or handle it as needed
//        }
//        return null;
//    }
}
