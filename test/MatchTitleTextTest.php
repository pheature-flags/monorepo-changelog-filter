<?php

declare(strict_types=1);

namespace Test\Pheature\Changelog\Filter;

use Pheature\Changelog\Filter\MatchTitleText;
use PHPUnit\Framework\TestCase;

final class MatchTitleTextTest extends TestCase
{
    public function testItShouldMatchIfIssueTitleMatchesWithGivenCriteria(): void
    {
        $matchTitleText = new MatchTitleText();

        self::assertInstanceOf(MatchTitleText::class, $matchTitleText);
    }
}
    