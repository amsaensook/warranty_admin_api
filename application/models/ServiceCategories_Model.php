<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceCategories_Model extends MY_Model
{

    /**
     * Menu Type
     * ---------------------------------
     * @param : null
     */
    public function select_servicecategories()
    {

        $this->set_db('default');

        $sql = " select * from ms_Service_Categories  where Status = '1'
        ";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}
