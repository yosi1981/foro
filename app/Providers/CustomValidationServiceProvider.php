<?php

namespace App\Providers;

use App\Core\PermissionSettings;
use App\Forum\Forum;
use App\User\Role;
use Illuminate\Support\ServiceProvider;
use Validator;

class CustomValidationServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Ensure that the selected forum is a valid forum
        Validator::extend('valid_forum', function ($attribute, $value, $parameters, $validator) {
            return $this->validateInDatabase($value, $parameters, Forum::class);
        });

        // Ensure that the selected role is a valid role
        Validator::extend('valid_role', function ($attribute, $value, $parameters, $validator) {
           return $this->validateInDatabase($value, $parameters, Role::class);
        });

        // Ensure that the selected permission setting is a valid permission setting
        Validator::extend('valid_permission_settings', function ($attribute, $value, $parameters, $validator) {
            return $this->validateInDatabase($value, $parameters, PermissionSettings::class);
        });
    }

    public function validateInDatabase($value, $parameters, $modal)
    {
        // Check if the field allows multiple selection
        if (in_array('allow_multiple', $parameters)) {
            // Check if the number of selected values is equal to the results found in database.
            // If it's not equal, we know that at least one or more results have not been found in database,
            // making one or more selections invalid
            return count($value) == $modal::find($value)->count();
        }
        return array_key_exists(0, $parameters) && in_array('allow_none', $parameters) && $value == 0 ? true : $modal::find($value);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
