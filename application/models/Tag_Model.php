<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tag_Model extends MY_Model
{

    
    /**
     * Tag
     * ---------------------------------
     * @param : null
     */
    public function select_tag($param = [])
    {

        $this->set_db('default');

        $sql = "
            select * from View_TagQR where Job_ID = ? order by QR_NO ASC
        ";

        $query = $this->db->query($sql,$param['Rec_ID']);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }



}
