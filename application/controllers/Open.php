<?php
class Open extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function index(){
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
                    session_unset();
                    session_destroy();
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
                session_unset();
                session_destroy();
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
                session_unset();
                session_destroy();
            }
        }

        $data['ip'] = $ip;
        $data['title'] = 'Support Ticket PT. KKT';
        $this->load->template('v_main_admin',$data);
    }
}