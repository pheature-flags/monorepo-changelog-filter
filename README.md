# Pheature flags changelog filter

The main goal of this package is to get global changelog and generate a filtered version depending 
on Issue and Pull request titles.

Having the following CHANGELOG.md file, generated using [Github changelog generator] tool. We need to extract 
the lines that matches with some package like `toggle-crud-psr7-api`, the output result should have only lines
formatted as `[toggle-crud-psr7-api] Issue or pull request tittle` 

```markdown
# Changelog

## [Unreleased](https://github.com/pheature-flags/pheature-flags/tree/HEAD)

[Full Changelog](https://github.com/pheature-flags/pheature-flags/compare/v0.1.1...HEAD)

**Fixed bugs:**

- \[toggle-crud-psr7-api\] fix typo [\#262](https://github.com/pheature-flags/pheature-flags/pull/262) ([kpicaza](https://github.com/kpicaza))

**Closed issues:**

- \[toggle-crud-psr11-factories\] Add psalm badge [\#246](https://github.com/pheature-flags/pheature-flags/issues/246)
- \[toggle-crud-psr11-factories\] Add mutation badge  [\#245](https://github.com/pheature-flags/pheature-flags/issues/245)
- \[toggle-crud-psr11-factories\] Add Packagist download badge [\#244](https://github.com/pheature-flags/pheature-flags/issues/244)
- \[toggle-crud-psr11-factories\] Add Code climate badge [\#243](https://github.com/pheature-flags/pheature-flags/issues/243)
- \[toggle-crud-psr11-factories\] Fix dependency issues [\#242](https://github.com/pheature-flags/pheature-flags/issues/242)
- \[toggle-crud-psr11-factories\] Add Scrutinizer badge  [\#241](https://github.com/pheature-flags/pheature-flags/issues/241)
- \[toggle-crud-psr11-factories\] Add Codecov badge [\#240](https://github.com/pheature-flags/pheature-flags/issues/240)
- \[toggle-crud-psr7-api\] Add maintainability badge  [\#238](https://github.com/pheature-flags/pheature-flags/issues/238)

**Merged pull requests:**

- \[toggle-crud-psr11-factories\] add psalm badge [\#260](https://github.com/pheature-flags/pheature-flags/pull/260) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr11-factories\] add mutation badge [\#259](https://github.com/pheature-flags/pheature-flags/pull/259) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr11-factories\] add code climate badge [\#258](https://github.com/pheature-flags/pheature-flags/pull/258) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr11-factories\] add packagist version badge [\#257](https://github.com/pheature-flags/pheature-flags/pull/257) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr11-factories\] add scrutinizer badge [\#256](https://github.com/pheature-flags/pheature-flags/pull/256) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr7-api\] add codeclimate badge [\#239](https://github.com/pheature-flags/pheature-flags/pull/239) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr7-api\] add scrutinizer badge [\#237](https://github.com/pheature-flags/pheature-flags/pull/237) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr7-api\] add codecov badge [\#236](https://github.com/pheature-flags/pheature-flags/pull/236) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr7-api\] add striker mutation badge [\#235](https://github.com/pheature-flags/pheature-flags/pull/235) ([kpicaza](https://github.com/kpicaza))
```

```bash
bin/console pheature:changelog:filter pheature/toggle-crud-psr7-api "$(cat CHANGELOG.md)"
```
Will give the next output

```markdown
# Changelog

## [Unreleased](https://github.com/pheature-flags/pheature-flags/tree/HEAD)

[Full Changelog](https://github.com/pheature-flags/pheature-flags/compare/v0.1.1...HEAD)

**Fixed bugs:**

- \[toggle-crud-psr7-api\] fix typo [\#262](https://github.com/pheature-flags/pheature-flags/pull/262) ([kpicaza](https://github.com/kpicaza))

**Closed issues:**

- \[toggle-crud-psr7-api\] Add maintainability badge  [\#238](https://github.com/pheature-flags/pheature-flags/issues/238)

**Merged pull requests:**

- \[toggle-crud-psr7-api\] add codeclimate badge [\#239](https://github.com/pheature-flags/pheature-flags/pull/239) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr7-api\] add scrutinizer badge [\#237](https://github.com/pheature-flags/pheature-flags/pull/237) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr7-api\] add codecov badge [\#236](https://github.com/pheature-flags/pheature-flags/pull/236) ([kpicaza](https://github.com/kpicaza))
- \[toggle-crud-psr7-api\] add striker mutation badge [\#235](https://github.com/pheature-flags/pheature-flags/pull/235) ([kpicaza](https://github.com/kpicaza))
```
