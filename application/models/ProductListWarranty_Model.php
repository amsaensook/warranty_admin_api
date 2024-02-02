<?php defined('BASEPATH') or exit('No direct script access allowed');

class ProductListWarranty_Model extends MY_Model
{

    /**
     * job no
     * ---------------------------------
     * @param : null
     */
    public function select_productlistwarranty($param)
    {

        $this->set_db('default');

        $sql = "
        select case when DATEDIFF(day, Getdate(), Date_Warranty_Expires) > 0 then 'Active'
                when DATEDIFF(day, Getdate(), Date_Warranty_Expires) <= 0 then 'Expired'
                else null end as Warranty_Expires,
                case when DATEDIFF(day, Getdate(), Date_Warranty_Expires) > 0 then '#87d068'
                when DATEDIFF(day, Getdate(), Date_Warranty_Expires) <= 0 then '#f50'
                else null end as Color_tag,
                convert(varchar, Date_Warranty_Expires, 103) as Date_Warranty_Expires1,*
            from tb_WarrantyProduct  
            where Customer_ID = $param and Status <> -1
        ";

        $query = $this->db->query($sql,$param);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}
