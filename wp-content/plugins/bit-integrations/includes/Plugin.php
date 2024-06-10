<?php

namespace BitCode\FI;

/**
 * Main class for the plugin.
 *
 * @since 1.0.0-alpha
 */

use BitCode\FI\Core\Database\DB;
use BitCode\FI\Admin\Admin_Bar;
use BitCode\FI\Core\Util\Request;
use BitCode\FI\Core\Util\Activation;
use BitCode\FI\Core\Util\Deactivation;
use BitCode\FI\Core\Util\UnInstallation;
use BitCode\FI\Core\Hooks\HookService;
use BitCode\FI\Core\Util\Capabilities;
use BitCode\FI\Core\Util\Hooks;
use BitCode\FI\Log\LogHandler;

final class Plugin
{
    /**
     * Main instance of the plugin.
     *
     * @since 1.0.0-alpha
     * @var   Plugin|null
     */
    private static $_instance = null;

    private $isLicActive;
    private $isPro;

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function initialize()
    {
        Hooks::add('plugins_loaded', [$this, 'init_plugin'], 12);
        (new Activation())->activate();
        (new Deactivation())->register();
        (new UnInstallation())->register();
    }

    public function init_plugin()
    {
        Hooks::add('init', [$this, 'init_classes'], 8);
        Hooks::add('init', [$this, 'integrationlogDelete'], 11);
        Hooks::filter('plugin_action_links_' . plugin_basename(BTCBI_PLUGIN_MAIN_FILE), [$this, 'plugin_action_links']);
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes()
    {
        static::update_tables();
        if (Request::Check('admin')) {
            (new Admin_Bar())->register();
        }
        new HookService();
    }

    /**
     * Plugin action links
     *
     * @param  array $links
     *
     * @return array
     */
    public function plugin_action_links($links)
    {
        $links[] = '<a href="https://docs.bit-integrations.bitapps.pro" target="_blank">' . __('Docs', 'bit-integrations') . '</a>';

        return $links;
    }

    /**
     * Retrieves the main instance of the plugin.
     *
     * @since 1.0.0-alpha
     *
     * @return Plugin main instance.
     */
    public static function instance()
    {
        return static::$_instance;
    }

    public static function update_tables()
    {
        if (!Capabilities::Check('manage_options')) {
            return;
        }
        global $btcbi_db_version;
        $installed_db_version = get_site_option('btcbi_db_version');
        if ($installed_db_version != $btcbi_db_version) {
            DB::migrate();
        }
    }

    public function isLicenseActive()
    {
        if (!isset($this->isLicActive)) {
            $this->isLicActive = false;
        }
        return $this->isLicActive;
    }
    public function isProVer()
    {
        $plugins_keys = array_keys(get_plugins());
        $plugin = 'bit-integrations-pro/bitwpfi.php';
        if (in_array($plugin, $plugins_keys) && is_plugin_active($plugin)) {
            $this->isPro =  true;
        } else {
            $this->isPro = false;
        }
        return $this->isPro;
    }

    /**
     * Loads the plugin main instance and initializes it.
     *
     * @since 1.0.0-alpha
     *
     * @param string $main_file Absolute path to the plugin main file.
     * @return bool True if the plugin main instance could be loaded, false otherwise./
     */
    public static function integrationlogDelete()
    {
        $option = get_option('btcbi_app_conf');
        if (isset($option->enable_log_del) && isset($option->day)) {
            LogHandler::logAutoDelte($option->day);
        }
    }

    public static function load($main_file)
    {
        if (null !== static::$_instance) {
            return false;
        }
        static::$_instance = new static($main_file);
        static::$_instance->initialize();
        return true;
    }
}
