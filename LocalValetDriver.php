<?php

/**
 * LocalValetDriver for Socialngine (CodeIgniter 3)
 *
 * Herd/Valet expects apps to have a public/ directory.
 * This driver tells Herd to serve from the project root instead,
 * where index.php lives for this CI3 application.
 *
 * It also blocks direct access to sensitive files and directories
 * that would otherwise be web-accessible without /public isolation.
 */
class LocalValetDriver extends \Valet\Drivers\BasicValetDriver
{
    /**
     * Directories and file patterns that must NEVER be served directly.
     */
    private const BLOCKED_PATHS = [
        '/app/',          // Application code, configs, models, controllers
        '/_sql/',         // Database schema dumps
        '/.git/',         // Git repository data
        '/.gitignore',    // Git config
        '/vendor/',       // Composer dependencies
        '/cron.sh',       // Cron runner script
        '/LocalValetDriver.php', // This file itself
    ];

    /**
     * Only serve static files from these directories.
     */
    private const ALLOWED_STATIC_DIRS = [
        '/assets/',
        '/themes/',
        '/public/',
        '/favicon.ico',
    ];

    /**
     * Determine if the driver serves the request.
     */
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        return file_exists($sitePath . '/index.php')
            && is_dir($sitePath . '/app/core/system');
    }

    /**
     * Determine if the incoming request is for a static file.
     * Only serves files from explicitly allowed directories.
     */
    public function isStaticFile(string $sitePath, string $siteName, string $uri)/*: string|false*/
    {
        // Block any request to sensitive paths
        foreach (self::BLOCKED_PATHS as $blocked) {
            if (stripos($uri, $blocked) === 0 || $uri === $blocked) {
                return false;
            }
        }

        // Only serve static files from allowed directories
        $allowed = false;
        foreach (self::ALLOWED_STATIC_DIRS as $dir) {
            if (stripos($uri, $dir) === 0 || $uri === $dir) {
                $allowed = true;
                break;
            }
        }

        if ($allowed && file_exists($staticFilePath = $sitePath . $uri)
            && is_file($staticFilePath)) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     */
    public function frontControllerPath(string $sitePath, string $siteName, string $uri): string
    {
        return $sitePath . '/index.php';
    }
}
