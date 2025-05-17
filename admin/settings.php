<?php
if (!defined('ABSPATH')) exit;

function ddg_wawe_settings_menu() {
    add_options_page('Wawes by DDG', 'Wawes by DDG', 'manage_options', 'ddg-wawe-settings', 'ddg_wawe_settings_page');
}
add_action('admin_menu', 'ddg_wawe_settings_menu');

function ddg_wawe_register_settings() {
    register_setting('ddg_wawe_settings_group', 'ddg_wawe_settings');
}
add_action('admin_init', 'ddg_wawe_register_settings');

function ddg_wawe_settings_page() {
    $options = get_option('ddg_wawe_settings');
    ?>
    <div class="wrap">
        <h1>Настройки Wawes Background Ultimate by DDG - site <a href="https://www.go-studio.pro/plugin/wawes">go-studio.pro</a></h1>
        <form method="post" action="options.php">
            <?php settings_fields('ddg_wawe_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Цвет фона (CSS)</th>
                    <td><input type="text" name="ddg_wawe_settings[background_color]" value="<?php echo esc_attr($options['background_color'] ?? 'linear-gradient(to bottom, #111 0%, #222 50%, #111 100%)'); ?>" placeholder="например: #111 или linear-gradient(...)" size="60" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Количество волн</th>
                    <td><input type="number" name="ddg_wawe_settings[wave_count]" value="<?php echo esc_attr($options['wave_count'] ?? 3); ?>" min="1" max="5" /></td>
                </tr>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <tr valign="top">
                    <th scope="row">Цвет волны <?php echo $i; ?></th>
                    <td><input type="text" name="ddg_wawe_settings[wave_color_<?php echo $i; ?>]" value="<?php echo esc_attr($options["wave_color_$i"] ?? ''); ?>" placeholder="например: rgba(255,255,255,0.3)" /></td>
                </tr>
                <?php endfor; ?>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                <tr valign="top">
                    <th scope="row">ID страницы Elementor <?php echo $i; ?></th>
                    <td><input type="text" name="ddg_wawe_settings[elementor_page_id_<?php echo $i; ?>]" value="<?php echo esc_attr($options["elementor_page_id_$i"] ?? ''); ?>" placeholder="Например: 123" /></td>
                </tr>
                <?php endfor; ?>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
