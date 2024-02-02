<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class CustomerNo extends REST_Controller
{

    protected $MenuId = 'CustomerNo';

    public function __construct()
    {

        parent::__construct();

        // Load CustomerNo
        $this->load->model('CustomerNo_Model');

    }

    /**
     * Show CustomerNo All API
     * ---------------------------------
     * @method : GET
     * @link : CustomerNo/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // CustomerNo Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load CustomerNo Function

            $output = $this->CustomerNo_Model->select_customer_no();

            if (isset($output) && $output) {

                // Show CustomerNo All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show CustomerNo all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show CustomerNo All Error
                $message = [
                    'status' => false,
                    'message' => 'CustomerNo data was not found in the database',
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

    public function show($a)
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        $message = [
            'status' => true,
            'data' => $a,
            'message' => 'Show CustomerNo all successful',
        ];

        $this->response($message, REST_Controller::HTTP_OK);

    }
}