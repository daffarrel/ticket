<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/2/17
 * Time: 4:46 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    var $table; //set name of the table
    var $column_order; //set column field database for datatable orderable
    var $column_search; //set column field database for datatable searchable
    var $order; // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function _get_datatables_query()
    {

        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function countFiltered()
    {
        $this->_get_datatables_query();
        $this->db->where('soft_delete','0');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->where('soft_delete','0');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $data = array(
            'soft_delete' => '1',
        );
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function get_data_by_id($where)
    {
        $this->db->from($this->table);
        $this->db->where($where);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->row();
    }

    public function get_data($where){
        $this->db->from($this->table);
        $this->db->where($where);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function getData(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function cekIP($ip){
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('alamat_ip',$ip);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

}