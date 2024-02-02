<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Customer extends REST_Controller
{

    protected $MenuId = 'Customer';

    public function __construct()
    {

        parent::__construct();

        // Load Customer_Model
        $this->load->model('Customer_Model');
        $this->load->model('Auth_Model');

    }

    /**
     * Show Customer All API
     * ---------------------------------
     * @method : GET
     * @link : customer/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // Customer Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load Customer Function
            $output = $this->Customer_Model->select_customer();

            if (isset($output) && $output) {

                // Show Customer All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Customer all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show Customer All Error
                $message = [
                    'status' => false,
                    'message' => 'Customer data was not found in the database',
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
     * Create Customer API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : customer/create
     */
    public function create_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        $this->form_validation->set_rules('ID_Card_Number', 'ID_Card_Number', 'trim|required');

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

            // Customer Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $customer_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $customer_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $customer_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                if ($customer_permission[array_keys($customer_permission)[0]]['Created']) {

                    $id_card = $this->input->post('ID_Card_Number');    

                    $pass = substr($id_card,-4);

                    $customer_check['data'] = [
                        'ID_Card_Number' => $this->input->post('ID_Card_Number')
                    ];

                    // Check Customer Function
                    $check_output = $this->Customer_Model->check_customer($customer_check);

                    if (isset($check_output) && $check_output) {
                        
                        // ซ้ำ Customer Error
                        $message = [
                            'status' => false,
                            'data' => $check_output,
                            'message' => 'เลขบัตรประชาชนมีการลงทะเบียนแล้ว : [Insert Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    
                    } else {

                        // ไม่ซ้ำ Customer Success
                        $customer_data['data'] = [
                            'Customer_No' => $this->input->post('ID_Card_Number'),
                            'ID_Card_Number' => $this->input->post('ID_Card_Number'),
                            'PreFix' => $this->input->post('prefix'),
                            'UserName' => $this->input->post('Phone_Number'),
                            'InitialPassword' => md5($pass),
                            'CurrentPassword' => md5($pass),
                            'Name' => $this->input->post('Name_Customer'),
                            'Surname' => $this->input->post('Surname_Customer'),
                            'Phone_Number' => $this->input->post('Phone_Number'),
                            'Address' => $this->input->post('Address'),
                            'Subdistrict' => $this->input->post('Subdistrict_Name'),
                            'District' => $this->input->post('District_Name'),
                            'Province' => $this->input->post('Province_Name'),
                            'Postal_Code' => $this->input->post('Postal_Code'),
                            'Link' => $this->input->post('Link_Google_Map'),
                            'Remark' => null,
                            'IsUse' => 1,
                            'Add_By' => $customer_token['UserName'],
                            'Add_Date' => date('Y-m-d H:i:s'),
    
                        ];

                        // Create Customer Function
                        $customer_output = $this->Customer_Model->insert_customer($customer_data);

                        if (isset($customer_output) && $customer_output) {

                            // Create Customer Success
                            $message = [
                                'status' => true,
                                'message' => 'Create Customer Successful',
                            ];

                            $this->response($message, REST_Controller::HTTP_OK);

                        } else {

                            // Create Customer Error
                            $message = [
                                'status' => false,
                                'message' => 'Create Customer Fail : [Insert Data Fail]',
                            ];

                            $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                        }
                         
                        

                    }



                    

                } else {
                    // Permission Error
                    $message = [
                        'status' => false,
                        'message' => 'You don’t currently have permission to Create',
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

    /**
     * Update Customer API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : customer/update
     */
    public function update_post()
    { 

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);
        $this->form_validation->set_rules('ID_Card_Number', 'ID_Card_Number', 'trim|required');
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

            // Customer Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $customer_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $customer_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $customer_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                if ($customer_permission[array_keys($customer_permission)[0]]['Updated']) {

                    $customer_data['index'] = $this->input->post('Customer_Index');
                    $id_card = $this->input->post('ID_Card_Number');    

                    $pass = substr($id_card,-4);    
                    
                    $customer_data['data'] = [
                        'Customer_No' => $this->input->post('ID_Card_Number'),
                        'ID_Card_Number' => $this->input->post('ID_Card_Number'),
                        'PreFix' => $this->input->post('prefix'),
                        'UserName' => $this->input->post('Phone_Number'),
                        'InitialPassword' => md5($pass),
                        'CurrentPassword' => md5($pass),
                        'Name' => $this->input->post('Name_Customer'),
                        'Surname' => $this->input->post('Surname_Customer'),
                        'Phone_Number' => $this->input->post('Phone_Number'),
                        'Address' => $this->input->post('Address'),
                        'Subdistrict' => $this->input->post('Subdistrict_Name'),
                        'District' => $this->input->post('District_Name'),
                        'Province' => $this->input->post('Province_Name'),
                        'Postal_Code' => $this->input->post('Postal_Code'),
                        'Link' => $this->input->post('Link_Google_Map'),
                        'Remark' => null,
                        'IsUse' => 1,
                        'Update_By' => $customer_token['UserName'],
                        'Update_Date' => date('Y-m-d H:i:s'),

                    ];

                    

                    // Update Customer Function
                    $customer_output = $this->Customer_Model->update_customer($customer_data);

                    if (isset($customer_output) && $customer_output) {

                        // Update Customer Success
                        $message = [
                            'status' => true,
                            'message' => 'Update Customer Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Update Customer Error
                        $message = [
                            'status' => false,
                            'message' => 'Update Customer Fail : [Update Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    }

                } else {
                    // Permission Error
                    $message = [
                        'status' => false,
                        'message' => 'You don’t currently have permission to Update',
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

    /**
     * Delete Customer API
     * ---------------------------------
     * @param: Customer_Index
     * ---------------------------------
     * @method : POST
     * @link : customer/delete
     */
    public function delete_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        $this->form_validation->set_rules('Customer_Index', 'Customer_Index', 'trim|required');

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

            // Customer Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $customer_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $customer_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $customer_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                if ($customer_permission[array_keys($customer_permission)[0]]['Deleted']) {

                    $customer_data['index'] = $this->input->post('Customer_Index');
                    
                    $customer_data['data'] = [
                        'Remark' => 'ยกเลิกประวัติลูกค้านี้',
                        'IsUse' => 0,
                        'Cancel_By' => $customer_token['UserName'],
                        'Cancel_Date' => date('Y-m-d H:i:s'),

                    ];

                    // Delete Customer Function
                    $customer_output = $this->Customer_Model->delete_customer($customer_data);

                    if (isset($customer_output) && $customer_output) {

                        // Delete Customer Success
                        $message = [
                            'status' => true,
                            'message' => 'Delete Customer Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Delete Customer Error
                        $message = [
                            'status' => false,
                            'message' => 'Delete Customer Fail : [Delete Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    }

                } else {
                    // Permission Error
                    $message = [
                        'status' => false,
                        'message' => 'You don’t currently have permission to Delete',
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

}
