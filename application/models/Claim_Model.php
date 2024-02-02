<?php defined('BASEPATH') or exit('No direct script access allowed');

class Claim_Model extends MY_Model
{

    /**
     * Claim
     * ---------------------------------
     * @param : null
     */
    public function select_claim($param)
    {

        $this->set_db('default');

        $sql = "
        select *
        from Tb_Claim where Warranty_Index = $param
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

    /**
     * Claim
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
     * Insert Claim
     * ---------------------------------
     * @param : FormData
     */
    public function insert_claim($param = [])
    {
        $this->set_db('default');

        return ($this->db->insert('Tb_Claim', $param['data'])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Update Claim
     * ---------------------------------
     * @param : FormData
     */
    public function update_claim($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('Tb_Claim', $param['data'], ['Claim_Index'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Delete Claim
     * ---------------------------------
     * @param : Claim_Index
     */
    public function delete_claim($param = [])
    {
        $this->set_db('default');

        return ($this->db->delete('Tb_Claim', ['Claim_Index'=> $param['index']])) ? true : false/*$this->db->error()*/;
    }

    /**
     * CheckClaim
     * ---------------------------------
     * @param : null
     */             
    public function check_seqclaim($param)
    {
        $this->set_db('default');

        $sql = "

        select ISNULL(MAX(Warranty_Seq)+1,1) as Seq from [Tb_Claim] where Warranty_Index = '$param'
            
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;



    }

}


