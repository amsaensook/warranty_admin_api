<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class ProductListWarrantyDes extends REST_Controller
{

    protected $MenuId = 'ProductListWarrantyDes';

    public function __construct()
    {

        parent::__construct();

        // Load ProductListWarrantyDes
        $this->load->model('ProductListWarrantyDes_Model');

    }

    /**
     * Show ProductListWarrantyDes All API
     * ---------------------------------
     * @method : GET
     * @link : ProductListWarrantyDes/index
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
            $id_data = $this->input->get('warrantyid');

            $output = $this->ProductListWarrantyDes_Model->select_productlistwarrantydes($id_data);

            if (isset($output) && $output) {

                // Show JobNo All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Product List Warranty Des all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show JobNo All Error
                $message = [
                    'status' => false,
                    'message' => 'Product List Warranty Des data was not found in the database',
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
            'message' => 'Show ProductListWarrantyDes all successful',
        ];

        $this->response($message, REST_Controller::HTTP_OK);

    }
}