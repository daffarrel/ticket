<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 10/3/17
 * Time: 11:53 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('Data_support','ticket');
        $this->load->model('Data_user','user');
        $this->load->model('Data_admin','admin');
    }

    public function ajax_tabel() {
        $status = $this->input->post('status');
        $list = $this->ticket->get_datatables($status);
        $data = array();
        $no = $_POST['start'];

        if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == "admin"){
            foreach ($list as $ticket) {
                $tanggal = $this->indonesian_date('l, d-m-Y H:i:s',strtotime($ticket->created_at));
                $tgl_update = $this->indonesian_date('d-m-Y H:i:s',strtotime($ticket->modified_at));
                $tombol = '';
                $admin = $_SESSION['id'];
                $agent = $ticket->agent;

                if($ticket->kategori == NULL || $ticket->kategori == "")
                    $ticket->kategori = "Belum Di Tentukan";

                if($ticket->agent == NULL || $ticket->agent == ""){
                    $ticket->agent = "";
                }
                else{
                    $ticket->agent .= ", <br>".$tgl_update;
                }

                if($ticket->status_keluhan == 1 && $ticket->status_pelaksanaan == 0)
                    $tombol = '<button class="btn btn-info" title="Eksekusi" onclick="ubah_status('.$ticket->id_transaksi.')"><i class="glyphicon glyphicon-modal-window"></i></button>';

                if((($ticket->status_keluhan == 1 || $ticket->status_keluhan == 2) && $ticket->status_pelaksanaan == 1 ) )
                    $tombol = '<button id="btn-penanganan" title="Penanganan" class="btn btn-success" onclick="penanganan('.$ticket->id_transaksi.')"><i class="glyphicon glyphicon-floppy-save"></i></button>&nbsp;';

                if($ticket->status_keluhan == 2 && $ticket->status_pelaksanaan == 1){
                    $tombol .= '<button id="btn-informasi" title="Informasi" class="btn btn-info" onclick="informasi('.$ticket->id_transaksi.')"><i class="glyphicon glyphicon-info-sign"></i></button>&nbsp;';
                }

                if($ticket->status_keluhan == 2 && $ticket->status_pelaksanaan == 1 ){
                    $tombol .= '<button id="btn-update-penanganan" title="Update Penanganan" class="btn btn-info" onclick="update_informasi('.$ticket->id_transaksi.')"><i class="glyphicon glyphicon-new-window"></i></button>';
                }

                if((($ticket->status_keluhan == 3) && $ticket->status_pelaksanaan == 1 ))
                    $tombol = '<button id="btn-informasi" title="Informasi" class="btn btn-info" onclick="informasi('.$ticket->id_transaksi.')"><i class="glyphicon glyphicon-info-sign"></i></button>';


                $no++;
                $row = array();
                $row[] = "<center>".$no."<input hidden id='ticket' name='ticket' value='$ticket->status_keluhan'/><input hidden id='ticket_status' name='ticket_status' value='$ticket->status_keluhan'/>";
                $row[] = "<center>".$tanggal;
                $row[] = $ticket->keluhan;
                $row[] = $ticket->kategori;
                $row[] = "<center>".$ticket->user;
                $row[] = "<center>".$ticket->agent;
                $row[] = "<center>".$tombol;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->ticket->count_all($status),
                "recordsFiltered" => $this->ticket->count_filtered($status),
                "data" => $data,
            );
        }
        else if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == "admin1"){
            foreach ($list as $ticket) {
                $tanggal = $this->indonesian_date('l, d-m-Y H:i:s',strtotime($ticket->created_at));
                $tgl_update = $this->indonesian_date('d-m-Y H:i:s',strtotime($ticket->modified_at));
                $tombol = '';

                if($ticket->kategori == NULL || $ticket->kategori == '')
                    $ticket->kategori = 'Belum Di Tentukan';

                if($ticket->agent == NULL || $ticket->agent == ""){
                    $ticket->agent = "";
                }
                else{
                    $ticket->agent .= ", <br>".$tgl_update;
                }

                $no++;
                $row = array();
                $row[] = "<center>".$no."<input hidden id='ticket' name='ticket' value='$ticket->status_keluhan'/><input hidden id='ticket_status' name='ticket_status' value='$ticket->status_keluhan'/>";
                $row[] = "<center>".$tanggal;
                $row[] = $ticket->keluhan;
                $row[] = $ticket->kategori;
                $row[] = "<center>".$ticket->user;
                $row[] = "<center>".$ticket->agent;
                $row[] = "<center>".$tombol;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->ticket->count_all($status),
                "recordsFiltered" => $this->ticket->count_filtered($status),
                "data" => $data,
            );
        }
        else{
            foreach ($list as $ticket) {
                $tanggal = $this->indonesian_date('l, d-m-Y',strtotime($ticket->created_at));
                $tgl_update = $this->indonesian_date('d-m-Y H:i:s',strtotime($ticket->modified_at));

                if($ticket->agent == NULL || $ticket->agent == ""){
                    $ticket->agent = "";
                }
                else{
                    $ticket->agent .= ", <br>".$tgl_update;
                }

                if(isset($_SESSION['nama']))
                {
                    if($ticket->user == $_SESSION['nama']){
                        $no++;
                        $row = array();
                        $row[] = "<center>".$no;
                        $row[] = "<center>".$tanggal;
                        if($ticket->status_keluhan != '1' && $ticket->status_pelaksanaan == '1')
                            $row[] = "<a onclick='informasi(".$ticket->id_transaksi.")'>".$ticket->keluhan."</a>";
                        else
                            $row[] = $ticket->keluhan;
                        $row[] = "<center>".$ticket->agent;

                        $data[] = $row;
                    }
                }
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->ticket->count_all($status,$this->session->userdata('id')),
                "recordsFiltered" => $this->ticket->count_filtered($status,$this->session->userdata('id')),
                "data" => $data,
            );
        }

        //output to json format
        echo json_encode($output);
    }

    public function ajax_add() {
        if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == 'admin' ){
            $this->_validate();

            $data = array(
                'keluhan' => $this->input->post('keluhan'),
                'user' => $this->input->post('klien'),
                'created_at' => date('Y-m-d H:i:s',time()),
                'created_by' => $this->session->userdata('nama'),
            );
        }
        else{
            $this->_validate();

            $data = array(
                'keluhan' => $this->input->post('keluhan'),
                'user' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s',time()),
                'created_by' => $this->session->userdata('nama'),
            );
        }

        $insert = $this->ticket->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ubah_status(){
        $id = $this->input->post('klien');
        $where = array(
            'id_transaksi' => $id,
        );
        $data = array(
            'status_pelaksanaan' => '1',
            'agent' => $_SESSION['id'],
        );

        $update = $this->ticket->update($where,$data);

        echo json_encode(array("status" => TRUE));
    }

    public function penanganan(){
        $id = $this->input->post('id_aksi');
        $this->_validate_penanganan();
        $where = array(
            'id_transaksi' => $id,
        );
        $data = array(
            'kategori' => $this->input->post('aksi_kategori'),
            'status_keluhan' => $this->input->post('aksi'),
            'penanganan' => $this->input->post('penanganan_aksi'),
            'catatan' => $this->input->post('catatan_aksi'),
            'agent' => $this->session->userdata('id'),
            'modified_at' => date('Y-m-d H:i:s',time()),
            'modified_by' => $this->session->userdata('nama'),
        );

        $update = $this->ticket->update($where,$data);

        echo json_encode(array("status" => TRUE,"id" => $id,"kategori" => $this->input->post('aksi_kategori')));
    }

    public function getDataPenanganan($id){
        $where = array(
            'id_transaksi' => $id,
        );
        $data = $this->ticket->get_data($where);
        echo json_encode($data);
    }

    private function _validate() {
        if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == 'admin' ){
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if($this->input->post('keluhan') == NULL)
            {
                $data['inputerror'][] = 'keluhan';
                $data['error_string'][] = 'Isi Keluhan Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if($this->input->post('klien') == NULL || $this->input->post('klien') == '')
            {
                $data['inputerror'][] = 'klien';
                $data['error_string'][] = 'Pilih Klien Yang Mengaduhkan Keluhan';
                $data['status'] = FALSE;
            }
        }
        else{
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if($this->input->post('keluhan') == NULL)
            {
                $data['inputerror'][] = 'keluhan';
                $data['error_string'][] = 'Isi Keluhan Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_penanganan() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('aksi') == NULL || $this->input->post('aksi') == '')
        {
            $data['inputerror'][] = 'aksi';
            $data['error_string'][] = 'Kolom Aksi Harus Di Pilih';
            $data['status'] = FALSE;
        }

        if($this->input->post('aksi_kategori') == NULL || $this->input->post('aksi_kategori') == '')
        {
            $data['inputerror'][] = 'aksi_kategori';
            $data['error_string'][] = 'Kolom Kategori Harus Di Pilih';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}