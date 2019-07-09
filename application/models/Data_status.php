<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_status extends MY_Model {
    var $table = 'master_status';

    var $column_order = array(null, 'nama_status'); //set column field database for datatable orderable
    var $column_search = array('nama_status'); //set column field database for datatable searchable
    var $order = array('id_status' => 'asc'); // default order

    function __construct() {
        parent::__construct();
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->result();
    }

    public function getStatus($id = ''){
        $this->db->select('nama_status,id_status');
        if($id == ''){
            $this->db->from($this->table);
            $this->db->where('soft_delete','0');
            $query = $this->db->get();
        }
        else{
            $this->db->from($this->table);
            $this->db->where('id_status', 1);
            $this->db->or_where('id_status', 2);
            $this->db->or_where('id_status', 3);
            $this->db->where('soft_delete','0');
            $query = $this->db->get();
        }

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getStatusFiltered($id){
        $this->db->select('nama_status,id_status');
        $this->db->from($this->table);
        $this->db->where('id_status != ', $id);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getJumlah(){
        $this->db->from($this->table);
        $this->db->where('soft_delete','0');

        return $this->db->count_all_results();
    }
}