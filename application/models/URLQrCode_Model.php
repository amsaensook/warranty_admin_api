<?php defined('BASEPATH') or exit('No direct script access allowed');

class URLQrCode_Model extends MY_Model
{

    /**
     * Menu Type
     * ---------------------------------
     * @param : null
     */
    public function select_url_qrcode()
    {

        $this->set_db('default');

        $sql = " select URL_Name from ms_QRCode_URL where Status = 1";

        $query = $this->db->query($sql);

        $result = ($query->num_rows() > 0) ? $query->result_array() : false;

        return $result;

    }

}
