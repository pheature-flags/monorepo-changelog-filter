<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

use function Psl\Str\Byte\replace;

final class Changelog
{
    /**
     * Changelog constructor.
     * @param Repository $repository
     * @param Release[] $releases
     */
    private function __construct(
        private Repository $repository,
        private Matcher $matcher,
        private array $releases = []
    ) {
    }

    public static function createForRepository(string $repositoryName): self
    {
        $repositoryName = Repository::named($repositoryName);

        return new self(
            $repositoryName,
            new Matcher($repositoryName->package())
        );
    }

    public function fromMarkdownChangelog(string $fullChangelog): self
    {
        $chunkedChangelog = $fullChangelog;
        $releases = [];
        while (null !== ($release = Release::slice($chunkedChangelog))) {
            $releases[] = Release::fromMarkdown($release, $this->matcher);

            $chunkedChangelog = replace($chunkedChangelog, $release, '');
        }

        return new self($this->repository, $this->matcher, $releases);
    }

    public function repository(): Repository
    {
        return $this->repository;
    }

    /**
     * @return Release[]
     */
    public function releases(): array
    {
        return $this->releases;
    }

    public function parse(): string
    {
        $releasesMarkdown = '';
        foreach ($this->releases() as $release) {
            $releasesMarkdown .= $release->parse();
        }

        $releasesMarkdown = \Psl\Str\trim($releasesMarkdown);

        return <<<MARKDOWN
        # Changelog

        $releasesMarkdown
        
        MARKDOWN;
    }
}
