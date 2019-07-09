<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function index(){
        $ip = $this->get_ip_address();
        $cekIP = $this->user->cekIP($ip);

        if(isset($_SESSION['hak_akses'])){
            if($_SESSION['hak_akses'] != 'admin'){
                if($cekIP != NULL){
                    $_SESSION = array(
                        'hak_akses' => 'user',
                        'nama' => $cekIP->nama,
                        'ip' => $cekIP->alamat_ip,
                        'id' => $cekIP->id_user,
                        'session' => $cekIP->session,
                    );
                }
            }
        }
        else{
            if($cekIP != NULL){
                $_SESSION = array(
                    'hak_akses' => 'user',
                    'nama' => $cekIP->nama,
                    'ip' => $cekIP->alamat_ip,
                    'id' => $cekIP->id_user,
                    'session' => $cekIP->session,
                );
            }
        }

        if(isset($_SESSION['hak_akses'])){
            if($_SESSION['hak_akses'] == 'admin'){
                $data['user'] = $this->user->getUser();
                $data['kategori'] = $this->kategori->getData();
                $data['status'] = $this->status->getStatus();
                $data['status_filter'] = $this->status->getStatusFiltered(1);
                $data['jumlah'] = $this->status->getJumlah();
            }
            else{
                $data['status_filter'] = $this->status->getStatusFiltered(1);
                $data['kategori'] = $this->kategori->getData();
                $status = $this->status->getStatus("user");
                $data['status'] = $status;
                $data['jumlah'] = 3;
            }
        }
        else{
            $data['status_filter'] = $this->status->getStatusFiltered(1);
            $data['kategori'] = $this->kategori->getData();
            $status = $this->status->getStatus("user");
            $data['status'] = $status;
            $data['jumlah'] = 3;
        }

        $data['ip'] = $ip;
        $data['title'] = 'Support Ticket PT. KKT';
        $this->load->template('v_main',$data);
    }

    public function open(){

        $ip = $this->get_ip_address();
        $cekIP = $this->user->cekIP($ip);

        if(isset($_SESSION['hak_akses'])){
            if($_SESSION['hak_akses'] != 'admin1'){
                if($cekIP != NULL){
                    $_SESSION = array(
                        'hak_akses' => $cekIP->role,
                        'nama' => $cekIP->nama,
                        'ip' => $cekIP->alamat_ip,
                        'id' => $cekIP->id_user,
                        'session' => $cekIP->session,
                    );
                }
                else{
                    $session = array(
                        'hak_akses',
                        'nama',
                        'ip',
                        'id',
                        'session',
                    );
                    $this->session->unset_userdata($session);
                }
            }
        }
        else{
            if($cekIP != NULL){
                $_SESSION = array(
                    'hak_akses' => $cekIP->role,
                    'nama' => $cekIP->nama,
                    'ip' => $cekIP->alamat_ip,
                    'id' => $cekIP->id_user,
                    'session' => $cekIP->session,
                );
            }
            else{
                $session = array(
                    'hak_akses',
                    'nama',
                    'ip',
                    'id',
                    'session',
                );
                $this->session->unset_userdata($session);
            }
        }

        if(isset($_SESSION['hak_akses'])){
            if($_SESSION['hak_akses'] == 'admin1'){
                $data['user'] = $this->user->getUser();
                $data['kategori'] = $this->kategori->getData();
                $data['status'] = $this->status->getStatus(1);
                $data['status_filter'] = $this->status->getStatusFiltered(1);
                $data['jumlah'] = '1';
            }
            else{
                $session = array(
                    'hak_akses',
                    'nama',
                    'ip',
                    'id',
                    'session',
                );
                $this->session->unset_userdata($session);
            }
        }

        $data['ip'] = $ip;
        $data['title'] = 'Support Ticket PT. KKT';
        $this->load->template('v_main_admin',$data);
    }

    public function admin(){
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

    public function view(){
        $page = $_GET['page'];
        $title = $_GET['title'];
        $data['title'] = $title;
        $this->load->template($page,$data);
    }

    public function cekNotifSupport(){
        $result = $this->tiket->notifSupport();
        echo json_encode($result);
    }

    public function cekSesi(){
        $session = $_SESSION['hak_akses'];

        if($session == "admin")
            $result = 1;
        else
            $result = 0;

        echo json_encode($result);
    }
}