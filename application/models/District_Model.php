<?php defined('BASEPATH') or exit('No direct script access allowed');

class District_Model extends MY_Model
{

    /**
     * District
     * ---------------------------------
     * @param : null
     */
    public function select_district($param)
    {

        $this->set_db('default');

        $sql = "
        select * from ms_Districts where province_id = '$param'
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}
