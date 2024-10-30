<?php

class ChatBILLmanagerSettings
{
    private $chat_billmanager_settings_options;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'chat_billmanager_settings_add_plugin_page'));
        add_action('admin_init', array($this, 'chat_billmanager_settings_page_init'));
        add_action('admin_enqueue_scripts', array($this, 'chat_billmanager_settings_enqueue_scripts'));
        add_action('admin_notices', array($this, 'chat_billmanager_settings_admin_notice'));
    }

    public function chat_billmanager_settings_add_plugin_page()
    {
        add_options_page(
            __('Chat BILLmanager', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            __('Chat BILLmanager', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            'manage_options',
            'chat-billmanager-settings',
            array($this, 'chat_billmanager_settings_create_admin_page') // function
        );
    }

    public function chat_billmanager_settings_create_admin_page()
    {
        $this->chat_billmanager_settings_options = get_option('chat_billmanager_settings_option_name'); ?>

        <div class="wrap">
            <h2><?php _e('Chat BILLmanager', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN); ?></h2>
            <p><?php _e('WordPress Plugin for connect chat BILLmanager.', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN); ?></p>
            <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('chat_billmanager_settings_option_group');
                do_settings_sections('chat-billmanager-settings-admin');
                submit_button();
                ?>
            </form>
        </div>
    <?php }

    public function chat_billmanager_settings_page_init()
    {
        register_setting(
            'chat_billmanager_settings_option_group',
            'chat_billmanager_settings_option_name',
            array($this, 'chat_billmanager_settings_sanitize')
        );

        add_settings_section(
            'chat_billmanager_settings_setting_section',
            __('Settings', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            array($this, 'chat_billmanager_settings_section_info'),
            'chat-billmanager-settings-admin'
        );

        add_settings_field(
            'project_id',
            __('Project ID', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            array($this, 'project_id_callback'),
            'chat-billmanager-settings-admin',
            'chat_billmanager_settings_setting_section'
        );

        add_settings_field(
            'lang',
            __('Language', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            array($this, 'lang_callback'),
            'chat-billmanager-settings-admin',
            'chat_billmanager_settings_setting_section'
        );

        add_settings_field(
            'background_color',
            __('Background color', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            array($this, 'background_color_callback'),
            'chat-billmanager-settings-admin',
            'chat_billmanager_settings_setting_section'
        );

        add_settings_field(
            'border_color',
            __('Border color', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            array($this, 'border_color_callback'),
            'chat-billmanager-settings-admin',
            'chat_billmanager_settings_setting_section'
        );

        add_settings_field(
            'base_url',
            __('Billing URL', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN),
            array($this, 'base_url_callback'),
            'chat-billmanager-settings-admin',
            'chat_billmanager_settings_setting_section'
        );
    }

    public function chat_billmanager_settings_sanitize($input)
    {
        $sanitary_values = array();
        if (isset($input['project_id'])) {
            $sanitary_values['project_id'] = (int)$input['project_id'];
        }

        if (isset($input['lang'])) {
            $sanitary_values['lang'] = $input['lang'];
        }

        if (isset($input['background_color'])) {
            $sanitary_values['background_color'] = sanitize_text_field($input['background_color']);
        }

        if (isset($input['border_color'])) {
            $sanitary_values['border_color'] = sanitize_text_field($input['border_color']);
        }

        if (isset($input['base_url'])) {
            $sanitary_values['base_url'] = sanitize_text_field($input['base_url']);
        }

        return $sanitary_values;
    }

    public function chat_billmanager_settings_section_info()
    {

    }

    public function project_id_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="chat_billmanager_settings_option_name[project_id]" id="project_id" value="%s">',
            isset($this->chat_billmanager_settings_options['project_id']) ? esc_attr($this->chat_billmanager_settings_options['project_id']) : CHAT_BILLMANAGER_DEFAULT_PROJECT_ID
        );
    }

    public function lang_callback()
    {
        ?> <select name="chat_billmanager_settings_option_name[lang]" id="lang">
        <?php $selected = (isset($this->chat_billmanager_settings_options['lang']) && $this->chat_billmanager_settings_options['lang'] === 'en') ? 'selected' : ''; ?>
        <option value="en" <?php echo $selected; ?>><?php _e('English', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN) ?></option>
        <?php $selected = (isset($this->chat_billmanager_settings_options['lang']) && $this->chat_billmanager_settings_options['lang'] === 'ru') ? 'selected' : ''; ?>
        <option value="ru" <?php echo $selected; ?>><?php _e('Russian', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN) ?></option>
    </select> <?php
    }

    public function background_color_callback()
    {
        printf(
            '<input class="regular-text color-control" type="text" name="chat_billmanager_settings_option_name[background_color]" id="background_color" value="%s">',
            isset($this->chat_billmanager_settings_options['background_color']) ? esc_attr($this->chat_billmanager_settings_options['background_color']) : CHAT_BILLMANAGER_DEFAULT_BACKGROUND_COLOR
        );
    }

    public function border_color_callback()
    {
        printf(
            '<input class="regular-text color-control" type="text" name="chat_billmanager_settings_option_name[border_color]" id="border_color" value="%s">',
            isset($this->chat_billmanager_settings_options['border_color']) ? esc_attr($this->chat_billmanager_settings_options['border_color']) : CHAT_BILLMANAGER_DEFAULT_BORDER_COLOR
        );
    }

    public function base_url_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="chat_billmanager_settings_option_name[base_url]" id="base_url" value="%s">',
            isset($this->chat_billmanager_settings_options['base_url']) ? esc_attr($this->chat_billmanager_settings_options['base_url']) : ''
        );
    }

    function chat_billmanager_settings_enqueue_scripts($hook)
    {
        if ('settings_page_' . 'chat-billmanager-settings' != $hook)
            return;
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        add_action('admin_footer', array($this, 'chat_billmanager_settings_admin_footer_script'), 99);
    }

    function chat_billmanager_settings_admin_footer_script()
    {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#background_color').wpColorPicker({
                    defaultColor: '<?php echo CHAT_BILLMANAGER_DEFAULT_BACKGROUND_COLOR; ?>',
                    hide: true,
                    palettes: false
                });
                $('#border_color').wpColorPicker({
                    defaultColor: '<?php echo CHAT_BILLMANAGER_DEFAULT_BORDER_COLOR; ?>',
                    hide: true,
                    palettes: false
                });
            });
        </script>
        <?php
    }

    public function chat_billmanager_settings_echo_error($text)
    {
        echo '<div class="error"><p>' . $text . '</p></div>';
    }

    public function chat_billmanager_settings_admin_notice()
    {
        $settings = get_option('chat_billmanager_settings_option_name');
        if (empty($settings['base_url'])) {
            $this->chat_billmanager_settings_echo_error(__('For plug-in "Chat BILLmanager" billing address is not set. Chat is disabled.', CHAT_BILLMANEGER_LOCALIZATION_DOMAIN));
        }
    }

}

if (is_admin())
    $chat_billmanager_settings = new ChatBILLmanagerSettings();
