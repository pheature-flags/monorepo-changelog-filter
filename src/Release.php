<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

use function Psl\invariant;
use function Psl\Iter\last;
use function Psl\Regex\capture_groups;
use function Psl\Regex\every_match;
use function Psl\Regex\first_match;
use function Psl\Vec\filter;
use function Psl\Vec\map_with_key;
use function Psl\Vec\values;

final class Release
{
    /**
     * Release constructor.
     * @param string $title
     * @param string $link
     * @param IssueGroup[] $issueGroups
     */
    private function __construct(
        private string $title,
        private string $link,
        private array $issueGroups,
    ) {
    }

    public static function fromMarkdown(string $release, Matcher $matcher): self
    {
        $match = first_match($release, '`^(\#\#\s\[([a-z0-9\-\_\.]+)\]\(.*\))$`mi', capture_groups([1]));
        invariant(null !== $match, 'Invalid release title given.');
        $title = (string)last($match);

        $match = first_match($release, '`^(\[Full Changelog\]\(.*\))$`mi', capture_groups([1]));
        invariant(null !== $match, 'Invalid release link given.');
        $link = (string)last($match);

        /** @var array<int, array<string>> $match */
        $match = every_match($release, '`^(\*\*.*\*\*)$`misU', capture_groups([1]));
        /** @var array<int, array<string>> $match1 */
        $match1 = every_match($release, '`\n+(^\-.*$)\n(?:\*\*|\Z)`misU', capture_groups([1]));
        invariant(
            \Psl\Iter\count($match) === \Psl\Iter\count($match1),
            'Every issue type in release should have at least one issue associated.'
        );
        $issues = map_with_key(
            $match,
            static function (int $key, array $type) use ($match1, $matcher): IssueGroup {
                return IssueGroup::fromMarkdown((string)last($type), (string)last($match1[$key]), $matcher);
            }
        );
        $issues = filter($issues, static fn(IssueGroup $issueGroup) => [] !== $issueGroup->issues());

        return new self($title, $link, values($issues));
    }

    public static function slice(string $fullChangelog): ?string
    {
        $match = first_match($fullChangelog, '`(^\#\#\s.*$\n+.*\n)(?:^\#\#|\Z)`msU', capture_groups([1]));
        if (null === $match) {
            return null;
        }

        return (string)last($match);
    }

    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return IssueGroup[]
     */
    public function issueGroups(): array
    {
        return $this->issueGroups;
    }

    public function parse(): string
    {
        $issuesMarkdown = '';
        foreach ($this->issueGroups as $issue) {
            $issuesMarkdown .= $issue->parse();
        }

        return <<<MARKDOWN
        $this->title
        
        $this->link
        
        $issuesMarkdown
        MARKDOWN;
    }
}
