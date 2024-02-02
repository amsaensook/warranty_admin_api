<?php defined('BASEPATH') or exit('No direct script access allowed');

class CustomerNo_Model extends MY_Model
{

    /**
     * job no
     * ---------------------------------
     * @param : null
     */
    public function select_customer_no()
    {

        $this->set_db('default');

        $sql = "
        select dbo.[fnGetCustomerNo] () as CustomerNo
        ";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}


