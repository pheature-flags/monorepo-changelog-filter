<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

use function Psl\invariant;
use function Psl\Regex\matches;
use function Psl\Str\format;

final class Matcher
{
    public function __construct(
        private string $needle
    ) {
    }

    public function match(string $issue): bool
    {
        $regex = format('`%s`i', preg_quote($this->needle));
        invariant('' !== $regex, 'Matching regex could not be empty.');

        return matches($issue, $regex);
    }
}
