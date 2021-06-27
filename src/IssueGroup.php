<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

use function Psl\invariant;
use function Psl\Iter\last;
use function Psl\Regex\capture_groups;
use function Psl\Regex\every_match;
use function Psl\Vec\filter;
use function Psl\Vec\map;

final class IssueGroup
{
    /**
     * IssueGroup constructor.
     * @param string $type
     * @param array<string> $issues
     */
    private function __construct(
        private string $type,
        private array $issues
    ) {
    }

    public static function fromMarkdown(string $type, string $markdownIssues, Matcher $matcher): self
    {
        $match = every_match($markdownIssues, '`(\-\s.*)+`i', capture_groups([1]));
        invariant(null !== $match, 'At least one issue is required');
        $issues = map($match, static fn(array $issue): string => (string)last($issue));
        $issues = filter($issues, static fn(string $issue) => $matcher->match($issue));

        return new self($type, $issues);
    }

    /**
     * @return array<string>
     */
    public function issues(): array
    {
        return $this->issues;
    }

    public function parse(): string
    {
        $issuesMarkdown = '';
        foreach ($this->issues as $issue) {
            $issuesMarkdown .= $issue . PHP_EOL;
        }

        return <<<MARKDOWN
        $this->type
        
        $issuesMarkdown

        MARKDOWN;
    }
}
