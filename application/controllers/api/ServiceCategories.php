<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class ServiceCategories extends REST_Controller
{


    public function __construct()
    {

        parent::__construct();

        // Load ServiceCategories
        $this->load->model('ServiceCategories_Model');

    }

    /**
     * Show ServiceCategories All API
     * ---------------------------------
     * @method : GET
     * @link : ServiceCategories/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // ServiceCategories Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load ServiceCategories Function
            $output = $this->ServiceCategories_Model->select_servicecategories();

            if (isset($output) && $output) {

                // Show ServiceCategories All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show ServiceCategories all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show ServiceCategories All Error
                $message = [
                    'status' => false,
                    'message' => 'ServiceCategories data was not found in the database',
                ];

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        } else {
            // Validate Error
            $message = [
                'status' => false,
                'message' => $is_valid_token['message'],
            ];

            $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
        }

    }

}
