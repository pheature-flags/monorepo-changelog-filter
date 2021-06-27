<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

use function Psl\invariant;
use function Psl\Iter\first;
use function Psl\Iter\last;
use function Psl\Regex\capture_groups;
use function Psl\Regex\every_match;
use function Psl\Regex\first_match;
use function Psl\Vec\filter;
use function Psl\Vec\map_with_key;
use function Psl\Vec\values;

final class Release
{
    private const RELEASE_REGEX = '`^(\#\#\s.*$\.*(?:\n+))(?:^\#\#\s.*$|\Z)`msU';
    private const TITLE_REGEX = '`^(\#\#\s\[([a-z0-9\-\_\.]+)\]\(.*\))$`mi';
    private const LINK_REGEX = '`^(\[Full Changelog\]\(.*\))$`mi';
    private const ISSUE_TYPES_REGEX = '`^(\*\*.*\*\*)$`misU';
    private const ISSUES_REGEX = '`\n+(^-\s.*$)\n(?:^\*\*|^\\\\\*\s\*|\Z)`msU';

    /**
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
        $match = first_match($release, self::TITLE_REGEX, capture_groups([1]));
        invariant(null !== $match, 'Invalid release title given.');
        $title = (string)last($match);

        $match = first_match($release, self::LINK_REGEX, capture_groups([1]));
        invariant(null !== $match, 'Invalid release link given.');
        $link = (string)last($match);

        /** @var array<int, array<string>> $match */
        $match = every_match($release, self::ISSUE_TYPES_REGEX, capture_groups([1]));
        /** @var array<int, array<string>> $match1 */
        $match1 = every_match($release, self::ISSUES_REGEX, capture_groups([1]));

        invariant(
            $match1 === $match || \Psl\Iter\count($match) === \Psl\Iter\count($match1),
            'Every issue type in release should have at least one issue associated.'
        );

        if ($match1 === $match) {
            return new self($title, $link, []);
        }

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
        $match = every_match($fullChangelog, self::RELEASE_REGEX, capture_groups([0, 1]));

        return null === $match ? null : (string)last((array)first($match));
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
