<?php
class FFBSTrainingImporter
{
    protected $pluginPath;

    public function __construct()
    {
        $this->plugin_path = dirname(__FILE__);
        // add_action('wp_enqueue_scripts', array($this, 'add_styles'));

        // Backend Styles & Scripts
        add_action('admin_print_styles', array($this, 'add_admin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'add_admin_scripts'));
        add_action('admin_menu', array($this, 'create_admin_menu'));

        add_action('rest_api_init', array($this, 'ffbs_register_rest_routes'));
    }

    public function add_styles()
    {
        // Custom CSS styling
        wp_register_style('einsatzverwaltung-style', plugins_url('/css/styles.css', __FILE__));
        wp_enqueue_style('einsatzverwaltung-style');

        // Bootstrap CSS styling
        wp_register_style('bootstrap-style', plugins_url('/css/bootstrap.css', __FILE__));
        wp_enqueue_style('bootstrap-style');
    }

    public function add_admin_styles()
    {
        // Custom CSS styling
        wp_register_style('admin_styles', plugins_url('css/admin.css', __FILE__));
        wp_enqueue_style('admin_styles');

        // Custom Bootstrap styling
        wp_register_style('bootstrap-style', plugins_url('/css/bootstrap.min.css', __FILE__));
        wp_enqueue_style('bootstrap-style');

        // FontAwesome Styles
        // wp_register_style('admin_fa', plugins_url('css/all.css', __FILE__));
        // wp_enqueue_style('admin_fa');
    }

    public function add_admin_scripts()
    {
        // Load JS Script for backend functions
        wp_enqueue_script('admin_scripts', plugins_url('js/ffbs-importer.js', __FILE__), array('jquery', 'wp-api'));
        wp_localize_script(
            'admin_scripts',
            'wpApiSettings',
            array(
                'root' => esc_url_raw(rest_url()),
                'nonce' => wp_create_nonce('wp_rest')
            )
        );
    }

    public function ffbs_register_rest_routes()
    {
        $rest_api = new FFBSTrainingImporterREST();
        $rest_api->ffbs_register_routes();
    }

    public function create_admin_menu()
    {

        add_menu_page('FFBS Training Importer', 'FFBS Training Importer', 'read', 'ffbs-training-importer', array($this, 'import_exercise_plan'), 'dashicons-clock');

        // if (current_user_can('edit_pages')) {
        //     add_submenu_page('einsatzverwaltung-admin', 'Vehicles', 'Fahrzeuge', 'edit_pages', 'einsatzverwaltung-admin-vehicles', array($this, 'handle_vehicles'));
        // }

        // if (current_user_can('manage_options')) {
        //     //wp_die('You do not have sufficient permissions to access this page.');
        //     add_submenu_page('einsatzverwaltung-admin', 'Mission Importer', 'Einsatz Import', 'manage_options', 'einsatzverwaltung-admin-import-missions', array($this, 'import_missions'));
        // }

        // if (current_user_can('manage_options')) {
        //     //wp_die('You do not have sufficient permissions to access this page.');
        //     add_submenu_page('einsatzverwaltung-admin', 'Settings', 'Einstellungen', 'manage_options', 'einsatzverwaltung-admin-handle-options', array($this, 'handle_options'));
        // }
    }

    public function import_exercise_plan()
    {
        //https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
?>
        <div class="wrap">
            <h2>Exercise Plan Uploader</h2>
            <div id="drop-area">
                <form class="my-form" enctype="multipart/form-data">
                    <p>Upload a file with the file dialog or by dragging and dropping onto the dashed region</p>
                    <input type="file" id="fileElem" accept=".csv,.txt"">
                    <label class=" button" for="fileElem">Select some file</label>
                </form>
                <progress id="progress-bar" max=100 value=0></progress>
            </div>

        </div>
<?php
    }
}
