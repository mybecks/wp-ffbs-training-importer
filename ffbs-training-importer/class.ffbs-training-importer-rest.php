<?php
class FFBSTrainingImporterREST extends WP_REST_Controller
{
    protected $pluginPath;
    const VERSION = '1';
    const VENDOR = 'ffbs';
    const ROUTE_TRAININGS = '/trainings';

    public function __construct()
    {
        $this->pluginPath = dirname(__FILE__);
        $this->db_handler = DatabaseHandler::get_instance();
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function ffbs_register_routes()
    {
        $namespace = self::VENDOR . '/v' . self::VERSION;

        register_rest_route($namespace, '/' . self::ROUTE_TRAININGS, array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'ffbs_insert_trainings'),
                'args' => array(
                    'content' => array()
                ),
            )
        ));
    }

    public function ffbs_insert_trainings($request)
    {
        $body = $request->get_json_params();

        $content = $body['content'];
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            if (!empty($line)) {
                $columns = explode(',', $line);
            }
        }

        // $result = $this->db_handler->add_setting($body['id'], $body['value']);

        // if ($result == 1) {
        //     return new WP_REST_Response(null, 201);
        // } else {
        //     return new WP_Error('cant-create', $body, array('status' => 400));
        // }
    }
}
