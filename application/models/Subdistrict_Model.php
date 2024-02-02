<?php defined('BASEPATH') or exit('No direct script access allowed');

class Subdistrict_Model extends MY_Model
{

    /**
     * Subdistrict
     * ---------------------------------
     * @param : null
     */
    public function select_subdistrict($param)
    {

        $this->set_db('default');

        $sql = "
        select * from ms_Subdistricts where district_id = '$param'
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}
