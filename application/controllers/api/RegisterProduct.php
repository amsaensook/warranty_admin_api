<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class RegisterProduct extends REST_Controller
{

    protected $MenuId = 'RegisterProduct';

    public function __construct()
    {

        parent::__construct();

        // Load RegisterProduct_Model
        $this->load->model('RegisterProduct_Model');
        $this->load->model('Auth_Model');

    }


    /**
     * Show RegisterProduct All API
     * ---------------------------------
     * @method : GET
     * @link : registerproduct/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // RegisterProduct Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load RegisterProduct Function
            $output = $this->RegisterProduct_Model->select_registerproduct();

            if (isset($output) && $output) {

                // Show RegisterProduct All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Register Product all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show RegisterProduct All Error
                $message = [
                    'status' => false,
                    'message' => 'Register Product data was not found in the database',
                ];

                //$this->response($message, REST_Controller::HTTP_NOT_FOUND);

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

    /**
     * Create RegisterProduct API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : registerproduct/create
     */
    public function create_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);
        

        $reg = json_decode($this->input->post('data'), true); 

        $period_output = json_decode(json_encode($this->RegisterProduct_Model->select_warranty_period()), true);
        $Month_Period = $period_output[array_keys($period_output)[0]]['Month'];


        $newDate = date('Y-m-d', strtotime($reg['Date_of_Purchase']. ' + '.$Month_Period.' months'));

            $registerproduct_data['data'] = [
                'Customer_ID' => $reg['Customer_ID'],
                'Serial_No' => $reg['Serial_No'],
                'Product_Code' => $reg['Product_Code'],
                'Register_Date' => $reg['Register_Date'],
                'Receipt_Address' => $reg['Receipt_Address'],
                'Dealer_Name' => $reg['Dealer_Name'],
                'Dealer_Sales' => $reg['Dealer_Sales'],
                'Date_of_Purchase' => $reg['Date_of_Purchase'],
                'Date_Warranty_Expires' => $newDate,
                'Status' => 1,
                'Add_By' => $reg['Customer_ID'],
                'Add_Date' => date('Y-m-d H:i:s'),

            ];

            // Create RegisterProduct Function
            $registerproduct_output = $this->RegisterProduct_Model->insert_registerproduct($registerproduct_data);

            if (isset($registerproduct_output) && $registerproduct_output) {

                // Create registerproduct Success
                $message = [
                    'status' => true,
                    'message' => 'Create Register Product Successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Create RegisterProduct Error
                $message = [
                    'status' => false,
                    'message' => 'Create Register Product Fail : [Insert Data Fail]',
                ];

                $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

            }
                    


        }


    /**
     * Update RegisterProduct API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : registerproduct/update
     */
    public function update_post()
    { 

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // RegisterProduct Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $registerproduct_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $registerproduct_token['UserName'],
                  ];
                

                  $reg = json_decode($this->input->post('data'), true); 

                  $period_output = json_decode(json_encode($this->RegisterProduct_Model->select_warranty_period()), true);
                  $Month_Period = $period_output[array_keys($period_output)[0]]['Month'];
          
          
                  $newDate = date('Y-m-d', strtotime($reg['Date_of_Purchase']. ' + '.$Month_Period.' months'));
                      
                  $registerproduct_data['index'] = $reg['Warranty_Index']; 

                      $registerproduct_data['data'] = [
                          'Serial_No' => $reg['Serial_No'],
                          'Product_Code' => $reg['Product_Code'],
                          'Register_Date' => $reg['Register_Date'],
                          'Receipt_Address' => $reg['Receipt_Address'],
                          'Dealer_Name' => $reg['Dealer_Name'],
                          'Dealer_Sales' => $reg['Dealer_Sales'],
                          'Date_of_Purchase' => $reg['Date_of_Purchase'],
                          'Date_Warranty_Expires' => $newDate,
                          'Status' => 1,
                          'Update_By' => $registerproduct_token['UserName'],
                          'Update_Date' => date('Y-m-d H:i:s'),
          
                      ];
                 

                    // Update RegisterProduct Function
                    $registerproduct_output = $this->RegisterProduct_Model->update_registerproduct($registerproduct_data);

                    if (isset($registerproduct_output) && $registerproduct_output) {

                        // Update registerproduct Success
                        $message = [
                            'status' => true,
                            'message' => 'Update Product Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Update RegisterProduct Error
                        $message = [
                            'status' => false,
                            'message' => 'Update Product Fail : [Update Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

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

    /**
     * Delete RegisterProduct API
     * ---------------------------------
     * @param: RegisterProduct_Index
     * ---------------------------------
     * @method : POST
     * @link : registerproduct/delete
     */
    public function delete_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // RegisterProduct Token Validation
            $is_valid_token = $this->authorization_token->validateToken();


                $registerproduct_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $registerproduct_token['UserName'],
                  ];
               

                    $registerproduct_data['index'] = $this->input->post('Warranty_Index');
                    
                    $registerproduct_data['data'] = [
                        'Status' => -1,
                        'Cancel_By' => $registerproduct_token['UserName'],
                        'Cancel_Date' => date('Y-m-d H:i:s'),

                    ];

                    // Delete RegisterProduct Function
                    $registerproduct_output = $this->RegisterProduct_Model->delete_registerproduct($registerproduct_data);

                    if (isset($registerproduct_output) && $registerproduct_output) {

                        // Delete registerproduct Success
                        $message = [
                            'status' => true,
                            'message' => 'Delete Product Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Delete RegisterProduct Error
                        $message = [
                            'status' => false,
                            'message' => 'Delete Product Fail : [Delete Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    }

           

           

        

    }

}
