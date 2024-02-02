<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Province extends REST_Controller
{

    protected $ProvinceId = 'Province';

    public function __construct()
    {

        parent::__construct();

        // Load Province
        $this->load->model('Province_Model');

    }

    /**f
     * Show Province All API
     * ---------------------------------
     * @method : GET
     * @link : province/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // Province Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load Province Function
            $output = $this->Province_Model->select_province();

            if (isset($output) && $output) {

                // Show Province All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Province all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show Province All Error
                $message = [
                    'status' => false,
                    'message' => 'Province data was not found in the database',
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
