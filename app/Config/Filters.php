<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

/**
 * Filters configuration.
 *
 * The two important things in this file:
 *   1. The `csrf` alias is registered under `aliases`.
 *   2. The `csrf` filter is enabled globally on every POST/PUT/DELETE
 *      via the `globals.before` array, which protects all state-changing
 *      requests against Cross-Site Request Forgery.
 *
 * Our custom `auth` filter is also registered here so it can be used by
 * the route group in app/Config/Routes.php.
 */
class Filters extends BaseFilters
{
    /**
     * Filter aliases — short names that map to filter classes.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // Our custom authentication guard.
        'auth' => \App\Filters\AuthFilter::class,
    ];

    /**
     * List of filters that are required and run on every request.
     */
    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    /**
     * Globally applied filters.
     *
     * The CSRF filter runs *before* every request that mutates state.
     * CodeIgniter automatically restricts CSRF to POST/PUT/PATCH/DELETE.
     */
    public array $globals = [
        'before' => [
            'csrf',          // <-- CSRF protection is enabled here.
            // 'honeypot',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Filters mapped to specific HTTP methods.
     */
    public array $methods = [];

    /**
     * Filters mapped to URI patterns.
     */
    public array $filters = [];
}
