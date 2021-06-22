<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

final class MatchTitleText
{
    private const LINE_TITLE_PATTERN = '`^\-\s%s.*$`';

    public function isSatisfiedBy(string $match, string $line): bool
    {
        $regex = sprintf(self::LINE_TITLE_PATTERN, preg_quote(escapeshellcmd($match)));
        if (preg_match($regex, $line)) {
            return true;
        }

        return false;
    }
}
