<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata('role') != "admin"){

} else{
    redirect('main');
}
?>