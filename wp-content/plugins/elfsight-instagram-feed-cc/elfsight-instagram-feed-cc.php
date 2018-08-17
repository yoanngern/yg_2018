<?php
/*
Plugin Name: Elfsight Instagram Feed CC
Description: Add Instagram images to your website to engage your visitors
Plugin URI: https://elfsight.com/instagram-feed-instashow/wordpress/?utm_source=markets&utm_medium=codecanyon&utm_campaign=instagram-feed&utm_content=plugin-site
Version: 3.6.1
Author: Elfsight
Author URI: https://elfsight.com/?utm_source=markets&utm_medium=codecanyon&utm_campaign=instagram-feed&utm_content=plugins-list
*/

if (!defined('ABSPATH')) exit;


require_once('core/elfsight-plugin.php');

$elfsight_instagram_feed_config_path = plugin_dir_path(__FILE__) . 'config.json';
$elfsight_instagram_feed_config = json_decode(file_get_contents($elfsight_instagram_feed_config_path), true);

if (is_array($elfsight_instagram_feed_config['settings'])) {
    array_push($elfsight_instagram_feed_config['settings']['properties'], array(
        'id' => 'api',
        'name' => 'Custom API Url',
        'tab' => 'more',
        'type' => 'hidden',
        'defaultValue' => get_option('elfsight-instagram-feed-cc_custom_api_url', plugin_dir_url(__FILE__) . 'api/index.php')
    ));
}

function elfsight_instagram_feed_api_test() {
    $curl_support = function_exists('curl_init');

    if ($curl_support) {
        $default_api_path = plugin_dir_url(__FILE__) . 'api/index.php';

        $curl = curl_init();
        $curl_options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_URL => $default_api_path,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 60
        );
        curl_setopt_array($curl, $curl_options);
        $response_str = curl_exec($curl);
        curl_close($curl);

        @list ($response_headers_str, $response_body_encoded) = explode("\r\n\r\n", $response_str);

        $response_headers_raw_list = explode("\r\n", $response_headers_str);
        $response_http = array_shift($response_headers_raw_list);

        preg_match('#^([^\s]+)\s(\d+)\s([^$]+)$#', $response_http, $response_http_matches);
        array_shift($response_http_matches);

        list ($response_http_protocol, $response_http_code, $response_http_message) = $response_http_matches;

        if ($response_http_code && $response_http_code === '200') {
            return true;
        }
    } else {
        return true;
    }

    return false;
}

function elfsight_instagram_feed_api_custom_update() {
    $default_api_path = plugin_dir_path(__FILE__) . 'api';

    if (get_option('elfsight-instagram-feed-cc_custom_api_url')) {
        $format_option = str_replace(site_url(), '', get_option('elfsight-instagram-feed-cc_custom_api_url'));
        $format_option = preg_replace('#^\/?(.*?)\/?([a-zA-Z]+\.php)?$#', '$1', $format_option);

        $custom_api_path = ABSPATH . $format_option;
    } else {
        $custom_api_path = ABSPATH . 'elfsight-instagram-feed-api';
        add_option('elfsight-instagram-feed-cc_custom_api_url', site_url() . '/elfsight-instagram-feed-api/index.php');
    }

    if (!function_exists('elfsight_rrmdir')) {
        function elfsight_rrmdir($dir) {
            if (is_dir($dir)) {
                $files = scandir($dir);
                foreach ($files as $file) {
                    if ($file != "." && $file != "..") {
                        elfsight_rrmdir("$dir/$file");
                    }
                }

                rmdir($dir);
            } else if (file_exists($dir)) {
                unlink($dir);
            }
        }
    }

    if (!function_exists('elfsight_rcopy')) {
        function elfsight_rcopy($src, $dst) {
            if (file_exists("$dst/storage")) {
                elfsight_rrmdir("$dst/storage");
            }

            if (is_dir($src)) {
                if (file_exists($dst)) {
                    elfsight_rcopy("$src/index.php", "$dst/index.php");
                    elfsight_rcopy("$src/config.json", "$dst/config.json");
                } else {
                    mkdir($dst);

                    $files = scandir($src);
                    foreach ($files as $file) {
                        if ($file != "." && $file != "..") {
                            elfsight_rcopy("$src/$file", "$dst/$file");
                        }
                    }
                }
            } else if (file_exists($src)) {
                if (file_exists($dst)) {
                    unlink($dst);
                }
                copy($src, $dst);
            }
        }
    }

    elfsight_rcopy($default_api_path, $custom_api_path);
}


function elfsight_instagram_feed_activation() {
    if (get_option('elfsight-instagram-feed-cc_custom_api_url') || !elfsight_instagram_feed_api_test()) {
        elfsight_instagram_feed_api_custom_update();
    }
}
register_activation_hook(__FILE__, 'elfsight_instagram_feed_activation');


function elfsight_instagram_feed_shortcode_options_filter($options) {
    $api_url = get_option('elfsight-instagram-feed-cc_custom_api_url', plugin_dir_url(__FILE__) . 'api/index.php');

    if (is_ssl()) {
        $api_url = str_replace('http://', 'https://', $api_url);
    }

    if (is_array($options)) {
        $options['api'] = $api_url;
    }

    return $options;
}
add_filter('elfsight_instagram_feed_shortcode_options', 'elfsight_instagram_feed_shortcode_options_filter');


function elfsight_instagram_feed_widget_options_filter($options_json) {
    $options = json_decode($options_json, true);

    if (is_array($options)) {
        unset($options['api']);
    }

    return json_encode($options);
}
add_filter('elfsight_instagram_feed_widget_options', 'elfsight_instagram_feed_widget_options_filter');


$elfsightInstagramFeed = new ElfsightInstagramFeedPlugin(array(
        'name' => 'Instagram Feed',
        'description' => 'Add Instagram images to your website to engage your visitors',
        'slug' => 'elfsight-instagram-feed',
        'version' => '3.6.1',
        'text_domain' => 'elfsight-instagram-feed',
        'editor_settings' => $elfsight_instagram_feed_config['settings'],
        'editor_preferences' => $elfsight_instagram_feed_config['preferences'],
        'script_url' => plugins_url('assets/elfsight-instagram-feed.js', __FILE__),

        'plugin_name' => 'Elfsight Instagram Feed',
        'plugin_file' => __FILE__,
        'plugin_slug' => plugin_basename(__FILE__),

        'vc_icon' => plugins_url('assets/img/vc-icon.png', __FILE__),

        'menu_icon' => plugins_url('assets/img/menu-icon.png', __FILE__),
        'update_url' => 'https://a.elfsight.com/updates/v1/',

        'preview_url' => plugins_url('preview/index.html', __FILE__),
        'observer_url' => plugins_url('preview/instagram-feed-observer.js', __FILE__),

        'product_url' => 'https://codecanyon.net/item/elfsight-instagram-feed-wordpress-plugin/20574814?ref=Elfsight',
        'support_url' => 'https://elfsight.ticksy.com/submit/#100010647',
    )
);

add_shortcode('instashow', array($elfsightInstagramFeed, 'addShortcode'));

?>