<?php defined('BASEPATH') or exit('No direct script access allowed');

class RegisterProduct_Model extends MY_Model
{

    /**
     * RegisterProduct
     * ---------------------------------
     * @param : null
     */
    public function select_customer()
    {

        $this->set_db('default');

        $sql = "
        select *
        from tb_WarrantyProduct
        ";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

    /**
     * RegisterProduct
     * ---------------------------------
     * @param : null
     */
    public function select_warranty_period()
    {

        $this->set_db('default');

        $sql = "
        select *
        from ms_Warranty_Period where Status = 1
        ";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

    /**
     * Insert RegisterProduct
     * ---------------------------------
     * @param : FormData
     */
    public function insert_registerproduct($param = [])
    {
        $this->set_db('default');

        return ($this->db->insert('tb_WarrantyProduct', $param['data'])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Update RegisterProduct
     * ---------------------------------
     * @param : FormData
     */
    public function update_registerproduct($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('tb_WarrantyProduct', $param['data'], ['Warranty_Index'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Delete RegisterProduct
     * ---------------------------------
     * @param : RegisterProduct_Index
     */
    public function delete_registerproduct($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('tb_WarrantyProduct', $param['data'], ['Warranty_Index'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

    /**
     * CheckRegisterProduct
     * ---------------------------------
     * @param : null
     */             
    public function check_customer($param = [])
    {
        $this->set_db('default');

        $sql = "

        select ID_Card_Number from se_Customer where IsUse = 1 and ID_Card_Number = ?
            
        ";

        $query = $this->db->query($sql,$param['data']['ID_Card_Number']);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;



    }

}
