<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Project extends REST_Controller
{

    protected $MenuId = 'Customer';

    public function __construct()
    {

        parent::__construct();

        // Load Project
        $this->load->model('Project_Model');
        $this->load->model('Auth_Model');

    }

    /**
     * Show Project All API
     * ---------------------------------
     * @method : GET
     * @link : project/index
     */
    public function index_get()
    {

        header("Access-Control-Allow-Origin: *");

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        // Project Token Validation
        $is_valid_token = $this->authorization_token->validateToken();

        if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {
            // Load Project Function
            $output = $this->Project_Model->select_project();

            if (isset($output) && $output) {

                // Show Project All Success
                $message = [
                    'status' => true,
                    'data' => $output,
                    'message' => 'Show Project all successful',
                ];

                $this->response($message, REST_Controller::HTTP_OK);

            } else {

                // Show Project All Error
                $message = [
                    'status' => false,
                    'message' => 'Project data was not found in the database',
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
     * Create Project API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : project/create
     */
    public function create_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Project Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $Project_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $Project_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $Project_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                $project = json_decode($this->input->post('data'), true); 

                if ($Project_permission[array_keys($Project_permission)[0]]['Created']) {

                        $project_data['data'] = [
                            'Customer_ID' => $project['Customer_ID'],
                            'Customer_Name' => $project['Customer_Name'],
                            'Project_Name' => $project['Name_Project'],
                            'Phone_Number' => $project['Phone_Number'],
                            'Warranty_Type' => $project['Warranty_Type'],
                            'Warranty_Type_Other' => $project['Warranty_Type_Other'] || null,
                            'Warranty_Period' => $project['Warranty_Period'],
                            'Start_Date' => $project['Start_Date'],
                            'End_Date' => $project['End_Date'],
                            'Status' => 1,
                            'Add_By' => $Project_token['UserName'],
                            'Add_Date' => date('Y-m-d H:i:s'),
    
                        ];

                        $upload_output = isset($_FILES['Picture']) ? $this->do_upload($_FILES['Picture'],$this->input->post('Id')) : array("status" => true, "data" => null);

                        if ($upload_output['status']) {
                            // Create Project Function
                            $project_output = $this->Project_Model->insert_project($project_data);

                            if (isset($project_output) && $project_output) {

                                // Create Project Success
                                $message = [
                                    'status' => true,
                                    'message' => 'Create Project Successful',
                                ];

                                $this->response($message, REST_Controller::HTTP_OK);

                            } else {

                                // Create Project Error
                                $message = [
                                    'status' => false,
                                    'message' => 'Create Project Fail : [Insert Data Fail]',
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

    /**
     * Update Project API
     * ---------------------------------
     * @param: FormData
     * ---------------------------------
     * @method : POST
     * @link : project/update
     */
    public function update_post()
    { 

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);
       
            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Project Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $project_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $project_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $project_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                if ($project_permission[array_keys($project_permission)[0]]['Updated']) {
                    
                    $project = json_decode($this->input->post('data'), true);

                    $project_data['index'] = $project['Project_ID'];
                    
                    $project_data['data'] = [
                        'Customer_ID' => $project['Customer_ID'],
                        'Customer_Name' => $project['Customer_Name'],
                        'Project_Name' => $project['Name_Project'],
                        'Phone_Number' => $project['Phone_Number'],
                        'Warranty_Type' => $project['Warranty_Type'],
                        'Warranty_Type_Other' => $project['Warranty_Type_Other'] || null,
                        'Warranty_Period' => $project['Warranty_Period'],
                        'Start_Date' => $project['Start_Date'],
                        'End_Date' => $project['End_Date'],
                        'Status' => 1,
                        'Update_By' => $Project_token['UserName'],
                        'Update_Date' => date('Y-m-d H:i:s'),

                    ];

                    

                    // Update Project Function
                    $project_output = $this->Project_Model->update_project($project_data);

                    if (isset($project_output) && $project_output) {

                        // Update project Success
                        $message = [
                            'status' => true,
                            'message' => 'Update Project Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Update Project Error
                        $message = [
                            'status' => false,
                            'message' => 'Update Project Fail : [Update Data Fail]',
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
     * Delete Project API
     * ---------------------------------
     * @param: Project_Index
     * ---------------------------------
     * @method : POST
     * @link : project/delete
     */
    public function delete_post()
    {

        header("Access-Control-Allow-Origin: *");

        $_POST = $this->security->xss_clean($_POST);

            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            // Project Token Validation
            $is_valid_token = $this->authorization_token->validateToken();

            if (isset($is_valid_token) && boolval($is_valid_token['status']) === true) {

                $project_token = json_decode(json_encode($this->authorization_token->userData()), true);
                $check_permission = [
                    'username' => $project_token['UserName'],
                  ];
                $permission_output = $this->Auth_Model->select_permission_new($check_permission);

                $project_permission = array_filter($permission_output, function ($permission) {
                    return $permission['MenuId'] == $this->MenuId;
                });

                if ($project_permission[array_keys($project_permission)[0]]['Deleted']) {

                    $project_data['index'] = $this->input->post('Project_ID');
                    
                    $project_data['data'] = [
                        'Status' => -1,
                        'Cancel_By' => $project_token['UserName'],
                        'Cancel_Date' => date('Y-m-d H:i:s'),

                    ];

                    // Delete Project Function
                    $project_output = $this->Project_Model->delete_project($project_data);

                    if (isset($project_output) && $project_output) {

                        // Delete Project Success
                        $message = [
                            'status' => true,
                            'message' => 'Delete Project Successful',
                        ];

                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {

                        // Delete Project Error
                        $message = [
                            'status' => false,
                            'message' => 'Delete Project Fail : [Delete Data Fail]',
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
