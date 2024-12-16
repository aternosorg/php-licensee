<?php

namespace Aternos\Licensee\Generated;

enum Field : string
{
    case FULLNAME = "fullname";
    case LOGIN = "login";
    case EMAIL = "email";
    case PROJECT = "project";
    case DESCRIPTION = "description";
    case YEAR = "year";
    case PROJECTURL = "projecturl";

    /**
     * @return string
     */
    public static function getKeyRegex(): string
    {
        $parts = [];
        foreach (self::cases() as $field) {
            $parts[] = preg_quote($field->value, "/");
        }
        return "/\[(" . implode("|", $parts) . ")\]/";
    }

    public function getDescription(): string
    {
        return match($this) {
            self::FULLNAME => "The full name or username of the repository owner",
            self::LOGIN => "The repository owner's username",
            self::EMAIL => "The repository owner's primary email address",
            self::PROJECT => "The repository name",
            self::DESCRIPTION => "The description of the repository",
            self::YEAR => "The current year",
            self::PROJECTURL => "The repository URL or other project website",
        };
    }
}
