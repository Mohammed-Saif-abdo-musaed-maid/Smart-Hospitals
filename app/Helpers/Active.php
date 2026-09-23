<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class Active
{
    /**
     * Return the "active" css class when the current route name
     * matches one of the given route names.
     *
     * @param  string|array  $routes
     * @return string
     */
    public static function checkRoute($routes)
    {
        $currentRouteName = Route::currentRouteName();

        foreach ((array) $routes as $route) {
            if ($route === $currentRouteName) {
                return 'active';
            }
        }

        return '';
    }
}