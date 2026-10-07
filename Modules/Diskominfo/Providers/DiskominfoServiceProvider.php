<?php

namespace Modules\Diskominfo\Providers;

use Illuminate\Support\ServiceProvider;

class DiskominfoServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Diskominfo';

    /**
     * @var string
     */
    protected $moduleNameLower = 'diskominfo';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $sourcePath = FCPATH . 'Modules' . DIRECTORY_SEPARATOR . $this->moduleName . DIRECTORY_SEPARATOR . 'Views';

        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            $this->moduleNameLower
        );
    }
}
