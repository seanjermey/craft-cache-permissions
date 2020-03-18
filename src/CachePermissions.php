<?php
/**
 * Cache Permissions plugin for Craft CMS 3.x
 *
 * Plugin allows you to restrict who can clear each cache group based on their user group.
 *
 * @link      https://github.com/seanjermey
 * @copyright Copyright (c) 2020 Sean Jermey
 */

namespace seanjermey\cachepermissions;


use Craft;
use craft\base\Plugin;
use craft\events\RegisterCacheOptionsEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;
use craft\utilities\ClearCaches;
use yii\base\Event;

/**
 *
 * @author    Sean Jermey
 * @package   CachePermissions
 * @since     1.0.0
 *
 */
class CachePermissions extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * CachePermissions::$plugin
     *
     * @var CachePermissions
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        /**
         * Log plugin loaded.
         */
        Craft::info(
            Craft::t(
                'cache-permissions',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

        /**
         * Filter cache options based on permissions.
         */
        Event::on(
            ClearCaches::class,
            ClearCaches::EVENT_REGISTER_CACHE_OPTIONS,
            function (RegisterCacheOptionsEvent $event) {

                foreach ($event->options as $key => $option) {

                    if (!Craft::$app->user->checkPermission($option['key'])) {
                        unset($event->options[$key]);
                    }
                }
            }
        );

        /**
         * Add cache permission options.
         */
        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function (RegisterUserPermissionsEvent $event) {

                $nestedCacheOptions = [];

                foreach (ClearCaches::cacheOptions() as $option) [
                    $nestedCacheOptions[$option['key']] = [
                        'label' => $option['label']
                    ]
                ];

                ksort($nestedCacheOptions);

                $event->permissions['Utilities']['utility:clear-caches']['nested'] = $nestedCacheOptions;
            }
        );
    }

    // Protected Methods
    // =========================================================================

}
