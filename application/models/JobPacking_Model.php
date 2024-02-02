<?php defined('BASEPATH') or exit('No direct script access allowed');

class JobPacking_Model extends MY_Model
{

    /**
     * JobPacking
     * ---------------------------------
     * @param : null
     */
    public function select_jobpacking()
    {

        $this->set_db('default');

        $sql = "
            
		select CONVERT(varchar, Job_Date, 103) AS Date1,Tb_Job.*,ms_Item.ITEM_ID,ms_Item.ITEM_CODE,ms_Item.ITEM_DESCRIPTION,Status_desc 
		from Tb_Job
        left join ms_Item on ms_Item.ITEM_ID = Tb_Job.ITEM_ID
        inner join ms_Status ON Tb_Job.Job_Status = dbo.ms_Status.Status_ID
        order by Job_No DESC";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }


    /**
     * JobNo no
     * ---------------------------------
     * @param : null
     */
    public function select_job_no()
    {

        $this->set_db('default');

        $sql = "
        select dbo.[fnGetJobDocNo] ('1') as JobNo
        ";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }


    /**
     * Insert JobPacking
     * ---------------------------------
     * @param : FormData
     */
    public function insert_jobpacking($param = [])
    {
        $this->set_db('default');

        return ($this->db->insert('Tb_Job', $param['data'])) ? $this->db->insert_id() : false/*$this->db->error()*/;

    }

    /**
     * Insert JobPacking Item
     * ---------------------------------
     * @param : FormData
     */
    public function insert_jobpacking_item($param = [])
    {
        $this->set_db('default');

        return ($this->db->insert('Tb_JobItem', $param['data'])) ? $this->db->insert_id() : false/*$this->db->error()*/;

    }

    /**
     * Insert JobPacking Item
     * ---------------------------------
     * @param : FormData
     */
    public function insert_jobpacking_QrGen($param = [])
    {
        $this->set_db('default');

        return ($this->db->insert('Tb_QRCode_Generate', $param['data'])) ? $this->db->insert_id() : false/*$this->db->error()*/;

    }

     /**
     * Update JobPacking
     * ---------------------------------
     * @param : FormData
     */
    public function update_jobpacking($param = [])
    {
        $this->set_db('default');

        return ($this->db->update('Tb_Job', $param['data'], ['Job_ID'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

     /**
     * Delete JobPacking
     * ---------------------------------
     * @param : JobPacking_Index
     */
    public function delete_jobpacking($param = [])
    {
        $this->set_db('default');

        return ($this->db->delete('Tb_Job', ['Job_No'=> $param['Job_No']])) ? true : false/*$this->db->error()*/;

    }
         /**
     * Delete JobPacking Item
     * ---------------------------------
     * @param : JobPacking_ID
     */
    public function delete_jobpacking_item($param = [])
    {
        $this->set_db('default');

        return ($this->db->delete('Tb_JobItem', ['Job_ID'=> $param['index']])) ? true : false/*$this->db->error()*/;

    }

    


    /**
     * JobPackingItem
     * ---------------------------------
     * @param : null
     */
    public function select_jobpackingitem($param)
    {

        $this->set_db('default');

        $sql = "
            select Tb_JobItem.JobItem_ID as [key],Tb_JobItem.Item_ID as Grade_ID,Tb_JobItem.QR_NO,
            ms_Item.ITEM_CODE as ITEM_DESCRIPTION,Tb_JobItem.Lot_No,Tb_JobItem.Qty as QTY,ms_ProductType.Product_DESCRIPTION  as Type
            from Tb_JobItem
            inner join ms_Item on Tb_JobItem.Item_ID = ms_Item.ITEM_ID
            inner join ms_ProductType on ms_Item.Product_ID = ms_ProductType.Product_ID
            where Job_ID = '$param'
            order by JobItem_ID

            
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;



    }


    public function insert_qrcode_temp($JobNo = null,$JobDate = null, $MaterialID = null,$Qty = 0,$LotNo = null,$UserName = null,$Job_ID = null)
    {

        $this->set_db('default');

        $sql = "

            exec SP_CreateQRCode ?,?,?,?,?,?,?

        ";

        $query = $this->db->query($sql, [$JobNo,$JobDate, $MaterialID, $Qty, $LotNo,$UserName,$Job_ID ]);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

    public function delete_qrcode_temp($JobNo = null)
    {

        $this->set_db('default');

        $sql = "

            exec SP_ClearQRCode ?

        ";

        $query = $this->db->query($sql, [$JobNo]);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}