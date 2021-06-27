<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

use function Psl\invariant;
use function Psl\Regex\capture_groups;
use function Psl\Regex\first_match;

final class Repository
{
    private function __construct(
        private string $owner,
        private string $package
    ) {
    }

    public static function named(string $repositoryName): self
    {
        $match = first_match($repositoryName, '`^([a-zA-Z0-9\-\_]+)\/([a-zA-Z0-9\-\_]+)$`i', capture_groups([1, 2]));
        invariant(null !== $match, 'Invalid repository name given.');
        [, $owner, $package] = $match;

        return new self($owner, $package);
    }

    public function owner(): string
    {
        return $this->owner;
    }

    public function package(): string
    {
        return $this->package;
    }
}
