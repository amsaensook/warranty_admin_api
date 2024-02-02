<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class DistrictM extends REST_Controller
{

    protected $MenuId = 'DistrictM';

    public function __construct()
    {

        parent::__construct();

        // Load District
        $this->load->model('District_Model');

    }

    /**
     * Show District All API
     * ---------------------------------
     * @method : GET
     * @link : District/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

            // Load District Function
            $id_data = $this->input->get('id');

            $output = $this->District_Model->select_district($id_data);

            if (isset($output) && $output) {

                // Show District All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show District all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show District All Error
                $message = [
                    'status' => false,
                    'message' => 'District data was not found in the database',
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
            'message' => 'Show District all successful',
        ];

        $this->response($message, REST_Controller::HTTP_OK);

    }
}