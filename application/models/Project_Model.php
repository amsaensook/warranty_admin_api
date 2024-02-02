<?php defined('BASEPATH') or exit('No direct script access allowed');

class Project_Model extends MY_Model
{

    /**
     * Project
     * ---------------------------------
     * @param : null
     */
    public function select_project()
    {

        $this->set_db('default');

        $sql = "
        select * from Tb_Project where Status <> -1
        ";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

    /**
     * Insert Project
     * ---------------------------------
     * @param : FormData
     */
    public function insert_project($param = [])
    {
        $this->set_db('default');

        return ($this->db->insert('Tb_Project', $param['data'])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Update Project
     * ---------------------------------
     * @param : FormData
     */
    public function update_project($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('Tb_Project', $param['data'], ['Project_ID'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Delete Project
     * ---------------------------------
     * @param : Project_Index
     */
    public function delete_project($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('Tb_Project', $param['data'], ['Project_ID'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

    /**
     * CheckProject
     * ---------------------------------
     * @param : null
     */             
    public function check_project($param = [])
    {
        $this->set_db('default');

        $sql = "

        select ID_Card_Number from Tb_Project where IsUse = 1 and ID_Card_Number = ?
            
        ";

        $query = $this->db->query($sql,$param['data']['ID_Card_Number']);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;



    }

}

