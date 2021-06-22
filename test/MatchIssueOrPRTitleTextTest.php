<?php

declare(strict_types=1);

namespace Test\Pheature\Changelog\Filter;

use Pheature\Changelog\Filter\MatchIssueOrPRTitleText;
use PHPUnit\Framework\TestCase;

final class MatchIssueOrPRTitleTextTest extends TestCase
{
    /** @dataProvider getChangelogLineSample */
    public function testItShouldMatchIfIssueTitleMatchesWithGivenCriteria(string $match, string $line, bool $expectedResult): void
    {
        $matchTitleText = new MatchIssueOrPRTitleText();
        $result = $matchTitleText->isSatisfiedBy($match, $line);

        self::assertSame($expectedResult, $result);
    }

    public function getChangelogLineSample(): \Generator
    {
        yield 'It should match with when title starts exactly with given string.' => [
            '[toggle-crud]',
            '- \[toggle-crud\] Allow adding strategies with segments',
            true,
        ];

        yield 'It should not match with when title doesn\'t starts exactly with given string.' => [
            '[toggle--crud]',
            '- \[toggle-crud\] Allow adding strategiees with segments',
            false,
        ];
    }
}
    