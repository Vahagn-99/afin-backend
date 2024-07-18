<?php

namespace App\Modules\FilterManager\Provider;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class FilterValidationRulesProvider extends ServiceProvider
{
    public function boot(): void
    {
        Validator::extend('filterable', function ($attribute, $value) {
            if (is_string($value)) {
                return true;
            }

            if (is_numeric($value)) {
                return true;
            }

            if (is_bool($value)) {
                return true;
            }

            if (is_array($value)) {
                return true;
            }

            return false;
        }, 'The :attribute must be a string, number, boolean, or array.');
    }
}
