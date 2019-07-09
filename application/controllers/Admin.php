<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/2/17
 * Time: 11:13 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function index(){
        $data['title'] = "Halaman Admin";
        $data['error'] = "";
        $this->load->template('v_admin',$data);
    }

    public function login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $session = array(
                'hak_akses',
                'nama',
                'ip',
                'id',
                'session',
            );
            $this->session->unset_userdata($session);

            $data['title'] = "Halaman Admin";
            $data['error'] = "";
            $this->load->template('v_admin',$data);
        }
        else
        {
            $key = "PTKKT2406";
            $session = md5($username.$key.$password.$key);
            $verify = $this->admin->login($session);

            if($verify != NULL) {
                $_SESSION = array(
                    'hak_akses' => $verify->role,
                    'nama' => $verify->nama,
                    'id' => $verify->id_admin,
                    'ip' => '',
                    'session' => $verify->session,
                );
                $data['user'] = $this->user->getUser();
                $data['kategori'] = $this->kategori->getData();
                $data['status'] = $this->status->getStatus();
                $data['status_filter'] = $this->status->getStatusFiltered(1);
                $data['jumlah'] = $this->status->getJumlah();
                $data['title'] = 'Halaman Utama';
                $this->load->template('v_main',$data);
            }
            else {
                $session = array(
                    'hak_akses',
                    'nama',
                    'ip',
                    'id',
                    'session',
                );
                $this->session->unset_userdata($session);
                $data['title'] = 'Halaman Admin';
                $data['error'] = 'Username atau Password Anda Salah';
                $this->load->template('v_admin',$data);
            }
        }

    }

    public function logout(){
        session_unset();
        session_destroy();
        redirect(base_url());
    }

    public function ajax_list() {
        $list = $this->admin->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = '<center><input type="checkbox" class="data-check" value="'.$person->id_admin.'">';
            $row[] = $person->username;
            $row[] = $person->nama;
            $row[] = $person->role;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_admin('."'".$person->id_admin."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
  				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_admin('."'".$person->id_admin."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->countAll(),
            "recordsFiltered" => $this->admin->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $where = array(
            'id_admin' => $id,
        );
        $data = $this->admin->get_data_by_id($where);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $key = "PTKKT2406";
        $session = md5($this->input->post('username').$key.$this->input->post('pass').$key);
        $waktu = date("Y-m-d H:i:s", time());

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('pass'),
            'nama' => $this->input->post('nama'),
            'session' => $session,
            'created_at' => $waktu,
            'created_by' => $_SESSION['nama'],
        );

        $insert = $this->admin->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $key     = "PTKKT2406";
        $session = md5($this->input->post('username').$key.$this->input->post('pass').$key);
        $waktu      = date("Y-m-d H:i:s", time());

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('pass'),
            'nama' => $this->input->post('nama'),
            'session' => $session,
            'modified_by' => $_SESSION['nama'],
            'modified_at' => $waktu,
        );

        $this->admin->update(array('id_admin' => $this->input->post('id_admin')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $where = array(
            'id_admin' => $id,
        );
        $this->admin->delete($where);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $where = array(
                'id_admin' => $id,
            );
            $this->admin->delete($where);
        }
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == 'admin' ){
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if($this->input->post('username') == NULL)
            {
                $data['inputerror'][] = 'username';
                $data['error_string'][] = 'Username Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if($this->input->post('pass') == NULL)
            {
                $data['inputerror'][] = 'pass';
                $data['error_string'][] = 'Password Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if($this->input->post('confirm_pass') == NULL)
            {
                $data['inputerror'][] = 'pass';
                $data['error_string'][] = 'Konfirmasi Password Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if($this->input->post('confirm_pass') != $this->input->post('pass'))
            {
                $data['inputerror'][] = 'confirm_pass';
                $data['error_string'][] = 'Password Harus Sama Dengan Konfirmasi Password';
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