<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/2/17
 * Time: 11:07 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_category extends MY_Model
{
    var $table = 'master_category';

    var $column_order = array(null, 'kategori'); //set column field database for datatable orderable
    var $column_search = array('kategori'); //set column field database for datatable searchable
    var $order = array('id_category' => 'desc'); // default order

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->result();
    }

    public function getNama($id){
        $this->db->select('kategori');
        $this->db->from($this->table);
        $this->db->where('id_category',$id);
        $this->db->where('soft_delete','0');

        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }
}