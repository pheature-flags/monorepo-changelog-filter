<?php

declare(strict_types=1);

namespace Test\Pheature\Changelog\Filter;

use Pheature\Changelog\Filter\Release;
use PHPUnit\Framework\TestCase;

final class ReleaseTest extends TestCase
{
    private const RELEASE = <<<MARKDOWN
    ## [Unreleased](https://github.com/pheature-flags/pheature-flags/tree/HEAD)

    [Full Changelog](https://github.com/pheature-flags/pheature-flags/compare/v0.1.1...HEAD)
    
    **Fixed bugs:**
    
    - \[toggle-crud-psr7-api\] fix typo [\#262](https://github.com/pheature-flags/pheature-flags/pull/262) ([kpicaza](https://github.com/kpicaza))
    - \[toggle-psr11-factories\] Add mutation badge  [\#245](https://github.com/pheature-flags/pheature-flags/issues/245)

    **Closed issues:**
    
    - \[toggle-psr11-factories\] Add psalm badge [\#246](https://github.com/pheature-flags/pheature-flags/issues/246)
    - \[toggle-psr11-factories\] Add mutation badge  [\#245](https://github.com/pheature-flags/pheature-flags/issues/245)
    - \[toggle-crud-psr7-api\] Add maintainability badge  [\#238](https://github.com/pheature-flags/pheature-flags/issues/238)
    - Add Infection Mutation testing coverage Badge to Toggle CRUD PSR-7 API package [\#81](https://github.com/pheature-flags/pheature-flags/issues/81)
    
    **Merged pull requests:**
    
    - \[toggle-crud-psr11-factories\] add psalm badge [\#260](https://github.com/pheature-flags/pheature-flags/pull/260) ([kpicaza](https://github.com/kpicaza))
    - \[toggle-crud-psr11-factories\] add mutation badge [\#259](https://github.com/pheature-flags/pheature-flags/pull/259) ([kpicaza](https://github.com/kpicaza))
    - \[toggle-crud-psr7-api\] add codeclimate badge [\#239](https://github.com/pheature-flags/pheature-flags/pull/239) ([kpicaza](https://github.com/kpicaza))
    - \[toggle-crud-psr7-api\] add scrutinizer badge [\#237](https://github.com/pheature-flags/pheature-flags/pull/237) ([kpicaza](https://github.com/kpicaza))

    MARKDOWN;

    public function testItShouldBeCreatedFromMarkdown(): void
    {
        $release = Release::fromMarkdown(self::RELEASE);
        self::assertSame(
            '## [Unreleased](https://github.com/pheature-flags/pheature-flags/tree/HEAD)',
            $release->title()
        );
        self::assertCount(3, $release->issues());
    }
}
