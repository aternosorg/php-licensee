
# PHP-Licensee

This library can be used to detect well-known licenses based on their title or content.
PHP-Licensee is based on the [Licensee Ruby Gem](https://github.com/licensee/licensee), but not quite a full port.

Information about licenses is generated from data from [choosealicense.com](https://github.com/github/choosealicense.com)
and the [SPDX License List](https://github.com/spdx/license-list-XML).
Note that only licenses that are listed on choosealicense.com can be detected by this library.

## Installation

```shell
composer require aternos/licensee
```

## Usage

```php
$licensee = new \Aternos\Licensee\Licensee();
```

### Detect license by ID string

```php
$license = $licensee->findLicenseById('mit');
echo "Found " . $license->getTitle() . "\n";
```

### Detect license by title

```php
$license = $licensee->findLicenseByTitle('MIT License');
echo "Found " . $license->getTitle() . "\n";
```

Setting the optional argument `allowMatchWithoutVersion` to `true` will allow the detection of licenses without considering the version number.
Note that this will return the first license that matches the title, which might not be the correct one if version numbers are ignored.

### Detect license by content

```php
$content = new \Aternos\Licensee\License\Text\LicenseText(file_get_contents('LICENSE'), 'LICENSE');
$match = $licensee->findLicenseByContent($content);
echo "Found " . $match->getLicense()->getTitle() . "\n";
echo "Confidence: " . $match->getConfidence() . "\n";
```

This will try to find a license that is an exact match ([after some normalization steps](src/TextTransformer/)),
or use a version of the [Dice-Sørensen coefficient](https://en.wikipedia.org/wiki/Dice-S%C3%B8rensen_coefficient).

Optionally, a `confidenceThreshold` value between 0 and 100 can be supplied to `findLicenseByContent`.
If not set, the default value of 98.0 will be used.

### Get license information

Most of the information available on choosealicense.com can be accessed through the license object:

```php

$license = $licensee->findLicenseById('mit');

echo "Title: " . $license->getTitle() . "\n";
echo "ID: " . $license->getSpdxId()->value . "\n";
echo "Description: " . $license->getDescription() . "\n";
echo "How: " . $license->getHow() . "\n";

echo "Using:\n";
foreach ($license->getUsing() as $using) {
    echo "  - " . $using . "\n";
}

echo "Permissions:\n";
foreach ($license->getPermissions() as $permission) {
    echo "  - " . $permission->getLabel() . ": " . $permission->getDescription() . "\n";
}

echo "Conditions:\n";
foreach ($license->getConditions() as $condition) {
    echo "  - " . $condition->getLabel() . ": " . $condition->getDescription() . "\n";
}

echo "Limitations:\n";
foreach ($license->getLimitations() as $limitation) {
    echo "  - " . $limitation->getLabel() . ": " . $limitation->getDescription() . "\n";
}

```

## Key differences to Ruby Licensee

### No projects

This library does not automatically scan project directories for license files or package metadata.
Finding the correct license file is up to the user.

### No pseudo licenses

Ruby Licensee can return the pseudo licenses `other` and `no-license` if no license could be detected.
This library will simply return `null` in this case.
