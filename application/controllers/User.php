<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/2/17
 * Time: 11:13 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function ajax_list() {
        $list = $this->user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = '<center><input type="checkbox" class="data-check-user" value="'.$person->id_user.'">';
            $row[] = $person->alamat_ip;
            $row[] = $person->nama;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
  				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_user('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->countAll(),
            "recordsFiltered" => $this->user->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $where = array(
            'id_user' => $id,
        );
        $data = $this->user->get_data_by_id($where);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $key = "PTKKT2406";
        $session = md5($this->input->post('alamat-ip').$key.$this->input->post('nama-user').$key);
        $waktu = date("Y-m-d H:i:s", time());

        $data = array(
            'alamat_ip' => $this->input->post('alamat-ip'),
            'nama' => $this->input->post('nama-user'),
            'session' => $session,
            'created_at' => $waktu,
            'created_by' => $_SESSION['nama'],
        );

        $insert = $this->user->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $key     = "PTKKT2406";
        $session = md5($this->input->post('alamat-ip').$key.$this->input->post('nama-user').$key);
        $waktu      = date("Y-m-d H:i:s", time());

        $data = array(
            'alamat_ip' => $this->input->post('alamat-ip'),
            'nama' => $this->input->post('nama-user'),
            'session' => $session,
            'modified_by' => $_SESSION['nama'],
            'modified_at' => $waktu,
        );

        $this->user->update(array('id_user' => $this->input->post('id_user')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $where = array(
            'id_user' => $id,
        );
        $this->user->delete($where);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $where = array(
                'id_user' => $id,
            );
            $this->user->delete($where);
        }
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == 'admin' ){
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if($this->input->post('alamat-ip') == NULL)
            {
                $data['inputerror'][] = 'alamat-ip';
                $data['error_string'][] = 'Alamat IP Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if($this->input->post('nama-user') == NULL)
            {
                $data['inputerror'][] = 'nama-user';
                $data['error_string'][] = 'Nama Tidak Boleh Kosong';
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