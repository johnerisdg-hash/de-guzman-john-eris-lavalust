<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductMiddleware
{
    public function handle($next)
    {
        $auth = lava_instance()->call->library('auth');

        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        if ($auth->is_admin()) {
            return $next();
        }

        redirect('products/login');
        return false;
    }
}