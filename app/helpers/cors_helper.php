<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

if (!function_exists('handle_cors')) {
    function handle_cors()
    {
        // Comma-separated list in .env (CORS_ALLOWED_ORIGINS), with dev defaults
        $default = 'http://localhost:5173,http://127.0.0.1:5173,https://api-tester.marasigan.dev';
        $allowed = array_filter(array_map('trim', explode(',', getenv('CORS_ALLOWED_ORIGINS') ?: $default)));
        $origin  = $_SERVER['HTTP_ORIGIN'] ?? '';

        if ($origin !== '' && in_array($origin, $allowed, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
        }

        // Browsers send an OPTIONS "preflight" before PUT/DELETE or requests with a token
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}