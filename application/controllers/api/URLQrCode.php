<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class URLQrCode extends REST_Controller
{

    protected $URLQrCodeId = 'URLQrCode';

    public function __construct()
    {

        parent::__construct();

        // Load URLQrCode
        $this->load->model('URLQrCode_Model');

    }

    /**
     * Show URLQrCode All API
     * ---------------------------------
     * @method : GET
     * @link : URLQrCode/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // URLQrCode Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load URLQrCode Function
            $output = $this->URLQrCode_Model->select_url_qrcode();

            if (isset($output) && $output) {

                // Show URLQrCode All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show URLQrCode all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show URLQrCode All Error
                $message = [
                    'status' => false,
                    'message' => 'URLQrCode data was not found in the database',
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
