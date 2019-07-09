<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/2/17
 * Time: 11:14 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function ajax_list() {
        $list = $this->status->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = '<center><input type="checkbox" class="data-check-status" value="'.$person->id_status.'">';
            $row[] = $person->nama_status;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_status('."'".$person->id_status."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
  				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_status('."'".$person->id_status."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->status->countAll(),
            "recordsFiltered" => $this->status->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $where = array(
            'id_status' => $id,
        );
        $data = $this->status->get_data_by_id($where);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'nama_status' => $this->input->post('status'),
        );

        $insert = $this->status->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();

        $data = array(
            'nama_status' => $this->input->post('status'),
        );

        $this->status->update(array('id_status' => $this->input->post('id_status')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $where = array(
            'id_status' => $id,
        );
        $this->status->delete($where);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $where = array(
                'id_status' => $id,
            );
            $this->status->delete($where);
        }
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == 'admin' ){
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if($this->input->post('status') == NULL)
            {
                $data['inputerror'][] = 'status';
                $data['error_string'][] = 'Status Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}