<?php
/**
 * Created by PhpStorm.
 * kategori: fendykwan
 * Date: 10/2/17
 * Time: 11:13 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function ajax_list() {
        $list = $this->kategori->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = '<center><input type="checkbox" class="data-check-kategori" value="'.$person->id_category.'">';
            $row[] = $person->kategori;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_category('."'".$person->id_category."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
  				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_category('."'".$person->id_category."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kategori->countAll(),
            "recordsFiltered" => $this->kategori->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $where = array(
            'id_category' => $id,
        );
        $data = $this->kategori->get_data_by_id($where);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'kategori' => $this->input->post('kategori'),
        );

        $insert = $this->kategori->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();

        $data = array(
            'kategori' => $this->input->post('kategori'),
        );

        $this->kategori->update(array('id_category' => $this->input->post('id_category')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $where = array(
            'id_category' => $id,
        );
        $this->kategori->delete($where);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $where = array(
                'id_category' => $id,
            );
            $this->kategori->delete($where);
        }
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == 'admin' ){
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if($this->input->post('kategori') == NULL)
            {
                $data['inputerror'][] = 'kategori';
                $data['error_string'][] = 'Kategori Tidak Boleh Kosong';
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