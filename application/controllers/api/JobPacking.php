<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class JobPacking extends REST_Controller
{

    protected $MenuId = 'JobPacking';

    public function __construct()
    {

        parent::__construct();

        // Load JobPacking
        $this->load->model('JobPacking_Model');
        $this->load->model('Auth_Model');

    }

    /**
     * Show JobPacking All API
     * ---------------------------------
     * @method : GET
     * @link : jobpacking/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // JobPacking Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load JobPacking Function
            $output = $this->JobPacking_Model->select_jobpacking();

            if (isset($output) && $output) {

                // Show JobPacking All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Job all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show Job All Error
                // $message = [
                //     'status' => false,
                //     'message' => 'Job data was not found in the database',
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

    /**
     * Create Job API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : jobpacking/create
     */
    public function create_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        
            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Job Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $job_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $job_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $job_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });


                $job_header = json_decode($this->input->post('data1'), true); 

                if ($job_permission[array_keys($job_permission)[0]]['Created']) {



                    $job_no_output = json_decode(json_encode($this->JobPacking_Model->select_job_no()), true);
                    $job_no = $job_no_output[array_keys($job_no_output)[0]]['JobNo'];

                    if (isset($job_no) && $job_no) {

                    
                        $job_data['data'] = [
                            'Rec_type' => '1',
                            'Rec_NO' => $job_no,
                            'Rec_Datetime' => $job_header['Job_Date'],
                            'status' => '1',
                            'Remark' => (isset($job_header['Job_Remark']) && $job_header['Job_Remark']) ? $job_header['Job_Remark'] : null,
                            'Create_Date' => date('Y-m-d H:i:s'),
                            'Create_By' => $job_token['UserName'],
                            'Update_Date' => null,
                            'Update_By' => null,
                            
                        ];
    
                        // Create job Function
                        $job_output = $this->JobPacking_Model->insert_jobpacking($job_data);
    
    
    
                        if (isset($job_output) && $job_output) {
    
                            //Create Item Success
                            $job_item = json_decode($this->input->post('data2'), true); 
                            
                            foreach ($job_item as $value) {
                                
                                $job_data_item['data'] = [
                                    'Rec_ID' => $job_output,
                                    'Qty' => $value['QTY'],
                                    'Item_ID' => $value['Grade_ID'],
                                    'Lot_No' => $value['Lot_No'],
                                    'ItemStatus_ID' => '1',
                                    'Create_Date' => date('Y-m-d H:i:s'),
                                    'Create_By' => $job_token['UserName'],
                                    
                                ];
    
    
                                $job_output_item = $this->JobPacking_Model->insert_jobpacking_item($job_data_item);
    
                            }
                            
    
                            $message = [
                                'status' => true,
                                'message' => 'Create Job Part Successful',
                            ];
    
                            $this->response($message, REST_Controller::HTTP_OK);
    
    
    
                        } else {
    
                            // Create Job Error
                            $message = [
                                'status' => false,
                                'message' => 'Create Job Part Fail : [Insert Data Fail]',
                            ];
    
                            $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    
                        }
                    }else{
                            // Create Job NO Error
                            $message = [
                                'status' => false,
                                'message' => 'Job No Fail',
                            ];

                            $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
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

    /**
     * Update JobPacking API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : jobpacking/update
     */
    public function update_post()
    { 

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);


            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // JobPacking Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $job_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $job_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);
                $job_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                    $job_header = json_decode($this->input->post('data1'), true); 

                    if ($job_permission[array_keys($job_permission)[0]]['Created']) {

                        $job_data['index'] = $job_header['Job_Index'];

                        $job_data['JobNo'] = $job_header['Job_No'];

                        $job_data['data'] = [
                            'Job_Date' => $job_header['Job_Date'],
                            'JobType_ID' => 1,
                            'ITEM_ID' => $job_header['Grade_ID'],
                            'Qty' => $job_header['Qty'],
                            'Lot_No' => $job_header['Lot_No'],
                            'Section' => $job_header['Job_Section'],
                            'Request_By' => (isset($job_header['Request_By']) && $job_header['Request_By']) ? $job_header['Request_By'] : null,
                            'Receive_By' => (isset($job_header['Receiver']) && $job_header['Receiver']) ? $job_header['Receiver'] : null,
                            'Remark' => (isset($job_header['Job_Remark']) && $job_header['Job_Remark']) ? $job_header['Job_Remark'] : null,
                            'Job_Status' => 9,
                            'Update_Date' => date('Y-m-d H:i:s'),
                            'Update_By' => $job_token['UserName'],
                            
                        ];

                    

                   // Update JobPacking Function
                    $job_output = $this->JobPacking_Model->update_jobpacking($job_data);

                    if (isset($job_output) && $job_output) {


                        $delete_output = $this->JobPacking_Model->delete_qrcode_temp($job_data['JobNo']);

                        $job_item = json_decode($this->input->post('data2'), true); 
                        
                        foreach ($job_item as $value) {
                            
                            $job_data_item['data'] = [
                                'Job_ID' => $job_header['Job_Index'],
                                'QR_NO' => $value['QR_NO'],
                                'Item_ID' => $value['Grade_ID'],
                                'Lot_No' => $value['Lot_No'],
                                'Qty' => $value['QTY'],
                                'Create_Date' => date('Y-m-d H:i:s'),
                                'Create_By' => $job_token['UserName'],
                                
                            ];

                            $job_output_item = $this->JobPacking_Model->insert_jobpacking_item($job_data_item);
                        }

                        foreach ($job_item as $value) {
                            
                            $job_data_QrGen['data'] = [
                                'QR_NO' => $value['QR_NO'],
                                'Item_ID' => $value['Grade_ID'],
                                'Job_No' => $job_data['JobNo'],
                                'Create_Date' => date('Y-m-d H:i:s'),
                                'Create_By' => $job_token['UserName'],
                                
                            ];

                            $job_output_QrGen = $this->JobPacking_Model->insert_jobpacking_QrGen($job_data_QrGen);
                        }
                            // Update JobPacking Success
                        $message = [
                            'status' => true,
                            'message' => 'Update Job Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Update JobPacking Error
                        $message = [
                            'status' => false,
                            'message' => 'Update Job Fail : [Update Data Fail]',
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

    /**
     * Delete JobPacking API
     * ---------------------------------
     * @param: JobPacking_Index
     * ---------------------------------
     * @method : POST
     * @link : jobpacking/delete
     */
    public function delete_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);


            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // JobPacking Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $job_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $job_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);
                $job_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                if ($job_permission[array_keys($job_permission)[0]]['Deleted']) {

                    $job_data['Job_No'] = $this->input->post('Job_No');

                    // Delete JobPacking Function
                    $job_output_item = $this->JobPacking_Model->delete_qrcode_temp($job_data['Job_No']);
                    $job_output = $this->JobPacking_Model->delete_jobpacking($job_data);
                   

                    if (isset($job_output) && $job_output) {

                        // Delete JobPacking Success
                        $message = [
                            'status' => true,
                            'message' => $job_output,
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Delete JobPacking Error
                        $message = [
                            'status' => false,
                            'message' => 'Delete Job Fail : [Delete Data Fail]',
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

        /**
     * Show JobPacking item All API
     * ---------------------------------
     * @method : GET
     * @link : jobpacking/jobpacking_item
     */
    public function jobpackingitem_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // JobPackingID Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load JobPackingID Function
            $Rc_ID = $this->input->get('JobPacking_ID');

            $output = $this->JobPacking_Model->select_jobpackingitem($Rc_ID);

            if (isset($output) && $output) {

                // Show JobPackingID All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show JobPackingItem all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            }
        }

    }




     /**
     * createqrcode Job API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : jobpacking/createqrcode
     */
    public function createqrcode_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        
            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Job Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $job_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $job_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $job_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                

                if ($job_permission[array_keys($job_permission)[0]]['Created']) {

                    $job_no_output = json_decode(json_encode($this->JobPacking_Model->select_job_no()), true);
                    $job_no = $job_no_output[array_keys($job_no_output)[0]]['JobNo']; 

                    //$JobNo = json_decode($this->input->post('data1'), true);
                    $JobDate = json_decode($this->input->post('data2'), true);
                    $MaterialID = json_decode($this->input->post('data3'), true);
                    $Qty = json_decode($this->input->post('data4'), true); 
                    $LotNo = json_decode($this->input->post('data5'), true);
                    $Job_ID = json_decode($this->input->post('data6'), true); 

                    $job_output = $this->JobPacking_Model->insert_qrcode_temp($job_no,$JobDate,$MaterialID,$Qty,$LotNo,$job_token['UserName'],$Job_ID);

                    if (isset($job_output) && $job_output) {

                        $message = [
                            'status' => true,
                            'data' => $job_output,
                            'message' => 'Create Qr Code successful',
                        ];
                        $this->response($message, REST_Controller::HTTP_OK);
                    
                    }else {
    
                        // Create Job Error
                        $message = [
                            'status' => false,
                            'message' => 'Create Job Fail : [Insert Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

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


    /**
     * clearqrcode Job API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : jobpacking/clearqrcode
     */
    public function clearqrcode_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

        
            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Job Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $job_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $job_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $job_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                

                if ($job_permission[array_keys($job_permission)[0]]['Created']) {

                    $job_no = json_decode($this->input->post('data1'), true);

                    $job_output = $this->JobPacking_Model->delete_qrcode_temp($job_no);

                    if (isset($job_output) && $job_output) {

                        $message = [
                            'status' => true,
                            'data' => $job_output,
                            'message' => 'Clear Qr Code successful',
                        ];
                        $this->response($message, REST_Controller::HTTP_OK);
                    
                    }else {
    
                        // Create Job Error
                        $message = [
                            'status' => false,
                            'message' => 'Clear Job Fail : [Insert Data Fail]',
                        ];

                        $this->response($message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    }  
                    
                    

                } else {
                    // Permission Error
                    $message = [
                        'status' => false,
                        'message' => 'You don’t currently have permission to Clear',
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
