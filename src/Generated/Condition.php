<?php

namespace Aternos\Licensee\Generated;

enum Condition : string
{
    case INCLUDE_COPYRIGHT = "include-copyright";
    case INCLUDE_COPYRIGHT_SOURCE = "include-copyright--source";
    case DOCUMENT_CHANGES = "document-changes";
    case DISCLOSE_SOURCE = "disclose-source";
    case NETWORK_USE_DISCLOSE = "network-use-disclose";
    case SAME_LICENSE = "same-license";
    case SAME_LICENSE_FILE = "same-license--file";
    case SAME_LICENSE_LIBRARY = "same-license--library";

    public function getDescription(): string
    {
        return match($this) {
            self::INCLUDE_COPYRIGHT => "A copy of the license and copyright notice must be included with the licensed material.",
            self::INCLUDE_COPYRIGHT_SOURCE => "A copy of the license and copyright notice must be included with the licensed material in source form, but is not required for binaries.",
            self::DOCUMENT_CHANGES => "Changes made to the licensed material must be documented.",
            self::DISCLOSE_SOURCE => "Source code must be made available when the licensed material is distributed.",
            self::NETWORK_USE_DISCLOSE => "Users who interact with the licensed material via network are given the right to receive a copy of the source code.",
            self::SAME_LICENSE => "Modifications must be released under the same license when distributing the licensed material. In some cases a similar or related license may be used.",
            self::SAME_LICENSE_FILE => "Modifications of existing files must be released under the same license when distributing the licensed material. In some cases a similar or related license may be used.",
            self::SAME_LICENSE_LIBRARY => "Modifications must be released under the same license when distributing the licensed material. In some cases a similar or related license may be used, or this condition may not apply to works that use the licensed material as a library.",
        };
    }

    public function getLabel(): string
    {
        return match($this) {
            self::INCLUDE_COPYRIGHT => "License and copyright notice",
            self::INCLUDE_COPYRIGHT_SOURCE => "License and copyright notice for source",
            self::DOCUMENT_CHANGES => "State changes",
            self::DISCLOSE_SOURCE => "Disclose source",
            self::NETWORK_USE_DISCLOSE => "Network use is distribution",
            self::SAME_LICENSE => "Same license",
            self::SAME_LICENSE_FILE => "Same license (file)",
            self::SAME_LICENSE_LIBRARY => "Same license (library)",
        };
    }
}
