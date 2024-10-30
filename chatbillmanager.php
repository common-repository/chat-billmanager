<?php
/*
Plugin Name: Chat BILLmanager
Plugin URI: https://ivanscm.name/wordpress-plugin-for-connect-chat-billmanager/
Description: WordPress Plugin for connect chat BILLmanager.
Version: 0.1
Author: IvanSCM
Author URI: http://ivanscm.name
*/

const CHAT_BILLMANEGER_LOCALIZATION_DOMAIN = 'chatbillmanager',
CHAT_BILLMANAGER_DEFAULT_PROJECT_ID = 1,
CHAT_BILLMANAGER_DEFAULT_BORDER_COLOR = '#CCC',
CHAT_BILLMANAGER_DEFAULT_BACKGROUND_COLOR = '#99c21c';

class ChatBILLManager
{
    public $settings;

    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'chat_billmanager_init'));
        $this->settings = get_option('chat_billmanager_settings_option_name');
        if (!empty($this->settings['base_url'])) {
            add_action('wp_footer', array($this, 'chat_billmanager_footer'), 100);
            add_action('wp_enqueue_scripts', array($this, 'chat_billmanager_enqueue_scripts'));
        }
    }

    function chat_billmanager_init()
    {
        load_plugin_textdomain(CHAT_BILLMANEGER_LOCALIZATION_DOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    public function chat_billmanager_footer()
    {
        ?>
        <script>
            if (window.billChat) {
                billChat.init({
                    project: <?php echo $this->settings['project_id']; ?>,
                    lang: '<?php echo $this->settings['lang']; ?>',
                    backgroundColor: '<?php echo $this->settings['background_color']; ?>',
                    borderColor: '<?php echo $this->settings['border_color']; ?>',
                    baseUrl: '<?php echo $this->settings['base_url']; ?>:3002/'
                });
            }
        </script>
        <?php
    }

    public function chat_billmanager_enqueue_scripts()
    {
        wp_enqueue_script('chat-billmanager-remote', "{$this->settings['base_url']}:3002/js/index.js", array(), '1.0.0', true);
    }
}

$chat_billmanager = new ChatBILLManager();

include 'settings.php';