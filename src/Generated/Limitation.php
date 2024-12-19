<?php

namespace Aternos\Licensee\Generated;

enum Limitation: string
{
    case TRADEMARK_USE = "trademark-use";
    case LIABILITY = "liability";
    case PATENT_USE = "patent-use";
    case WARRANTY = "warranty";

    public function getDescription(): string
    {
        return match ($this) {
            self::TRADEMARK_USE => "This license explicitly states that it does NOT grant trademark rights, even though licenses without such a statement probably do not grant any implicit trademark rights.",
            self::LIABILITY => "This license includes a limitation of liability.",
            self::PATENT_USE => "This license explicitly states that it does NOT grant any rights in the patents of contributors.",
            self::WARRANTY => "This license explicitly states that it does NOT provide any warranty.",
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::TRADEMARK_USE => "Trademark use",
            self::LIABILITY => "Liability",
            self::PATENT_USE => "Patent use",
            self::WARRANTY => "Warranty",
        };
    }
}
