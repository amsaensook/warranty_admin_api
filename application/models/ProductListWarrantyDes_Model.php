<?php defined('BASEPATH') or exit('No direct script access allowed');

class ProductListWarrantyDes_Model extends MY_Model
{

    /**
     * job no
     * ---------------------------------
     * @param : null
     */
    public function select_productlistwarrantydes($param)
    {

        $this->set_db('default');

        $sql = "
        select * from tb_WarrantyProduct where Warranty_Index = $param
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}


