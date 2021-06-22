<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'var/cache/config-cache.php',
];

$aggregator = new ConfigAggregator([
    \Antidot\Cli\Container\Config\ConfigProvider::class,
    new PhpFileProvider(realpath(__DIR__).'/services/{{,*.}prod,{,*.}local,{,*.}dev}.php'),
    new ArrayProvider($cacheConfig),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
