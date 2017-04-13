<?php

namespace Laralum\Advertisements;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laralum\Advertisements\Models\Advertisement;
use Laralum\Advertisements\Models\Settings;
use Laralum\Advertisements\Policies\AdvertisementPolicy;
use Laralum\Advertisements\Policies\SettingsPolicy;
use Laralum\Permissions\PermissionsChecker;

class AdvertisementsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Advertisement::class => AdvertisementPolicy::class,
        Settings::class      => SettingsPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Advertisements Access',
            'slug' => 'laralum::advertisements.access',
            'desc' => 'Grants access to laralum/advertisements module',
        ],
        [
            'name' => 'Create Advertisements',
            'slug' => 'laralum::advertisements.create',
            'desc' => 'Allows creating advertisements',
        ],
        [
            'name' => 'Update Advertisements',
            'slug' => 'laralum::advertisements.update',
            'desc' => 'Allows updating advertisements',
        ],
        [
            'name' => 'View Advertisements',
            'slug' => 'laralum::advertisements.view',
            'desc' => 'Allows previewing advertisements',
        ],
        [
            'name' => 'Advertisements Statistics',
            'slug' => 'laralum::advertisements.statistics',
            'desc' => 'Allows viewing the advertisements statistics',
        ],
        [
            'name' => 'Advertisements Specific Statistics',
            'slug' => 'laralum::advertisements.specific_statistics',
            'desc' => 'Allows viewing specific advertisement statistics',
        ],
        [
            'name' => 'Advertisements Settings',
            'slug' => 'laralum::advertisements.settings.update',
            'desc' => 'Allows updating the advertisements settings',
        ],
        [
            'name' => 'Delete Advertisements',
            'slug' => 'laralum::advertisements.delete',
            'desc' => 'Allows delete advertisements',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_advertisements');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_advertisements');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider.
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
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
