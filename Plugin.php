<?php namespace CRSCompany\TailorDataExport;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'TailorDataExport',
            'description' => 'No description provided yet...',
            'author' => 'CRSCompany',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'CRSCompany\TailorDataExport\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'crscompany.tailordataexport.some_permission' => [
                'tab' => 'TailorDataExport',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerSettings()
    {
        return [
            'tailorDataExport' => [
                'label' => 'Tailor Data Export',
                'description' => 'Export and import Tailor data',
                'category' => 'Data',
                'icon' => 'icon-globe',
                'url' => Backend::url('crscompany/tailordataexport/adminpage'),
                'order' => 500,
                'keywords' => 'tailor data export import'
            ]
        ];
    }
}
