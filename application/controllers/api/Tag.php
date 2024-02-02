<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Tag extends REST_Controller
{

    protected $MenuId = 'JobPacking';

    public function __construct()
    {

        parent::__construct();

        // Load Tag_Model
        $this->load->model('Tag_Model');
        $this->load->model('Auth_Model');
    }

    /**
     * Show Tag All API
     * ---------------------------------
     * @method : GET
     * @link : tag/index
     */
    public function index_get()
    {

        

    }


    /**
     * Show Tag All API
     * ---------------------------------
     * @method : POST
     * @link : tag/select
     */
    public function select_post()
    {
        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // Tag Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        //if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load Tag Function
            

            $tag_data = [
                'Rec_ID' => $this->input->post('Rec_ID'),
               
            ];

            $tag_output = $this->Tag_Model->select_tag($tag_data);

            if (isset($tag_output) && $tag_output) {

                // Show Tag All Success
                $message = [
                    'status' => true,
                    'data' => $tag_output,
                    'message' => 'Show tag all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            }

        // } else {
        //     // Validate Error
        //     $message = [
        //         'status' => false,
        //         'message' => $is_valid_token['message'],
        //     ];

        //     $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
        // }
    }

   

    

}
