<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class SubdistrictM extends REST_Controller
{

    protected $MenuId = 'SubdistrictM';

    public function __construct()
    {

        parent::__construct();

        // Load Subdistrict
        $this->load->model('Subdistrict_Model');

    }

    /**
     * Show Subdistrict All API
     * ---------------------------------
     * @method : GET
     * @link : Subdistrict/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

       
            // Load Subdistrict Function
            $id_data = $this->input->get('id');

            $output = $this->Subdistrict_Model->select_subdistrict($id_data);

            if (isset($output) && $output) {

                // Show Subdistrict All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Subdistrict all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show Subdistrict All Error
                $message = [
                    'status' => false,
                    'message' => 'Subdistrict data was not found in the database',
                ];

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

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
            'message' => 'Show Subdistrict all successful',
        ];

        $this->response($message, REST_Controller::HTTP_OK);

    }
}