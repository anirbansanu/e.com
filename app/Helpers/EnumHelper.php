<?php

namespace App\Helpers;

class EnumHelper
{
    /**
     * Get formatted options from an enum class.
     *
     * @param string $enumClass
     * @return array
     */
    public static function getOptions(string $enumClass): array
    {
        return collect($enumClass::cases())->map(fn($case) => [
            'id' => $case->value,
            'text' => $case->name
        ])->toArray();
    }

    /**
     * Get all values from an enum class.
     *
     * @param string $enumClass
     * @return array
     */
    public static function getValues(string $enumClass): array
    {
        return collect($enumClass::cases())->pluck('value')->toArray();
    }

    /**
     * Get all names from an enum class.
     *
     * @param string $enumClass
     * @return array
     */
    public static function getNames(string $enumClass): array
    {
        return collect($enumClass::cases())->pluck('name')->toArray();
    }

    /**
     * Get key-value pairs of enum names and values.
     *
     * @param string $enumClass
     * @return array
     */
    public static function getKeyValuePairs(string $enumClass): array
    {
        return collect($enumClass::cases())->mapWithKeys(fn($case) => [
            $case->name => $case->value
        ])->toArray();
    }

    /**
     * Get the enum name by value.
     *
     * @param string $enumClass
     * @param mixed $value
     * @return string|null
     */
    public static function getNameByValue(string $enumClass, $value): ?string
    {
        $case = collect($enumClass::cases())->firstWhere('value', $value);
        return $case ? $case->name : null;
    }

    /**
     * Get the enum value by name.
     *
     * @param string $enumClass
     * @param string $name
     * @return mixed|null
     */
    public static function getValueByName(string $enumClass, string $name)
    {
        $case = collect($enumClass::cases())->firstWhere('name', $name);
        return $case ? $case->value : null;
    }
}
