<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://inwaits.com
 * @since             8.0.0
 * @package           Student_Id_Card_QR_Attendance
 *
 * @wordpress-plugin
 * Plugin Name:       Student Identity Card with QR & Attendance
 * Plugin URI:        https://example.com/student-id-card-qr-attendance
 * Description:       A WordPress plugin that generates student ID cards with QR codes, tracks attendance, and displays WooCommerce order information.
 * Version:           8.0.0
 * Author:            inwaits
 * Author URI:        https://inwaits.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       student-id-card-qr-attendance
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * WC requires at least: 8.0.0
 * WC tested up to:   8.0.0
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 */
define('STUDENT_ID_CARD_QR_ATTENDANCE_VERSION', '8.0.0');
define('STUDENT_ID_CARD_QR_ATTENDANCE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('STUDENT_ID_CARD_QR_ATTENDANCE_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Check if WooCommerce is active
 */
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_notices', function() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('Student Identity Card with QR & Attendance requires WooCommerce to be installed and active.', 'student-id-card-qr-attendance'); ?></p>
        </div>
        <?php
    });
    return;
}

/**
 * Declare compatibility with WooCommerce features
 */
add_action('before_woocommerce_init', function() {
    if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
        // Declare compatibility with High-Performance Order Storage
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            'custom_order_tables',
            __FILE__,
            true
        );
    }
});

/**
 * The code that runs during plugin activation.
 */
function activate_student_id_card_qr_attendance() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-student-id-card-qr-attendance-activator.php';
    Student_Id_Card_QR_Attendance_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_student_id_card_qr_attendance() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-student-id-card-qr-attendance-deactivator.php';
    Student_Id_Card_QR_Attendance_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_student_id_card_qr_attendance');
register_deactivation_hook(__FILE__, 'deactivate_student_id_card_qr_attendance');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-student-id-card-qr-attendance.php';

/**
 * Begins execution of the plugin.
 *
 * @since    8.0.0
 */
function run_student_id_card_qr_attendance() {
    $plugin = new Student_Id_Card_QR_Attendance();
    $plugin->run();
}
run_student_id_card_qr_attendance();
