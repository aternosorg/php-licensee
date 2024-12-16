<?php

namespace Aternos\Licensee\License;

use Aternos\Licensee\License\Text\KnownLicenseText;
use Aternos\Licensee\License\Text\LicenseText;
use DOMDocument;
use DOMNode;
use InvalidArgumentException;

class License
{
    protected const string LICENSE_DIR = __DIR__ . "/../data/choosealicense.com/_licenses/";
    protected const string LICENSE_LIST_XML_DIR = __DIR__ . "/../data/license-list-XML/src/";

    protected static ?array $licenses = null;

    protected LicenseText $text;

    protected string $title;
    protected string $spdxId;
    protected string $description;
    protected string $how;
    protected array $using;
    protected array $permissions;
    protected array $conditions;
    protected array $limitations;

    protected ?string $nickname = null;
    protected ?string $note = null;

    protected ?string $titleRegexp = null;
    protected ?int $altSegmentCount = null;

    /**
     * @return static[]
     */
    public static function getAll(): array
    {
        if (self::$licenses !== null) {
            return self::$licenses;
        }

        $licenses = [];
        foreach (scandir(static::LICENSE_DIR) as $file) {
            if (is_file(static::LICENSE_DIR . $file)) {
                $name = pathinfo($file, PATHINFO_FILENAME);
                $licenses[$name] = new static($name);
            }
        }

        return self::$licenses = $licenses;
    }

    /**
     * @param string $key
     * @return License|null
     */
    public static function getByKey(string $key): ?License
    {
        return static::getAll()[$key] ?? null;
    }

    /**
     * @param string $id
     * @return License|null
     */
    public static function getBySpdxId(string $id): ?License
    {
        foreach (static::getAll() as $license) {
            if ($license->getSpdxId() === $id) {
                return $license;
            }
        }
        return null;
    }

    /**
     * @param string $key
     */
    public function __construct(
        protected string $key
    )
    {
        $this->parseLicenseFile(file_get_contents(static::LICENSE_DIR . $key . ".txt"));
    }

    /**
     * @return string
     */
    protected function readSpdxXmlContent(): string
    {
        return file_get_contents(static::LICENSE_LIST_XML_DIR . $this->getSpdxId() . ".xml");
    }

    /**
     * @param string $content
     * @return void
     */
    protected function parseLicenseFile(string $content): void
    {
        $metadata = yaml_parse($content);
        if ($metadata === false) {
            throw new InvalidArgumentException("Invalid license format");
        }

        $parts = preg_split('/^---\s*$/m', $content, 3);
        if (count($parts) !== 3) {
            throw new InvalidArgumentException("Invalid license format");
        }

        $this->title = $metadata['title'] ?? '';
        $this->spdxId = $metadata['spdx-id'];
        $this->description = $metadata['description'] ?? '';
        $this->how = $metadata['how'] ?? '';
        $this->using = $metadata['using'] ?? [];
        $this->permissions = $metadata['permissions'] ?? [];
        $this->conditions = $metadata['conditions'] ?? [];
        $this->limitations = $metadata['limitations'] ?? [];

        $this->nickname = $metadata['nickname'] ?? null;
        $this->note = $metadata['note'] ?? null;

        $this->text = new KnownLicenseText($parts[2], $this);
    }

    /**
     * I used the regex to regex the regex
     * @return string
     */
    public function getTitleRegex(): string
    {
        if ($this->titleRegexp !== null) {
            return $this->titleRegexp;
        }

        $simpleTitleRegex = strtolower($this->title);
        $simpleTitleRegex = str_replace('*', 'u', $simpleTitleRegex);
        $simpleTitleRegex = preg_quote($simpleTitleRegex, '/');
        $titleRegex = preg_replace('/^the /i', '', $simpleTitleRegex);
        $titleRegex = preg_replace('/,? version /', ' ', $titleRegex);
        $titleRegex = preg_replace('/v(\d+\.\d+)/', '$1', $titleRegex);
        $titleRegex = preg_quote($titleRegex, '/');
        $titleRegex = preg_replace('/\\\ licen[sc]e/i', '(?:\ licen[sc]e)?', $titleRegex);
        preg_match('/\d+\\\+\.(\d+)/', $titleRegex, $versionMatch);
        if ($versionMatch) {
            if ($versionMatch[1] === '0') {
                $sub = ',?\s+(?:version\ |v(?:\. )?)?$1($2)?';
            } else {
                $sub = ',?\s+(?:version\ |v(?:\. )?)?$1$2';
            }
            $titleRegex = preg_replace('/\s*(\d+)\\\+(\.\d+)/', $sub, $titleRegex);
        }
        $titleRegex = preg_replace('/\bgnu\\\ /i', '(?:GNU )?', $titleRegex);

        $keyRegex = str_replace('-', '[- ]', $this->spdxId);
        $keyRegex = str_replace('.', '\.', $keyRegex);
        $keyRegex .= '(?:\ licen[sc]e)?';

        $parts = [$simpleTitleRegex, $titleRegex, $keyRegex];
        if ($this->nickname) {
            $parts[] = preg_replace('/\bGNU /i', '(?:GNU )?', preg_quote($this->nickname, '/'));
        }

        return $this->titleRegexp = implode('|', $parts);
    }

    /**
     * @return LicenseText
     */
    public function getText(): LicenseText
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSpdxId(): string
    {
        return $this->spdxId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getHow(): string
    {
        return $this->how;
    }

    /**
     * @return array
     */
    public function getUsing(): array
    {
        return $this->using;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return array
     */
    public function getLimitations(): array
    {
        return $this->limitations;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
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
    public function getName(): string
    {
        if ($this->title) {
            return $this->title;
        }
        return $this->spdxId;
    }

    /**
     * @return string
     */
    public function getNameWithoutVersion(): string
    {
        if (!preg_match('/(.+?)(( v?\d\.\d)|$)/', $this->getName(), $matches)) {
            throw new InvalidArgumentException("Invalid license name");
        }
        return $matches[1];
    }

    /**
     * @param DOMNode $node
     * @return int
     */
    protected function countAltSegments(DOMNode $node): int
    {
        if ($node->nodeType !== XML_ELEMENT_NODE) {
            return 0;
        }
        if (in_array($node->nodeName, ["copyrightText", "titleText", "optional"])) {
            return 0;
        }

        $count = 0;
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE && $child->nodeName === "alt") {
                $count++;
            }
            $count += $this->countAltSegments($child);
        }
        return $count;
    }

    /**
     * @return int
     */
    public function getAltSegmentCount(): int
    {
        if ($this->altSegmentCount === null) {
            $document = new DOMDocument();
            $document->loadXML($this->readSpdxXmlContent());
            $this->altSegmentCount = $this->countAltSegments($document->documentElement);
        }
        return $this->altSegmentCount;
    }

    /**
     * @return string
     */
    public function isCreativeCommons(): string
    {
        return str_starts_with(strtolower($this->getSpdxId()), "cc-");
    }
}
