<?php

namespace Aternos\Licensee\Generated;

enum Permission: string
{
    case COMMERCIAL_USE = "commercial-use";
    case MODIFICATIONS = "modifications";
    case DISTRIBUTION = "distribution";
    case PRIVATE_USE = "private-use";
    case PATENT_USE = "patent-use";

    public function getDescription(): string
    {
        return match ($this) {
            self::COMMERCIAL_USE => "The licensed material and derivatives may be used for commercial purposes.",
            self::MODIFICATIONS => "The licensed material may be modified.",
            self::DISTRIBUTION => "The licensed material may be distributed.",
            self::PRIVATE_USE => "The licensed material may be used and modified in private.",
            self::PATENT_USE => "This license provides an express grant of patent rights from contributors.",
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::COMMERCIAL_USE => "Commercial use",
            self::MODIFICATIONS => "Modification",
            self::DISTRIBUTION => "Distribution",
            self::PRIVATE_USE => "Private use",
            self::PATENT_USE => "Patent use",
        };
    }
}
