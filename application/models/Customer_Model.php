<?php defined('BASEPATH') or exit('No direct script access allowed');

class Customer_Model extends MY_Model
{

    /**
     * Customer
     * ---------------------------------
     * @param : null
     */
    public function select_customer()
    {

        $this->set_db('default');

        $sql = "
        select PreFix+Name+'  '+Surname as Fullname,Phone_Number,Link,Remark,*
        from se_Customer where IsUse = 1
        ";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

    /**
     * Insert Customer
     * ---------------------------------
     * @param : FormData
     */
    public function insert_customer($param = [])
    {
        $this->set_db('default');

        return ($this->db->insert('se_Customer', $param['data'])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Update Customer
     * ---------------------------------
     * @param : FormData
     */
    public function update_customer($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('se_Customer', $param['data'], ['Customer_ID'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Delete Customer
     * ---------------------------------
     * @param : Customer_Index
     */
    public function delete_customer($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('se_Customer', $param['data'], ['Customer_ID'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

    /**
     * CheckCustomer
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
