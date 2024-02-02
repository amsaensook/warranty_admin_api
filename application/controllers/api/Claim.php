<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Claim extends REST_Controller
{

    protected $MenuId = 'Claim';

    public function __construct()
    {

        parent::__construct();

        // Load Claim_Model
        $this->load->model('Claim_Model');
        $this->load->model('Auth_Model');

    }


    /**
     * Show Claim All API
     * ---------------------------------
     * @method : GET
     * @link : claim/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // Claim Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            
            $id_data = $this->input->get('warrantyid');
            // Load Claim Function
            $output = $this->Claim_Model->select_claim($id_data);

            if (isset($output) && $output) {

                // Show Claim All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Claim all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show Claim All Error
                $message = [
                    'status' => false,
                    'message' => 'Claim data was not found in the database',
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
     * Create Claim API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : claim/create
     */
    public function create_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        $this->load->library('Authorization_Token');

        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
        
        $claim_token = json_decode(json_encode($this->authorization_token->userData()), true);
        $check_permission = [
            'username' => $claim_token['UserName'],
            ];

        $claim = json_decode($this->input->post('data'), true); 

        $seq_output = json_decode(json_encode($this->Claim_Model->check_seqclaim($claim['Warranty_Index'])), true);
        $Seq = $seq_output[array_keys($seq_output)[0]]['Seq'];        

            $claim_data['data'] = [
                'Warranty_Index' => $claim['Warranty_Index'],
                'Warranty_Seq' => $Seq,
                'Customer_Name' => $claim['Name_Claim'],
                'Phone_Number' => $claim['Phone_Number_Claim'],
                'Service_Categories' => $claim['Service_Categories'],
                'Product_Code' => $claim['Product_Code'],
                'Defective_Product_Qty' => $claim['Defective_Product_Qty'],
                'Date_Work_Site' => $claim['Date_Work_Site'],
                'Date_Arrive_Work_Site' => $claim['Date_Arrive_Work_Site'],
                'Claimant_Name' => $claim['Claimant_Name'],
                'Claimant_Agency' => $claim['Claimant_Agency'],
                'Status' => 1,
                'Add_By' => $claim_token['UserName'],
                'Add_Date' => date('Y-m-d H:i:s'),

            ];

            // Create Claim Function
            $claim_output = $this->Claim_Model->insert_claim($claim_data);

            if (isset($claim_output) && $claim_output) {

                // Create claim Success
                $message = [
                    'status' => true,
                    'message' => 'Create Claim Successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Create Claim Error
                $message = [
                    'status' => false,
                    'message' => 'Create Claim Fail : [Insert Data Fail]',
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
     * Update Claim API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : claim/update
     */
    public function update_post()
    { 

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Claim Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $claim_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $claim_token['UserName'],
                  ];

                  $claim = json_decode($this->input->post('data'), true); 
                    
                    $claim_data['index'] = $claim['Claim_Index'];

                    $claim_data['data'] = [
                        'Warranty_Index' => $claim['Warranty_Index'],
                        'Customer_Name' => $claim['Name_Claim'],
                        'Phone_Number' => $claim['Phone_Number_Claim'],
                        'Service_Categories' => $claim['Service_Categories'],
                        'Product_Code' => $claim['Product_Code'],
                        'Defective_Product_Qty' => $claim['Defective_Product_Qty'],
                        'Date_Work_Site' => $claim['Date_Work_Site'],
                        'Date_Arrive_Work_Site' => $claim['Date_Arrive_Work_Site'],
                        'Claimant_Name' => $claim['Claimant_Name'],
                        'Claimant_Agency' => $claim['Claimant_Agency'],
                        'Status' => 1,
                        'Update_By' => $claim_token['UserName'],
                        'Update_Date' => date('Y-m-d H:i:s'),
        
                    ];

                    

                    // Update Claim Function
                    $claim_output = $this->Claim_Model->update_claim($claim_data);

                    if (isset($claim_output) && $claim_output) {

                        // Update Claim Success
                        $message = [
                            'status' => true,
                            'message' => 'Update Claim Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Update Claim Error
                        $message = [
                            'status' => false,
                            'message' => 'Update Claim Fail : [Update Data Fail]',
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
     * Delete Claim API
     * ---------------------------------
     * @param: Claim_Index
     * ---------------------------------
     * @method : POST
     * @link : claim/delete
     */
    public function delete_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        $this->form_validation->set_rules('Claim_Index', 'Claim_Index', 'trim|required');

        if ($this->form_validation->run() == false) {
            // Form Validation Error
            $message = [
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors(),
            ];

            $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {

            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Claim Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

                $claim_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $claim_token['UserName'],
                  ];
                   

                    $claim_data['index'] = $this->input->post('Claim_Index');
                    

                    // Delete Claim Function
                    $claim_output = $this->Claim_Model->delete_claim($claim_data);

                    if (isset($claim_output) && $claim_output) {

                        // Delete Claim Success
                        $message = [
                            'status' => true,
                            'message' => 'Delete Claim Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Delete Claim Error
                        $message = [
                            'status' => false,
                            'message' => 'Delete Claim Fail : [Delete Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    }



        }

    }

}
