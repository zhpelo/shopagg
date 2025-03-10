<?php
/*!
 * SHOPAGG  Open source e-commerce website system
 *
 * @author    SHOPAGG  <zhpelo@shopagg.org>
 * @link      https://shopagg.org Official Website
 *
 */

require_once('includes/app_header.inc.php');

// Development Mode
if (settings::get('development_mode')) {
    if (empty(user::$data['id']) && !preg_match('#^' . preg_quote(WS_DIR_ADMIN, '#') . '#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
        if (!in_array(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), [WS_DIR_APP . 'manifest.json'])) {
            http_response_code(403);
            include vmod::check(FS_DIR_APP . 'pages/development_mode.inc.php');
            require_once vmod::check(FS_DIR_APP . 'includes/app_footer.inc.php');
            exit;
        }
    }
}

// Maintenance Mode
if (settings::get('maintenance_mode')) {
    if (!empty(user::$data['id'])) {
        notices::add('notices', strtr('%message [<a href="%link">%preview</a>]', [
            '%message' => language::translate('reminder_store_in_maintenance_mode', 'The store is in maintenance mode.'),
            '%preview' => language::translate('title_preview', 'Preview'),
            '%link' => document::href_ilink('maintenance_mode'),
        ]), 'maintenance_mode');
    } else {
        if (!in_array(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), [WS_DIR_APP . 'manifest.json'])) {
            http_response_code(503);
            include vmod::check(FS_DIR_APP . 'pages/maintenance_mode.inc.php');
            require_once vmod::check(FS_DIR_APP . 'includes/app_footer.inc.php');
            exit;
        }
    }
}

// Load routes
route::load(FS_DIR_APP . 'includes/routes/url_*.inc.php');

// Append default route
route::add('#^([0-9a-zA-Z_\-/\.]+?)(?:\.php)?/?$#', '$1');

// Process route
route::process();

require_once vmod::check(FS_DIR_APP . 'includes/app_footer.inc.php');
