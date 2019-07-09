<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/2/17
 * Time: 11:08 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_admin extends MY_Model
{
    var $table = 'master_admin';

    var $column_order = array(null, 'username','nama'); //set column field database for datatable orderable
    var $column_search = array('username','nama'); //set column field database for datatable searchable
    var $order = array('id_admin' => 'desc'); // default order

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->result();
    }

    public function login($session){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('session',$session);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $this->updateLogin($session);
            return $query->row();
        }
    }

    public function updateLogin($session){
        $time = date('Y-m-d H:i:s',time());
        $this->db->set('last_login',$time);
        $this->db->where('session',$session);
        $this->db->update($this->table);
    }

    public function getNama($id){
        $this->db->select('nama');
        $this->db->from($this->table);
        $this->db->where('id_admin',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }
}