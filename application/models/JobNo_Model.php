<?php defined('BASEPATH') or exit('No direct script access allowed');

class JobNo_Model extends MY_Model
{

    /**
     * job no
     * ---------------------------------
     * @param : null
     */
    public function select_job_no($param)
    {

        $this->set_db('default');

        $sql = "
        select dbo.[fnGetJobDocNo] ('$param') as JobNo
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}
