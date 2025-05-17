<?php
/**
 * Plugin Name: Wawes Background Ultimate by DDG - site go-studio.pro
 * Plugin URI: https://github.com/ddg-griggs/wawes-design-ddg-v1.2 
 * Plugin Info: wp-content/plugins/wawe-design-ddg-v1.2/readme.txt
 * Description: [EN] Animated waves on the background of the site with color settings and the number of page IDs. [RU] Анимированные волны на фоне сайта с настройками цвета, и количества ID страниц.
 * Version: 1.2 : 15.05.2025
 * Author: Dorel Dankov
 */
 
if (!defined('ABSPATH')) exit;

function ddg_wawe_enqueue_assets() {
    $options = get_option('ddg_wawe_settings');
    $page_ids = array_filter([
        $options['elementor_page_id_1'] ?? null,
        $options['elementor_page_id_2'] ?? null,
        $options['elementor_page_id_3'] ?? null,
    ]);

    foreach ($page_ids as $page_id) {
        if (is_page($page_id)) {
            wp_enqueue_style('ddg-wawe-style', plugin_dir_url(__FILE__) . 'assets/style.css');
            wp_enqueue_script('ddg-wawe-script', plugin_dir_url(__FILE__) . 'assets/waves.js', array(), null, true);
            wp_localize_script('ddg-wawe-script', 'DDG_WAWE_OPTIONS', $options);
            break;
        }
    }
}
add_action('wp_enqueue_scripts', 'ddg_wawe_enqueue_assets');

add_action('wp_footer', function () {
    $options = get_option('ddg_wawe_settings');
    $page_ids = array_filter([
        $options['elementor_page_id_1'] ?? null,
        $options['elementor_page_id_2'] ?? null,
        $options['elementor_page_id_3'] ?? null,
    ]);

    foreach ($page_ids as $page_id) {
        if (is_page($page_id)) {
            $background = esc_attr($options['background_color'] ?? 'linear-gradient(to bottom, #111 0%, #222 50%, #111 100%)');
            echo "<style>body { background: {$background}; }</style>";
            echo '<canvas id="waves"></canvas>';
            break;
        }
    }
});

require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
