<?php

declare(strict_types=1);

namespace Pheature\Changelog\Filter;

use function Psl\Dict\merge;

final class Changelog
{
    /**
     * Changelog constructor.
     * @param Repository $repository
     * @param Release[] $releases
     */
    private function __construct(
        private Repository $repository,
        private array $releases = []
    ) {
    }

    public static function createForRepository(string $repositoryName): self
    {
        return new self(
            Repository::named($repositoryName)
        );
    }

    public function fromMarkdownChangelog(string $fullChangelog): self
    {
        $chunkedChangelog = $fullChangelog;
        $releases = [];
        while (null !== ($release = Release::slice($chunkedChangelog))) {
            $releases[] = Release::fromMarkdown($release);

            $chunkedChangelog = str_replace($release, '', $chunkedChangelog);
        }

        return new self($this->repository, $releases);
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
}
