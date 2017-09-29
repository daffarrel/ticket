<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('data');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index(){

    }

    public function ajax_list() {
        $status = $_POST['status'];
        $list = $this->tabel->get_datatables($status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perdir) {
            if(isset($_SESSION['sesi'])){
                $no++;
                $row = array();
                $row[] = "<center>".$no;
                $row[] = "<center>".$perdir->keluhan;
                $row[] = $perdir->nama;


                if($perdir->file != null){
                    $row[] = $link;
                }
                else{
                    $row[] = "";
                }

                if(isset($_SESSION['sesi'])) {
                    if ($perdir->file != NULL) {
                        $row[] = '<center><a class="btn btn-sm btn-primary" href="main/edit?id=' . $perdir->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                  <center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="delete_data('."'".$perdir->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Delete</a>';
                    }
                    else {
                        $row[] = '<center><a class="btn btn-sm btn-primary" href="main/edit?id=' . $perdir->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                  <center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="delete_data('."'".$perdir->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Delete</a>
                                  <center><a class="btn btn-sm btn-primary" href="main/upload?id=' . $perdir->id . '" title="Upload"><i class="glyphicon glyphicon-pencil"></i> Upload</a>';
                    }
                }
                $data[] = $row;
            }
            else{
                $no++;
                $row = array();
                $row[] = "<center>".$no;
                $row[] = "<center>".$perdir->no_dokumen;
                $row[] = $perdir->nama;
                if(isset($_SESSION['sesi'])){
                    $row[] = "<center>".$perdir->tgl_dokumen;
                }
                $file  = base_url()."files/".$perdir->file;
                $link = "<center><a class='btn btn-info' href='$file' target='_blank'>Lihat Dokumen</a>";

                if($perdir->file != null){
                    $row[] = $link;
                }
                else{
                    $row[] = "";
                }
                if(isset($_SESSION['sesi'])) {
                    if ($perdir->file != NULL) {
                        $row[] = '<center><a class="btn btn-sm btn-primary" href="main/edit?id=' . $perdir->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
                    }
                    else {
                        $row[] = '<center><a class="btn btn-sm btn-primary" href="main/upload?id=' . $perdir->id . '" title="Upload"><i class="glyphicon glyphicon-pencil"></i> Upload</a>';
                    }
                }
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tabel->count_all($tahun),
            "recordsFiltered" => $this->tabel->count_filtered($tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}