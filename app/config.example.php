<?php
/**
 * Socialngine — Local Environment Configuration
 *
 * Copy this file to config.php and fill in your local credentials:
 *   cp app/config.example.php app/config.php
 */

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');          // Your DBngin MySQL password
define('DB_NAME', 'socialngine_db');
define('TIMEZONE', 'Africa/Lagos');  // Adjust to your timezone
// Generate with: php -r "echo bin2hex(random_bytes(16));"
define('ENCRYPTION_KEY', 'GENERATE_YOUR_OWN_KEY_HERE');
