<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class ProductListWarranty extends REST_Controller
{

    protected $MenuId = 'ProductListWarranty';

    public function __construct()
    {

        parent::__construct();

        // Load ProductListWarranty
        $this->load->model('ProductListWarranty_Model');

    }

    /**
     * Show ProductListWarranty All API
     * ---------------------------------
     * @method : GET
     * @link : ProductListWarranty/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // JobNo Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load JobNo Function
            $id_data = $this->input->get('id');

            $output = $this->ProductListWarranty_Model->select_productlistwarranty($id_data);

            if (isset($output) && $output) {

                // Show JobNo All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Product Lis tWarranty all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show JobNo All Error
                // $message = [
                //     'status' => false,
                //      'message' => 'Product List Warranty data was not found in the database',
                // ];

                // $this->response($message, REST_Controller::HTTP_NOT_FOUND);

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
            'message' => 'Show ProductListWarranty all successful',
        ];

        $this->response($message, REST_Controller::HTTP_OK);

    }
}