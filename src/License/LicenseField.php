<?php

namespace Aternos\Licensee\License;

class LicenseField
{
    protected const string FIELDS_FILE = __DIR__ . "/../../data/choosealicense.com/_data/fields.yml";
    protected static ?array $fields = null;

    /**
     * @return array
     */
    public static function getAll(): array
    {
        if (self::$fields !== null) {
            return self::$fields;
        }

        $data = yaml_parse_file(static::FIELDS_FILE);
        static::$fields = [];
        foreach ($data as $field) {
            static::$fields[] = new static($field["name"], $field["description"]);
        }

        return static::$fields;
    }

    /**
     * @return string
     */
    public static function getKeyRegex(): string
    {
        $parts = [];
        foreach (static::getAll() as $field) {
            $parts[] = preg_quote($field->getKey(), "/");
        }
        return "/\[(" . implode("|", $parts) . ")\]/";
    }

    /**
     * @param string $key
     * @param string $description
     */
    public function __construct(
        protected string $key,
        protected string $description
    )
    {
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
