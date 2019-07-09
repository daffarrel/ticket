<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/2/17
 * Time: 11:08 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Data_support extends MY_Model
{
    var $table = 'support_ticket';

    var $column_order = array(null, 'created_at','keluhan','kategori','user','agent'); //set column field database for datatable orderable
    var $column_search = array('keluhan','kategori','user','agent'); //set column field database for datatable searchable
    var $order = array('created_at' => 'desc'); // default order

    function _get_datatables_query()
    {

        $this->db->from('v_support');

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

    public function get_datatables($status = '')
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        if($status == ''){
            $this->db->where('soft_delete','0');
            $query = $this->db->get();
        }
        else{
            $this->db->where('soft_delete','0');
            $this->db->where('status_keluhan',$status);
            $query = $this->db->get();
        }

        return $query->result();
    }

    public function count_filtered($status = '',$id = '')
    {
        $this->_get_datatables_query();
        if($id != ''){
            $this->db->where('user',$id);
            $this->db->where('soft_delete','0');
        }
        if($status != ''){
            $this->db->where('status_keluhan',$status);
            $this->db->where('soft_delete','0');
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($status = '',$id = '')
    {
        $this->db->from($this->table);
        if($id != ''){
            $this->db->where('user',$id);
            $this->db->where('soft_delete','0');
        }
        if($status != ''){
            $this->db->where('status_keluhan',$status);
            $this->db->where('soft_delete','0');
        }

        return $this->db->count_all_results();
    }

    public function delete_by_id($id)
    {
        $this->db->set('status_keluhan','4');
        $this->db->where('id_transaksi', $id);
        $this->db->update($this->table);
    }

    public function notifSupport(){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('status_keluhan','1');
        $this->db->where('soft_delete =', 0);

        $query = $this->db->get();

        return $query->num_rows();
    }

}