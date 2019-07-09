<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 9/28/17
 * Time: 1:27 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <script type="text/javascript">
        $(function() {
            $("#tabs").tabs({
                collapsible: false
            });
        });
    </script>
    <style>
        .table{
            width: 100% !important;
            table-layout: fixed !important;
            word-wrap: break-word !important;
            word-break: break-all !important;
        }
        .th1{
            width: 7% !important;
        }
        .th2{
            width: 18% !important;
        }
        .th3{
            width: 13% !important;
        }
        .th4{
            width: 50% !important;
        }
        .th5{
            width: 16% !important;
        }
        .th6{
            width: 11% !important;
        }
    </style>
<?php
if(isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == "admin"){
?>
    <script type="text/javascript">
        var myVar = setInterval(cekSesi, 5000);
        var base_url = "<?php echo base_url();?>";

        function cekSesi() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "1"){
                        alert("Sesi Anda Telah Habis");
                        window.location = base_url+"main";
                    }
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('main/cekSesi') ?>" , true);
            xmlhttp.send();
        }
    </script>
    <div class="container-fluid">
        <div id="default-content" class="dynamic-content">
            <div class="container-fluid">
                <br />
                <br />
                <br />
                <div class="container-fluid">
                    <button class="btn btn-success" onclick="add_ticket()"><i class="glyphicon glyphicon-plus"></i> New Ticket</button>
                    <button class="btn btn-info" onclick="reload_table()"><i class="glyphicon glyphicon-repeat"></i> Reload Tabel</button>
                </div>
                <br />
                <br />
                <input hidden id="jumlah" value="<?php echo$jumlah?>"/>
                <div id="tabs">
                    <ul>
                        <?php
                        foreach ($status as $item){
                            echo "<li><a href='#".$item->nama_status."'>$item->nama_status </a></li>";
                        }
                        ?>
                    </ul>
                    <?php
                        $no=1;
                        foreach ($status as $item){
                            echo "<div id='$item->nama_status'>";
                            ?>
                            <table id="table<?php echo $no?>" class="table table-responsive table-bordered" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="th1"><center>No</th>
                                    <th class="th2"><center>Tanggal</th>
                                    <th class="th4"><center>Keluhan</th>
                                    <th class="th3"><center>Kategori</th>
                                    <th class="th3"><center>Klien</th>
                                    <th class="th6"><center>Pelaksana</th>
                                    <th class="th5"><center>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><center>No</th>
                                    <th><center>Tanggal</th>
                                    <th><center>Keluhan</th>
                                    <th><center>Kategori</th>
                                    <th><center>Klien</th>
                                    <th><center>Pelaksana</th>
                                    <th><center>Aksi</th>
                                </tr>
                                </tfoot>
                            </table>
                            <?php
                            echo "</div>";
                            $no++;
                        }
                        ?>
                </div>
            </div>
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_aksi" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title">Aksi Lanjutan</h3>
                                </div>
                                <div class="modal-body form">
                                    <form action="#" id="form_aksi" class="form-horizontal">
                                        <input type="hidden" value="" name="id_aksi"/>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Keluhan</label>
                                                <div class="col-md-9">
                                                    <textarea disabled class="form-control" rows="4" style="min-width: 100%" name="keluhan_aksi" id="keluhan_aksi" placeholder="Keluhan Anda"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Kategori</label>
                                                <div class="col-md-9">
                                                    <select id="aksi_kategori" name="aksi_kategori" class="form-control">
                                                        <option value="">----</option>
                                                        <?php
                                                        foreach ($kategori as $option) {
                                                            ?>
                                                            <option value="<?php echo $option->id_category?>"><?php echo $option->kategori?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div id="label_aksi" class="form-group">
                                                <label class="control-label col-md-3">Aksi</label>
                                                <div class="col-md-9">
                                                    <input type="hidden" id="status_filter" name="status_filter">
                                                    <select id="aksi" name="aksi" class="form-control">
                                                        <option value="">----</option>
                                                        <?php
                                                        foreach ($status_filter as $option) {
                                                            ?>
                                                            <option value="<?php echo $option->id_status ?>"><?php echo $option->nama_status ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div id="penanganan" class="form-group">
                                                <label class="control-label col-md-3">Penanganan</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="4" style="min-width: 100%" name="penanganan_aksi" id="penanganan_aksi" placeholder="Penanganan Anda"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div id="catatan" class="form-group">
                                                <label class="control-label col-md-3">Catatan</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="4" style="min-width: 100%" name="catatan_aksi" id="catatan_aksi" placeholder="Catatan Anda"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="btnSaveAksi" onclick="save_aksi()" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
            <!-- End Bootstrap modal -->
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title">Form Pengaduan Keluhan</h3>
                                </div>
                                <div class="modal-body form">
                                    <form action="#" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id"/>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Keluhan</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="4" style="min-width: 100%" name="keluhan" id="keluhan" placeholder="Keluhan Anda"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Klien</label>
                                                <div class="col-md-9">
                                                    <select name="klien" class="form-control" id="klien">
                                                        <option value="">----</option>
                                                        <?php
                                                        foreach ($user as $klien){
                                                            if($klien->soft_delete == '0') {
                                                                ?>
                                                                <option value="<?php echo $klien->id_user ?>"><?php echo $klien->nama ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
            <!-- End Bootstrap modal -->
            <!-- Script for datatables and its other function-->
            <script type="text/javascript">
                var save_method; //for save method string
                var table = [];
                var id_status = [];
                var jumlah = $('#jumlah').val();
                var base_url = '<?php echo base_url();?>';

                $(document).ready(function() {
                    var id_status = <?php echo json_encode($status) ?>;
                    var no = 0;

                    while (true){
                        table[no] = $('#table'+(no+1)).DataTable({
                            "processing": true, //Feature control the processing indicator.
                            "serverSide": true, //Feature control DataTables' server-side processing mode.
                            "order": [], //Initial no order.
                            "dom": 'Bfrtip',
                            "buttons": [
                                'excel','print'
                            ],
                            // Load data for the table's content from an Ajax source
                            "ajax": {
                                "url": "<?php echo base_url('support/ajax_tabel')?>",
                                "type": "POST",
                                "data": {
                                    "status": id_status[no]['id_status'],
                                }
                            },

                            //Set column definition initialisation properties.
                            "columnDefs": [
                                {
                                    "targets" : [0,6], //first column / numbering column
                                    "orderable" : false, //set not orderable
                                },
                            ],
                            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                if ( aData[5] == "Belum Ada" )
                                {
                                    $('td', nRow).css('background-color', '#f2dede' );
                                }
                            }
                        });

                        no++;
                        if(no == jumlah)
                            break;
                    }

                    $("input").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });

                    $("select").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });

                    //check all
                    $("#check-all").click(function () {
                        $(".data-check").prop('checked', $(this).prop('checked'));
                    });
                });

                function add_ticket() {
                    save_method = 'add';
                    $('#form')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string
                    $('#keluhan').attr('type','textarea');
                    $('#klien').attr('type','select');
                    $('#modal_form').modal('show'); // show bootstrap modal
                    $('.modal-title').text('Form Support Ticket'); // Set Title to Bootstrap modal title
                }

                function penanganan(data){
                    save_method = 'update';
                    $('#form_aksi')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string

                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo site_url('support/getDataPenanganan')?>/" + data,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_aksi"]').val(data.id_transaksi);
                            $('[name="keluhan_aksi"]').val(data.keluhan);
                            $('#catatan').hide();
                            $('#penanganan').hide();
                            $('#label_aksi').show();
                            $('#btnSaveAksi').prop("disabled",false);
                            $('#status_filter').val(data.status_keluhan);
                            if($('[name="status_filter"]').val() == 2){
                                $('#aksi').find('option[value="' + 2 + '"]').hide();
                                $('#aksi_kategori').val(data.kategori).prop("disabled", false);
                                $('#catatan_aksi').val(data.catatan).show();
                                $('#penanganan_aksi').val(data.penanganan).show();
                                $('#catatan_aksi').val(data.catatan).prop("disabled", false);
                                $('#penanganan_aksi').val(data.penanganan).prop("disabled", false);
                            }else{
                                $('#aksi').find('option[value="' + 2 + '"]').show();
                                $('#aksi_kategori').val(data.kategori).prop("disabled", false);
                                $('#catatan_aksi').val(data.catatan).show();
                                $('#penanganan_aksi').val(data.penanganan).show();
                                $('#catatan_aksi').val(data.catatan).prop("disabled", false);
                                $('#penanganan_aksi').val(data.penanganan).prop("disabled", false);
                            }
                            $('#modal_aksi').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Penanganan Masalah'); // Set title to Bootstrap modal title
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Mendapat Data Dari Ajax');
                        }
                    });
                }

                function reload_table() {
                    var jumlah = $('#jumlah').val();
                    for(var i = 0;i < jumlah;i++ ){
                        table[i].ajax.reload(null,false); //reload datatable ajax
                    }
                }

                function logout() {
                    window.location = base_url+"admin/logout";
                }

                function save() {
                    $('#btnSave').text('Menyimpan...'); //change button text
                    $('#btnSave').attr('disabled',true); //set button disable
                    var url;

                    url = "<?php echo site_url('support/ajax_add')?>";

                    // ajax adding data to database
                    var formData = new FormData($('#form')[0]);
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data)
                        {
                            if(data.status) //if success close modal and reload ajax table
                            {
                                $('#modal_form').modal('hide');
                                reload_table();
                            }
                            else
                            {
                                for (var i = 0; i < data.inputerror.length; i++)
                                {
                                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                                }
                            }
                            $('#btnSave').text('Simpan'); //change button text
                            $('#btnSave').attr('disabled',false); //set button enable
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error adding / update data');
                            $('#btnSave').text('Simpan'); //change button text
                            $('#btnSave').attr('disabled',false); //set button enable
                        }
                    });
                }

                function save_aksi() {
                    $('#btnSaveAksi').text('Menyimpan...'); //change button text
                    $('#btnSaveAksi').attr('disabled',true); //set button disable
                    var url;

                    url = "<?php echo site_url('support/penanganan')?>";

                    // ajax adding data to database
                    var formData = new FormData($('#form_aksi')[0]);
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data)
                        {
                            if(data.status) //if success close modal and reload ajax table
                            {
                                $('#modal_aksi').modal('hide');
                                reload_table();
                            }
                            else
                            {
                                for (var i = 0; i < data.inputerror.length; i++)
                                {
                                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                                }
                            }
                            $('#btnSaveAksi').text('Simpan'); //change button text
                            $('#btnSaveAksi').attr('disabled',false); //set button enable
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error adding / update data');
                            $('#btnSaveAksi').text('Simpan'); //change button text
                            $('#btnSaveAksi').attr('disabled',false); //set button enable
                        }
                    });
                }

                function ubah_status(data){
                    var url = '<?php echo base_url('support/ubah_status');?>';
                    if(confirm("Ambil Pekerjaan ?")){
                        $.ajax({
                            url : url,
                            type :"POST",
                            data : {
                                'klien' : data
                            },

                            success : function(data){
                                if(data.status){
                                    reload_table();
                                    alert('Sukses Mengambil Pekerjaan');
                                }else{
                                    reload_table();
                                    alert('Sukses Mengambil Pekerjaan');
                                }
                            },
                            error: function (jqXHR,textStatus,errorThrown) {
                                alert('Error ubah status');
                            }
                        });
                    }
                }

                function informasi(data){
                    $('#form_aksi')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string

                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo site_url('support/getDataPenanganan')?>/" + data,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_aksi"]').val(data.id_transaksi);
                            $('[name="keluhan_aksi"]').val(data.keluhan);
                            $('#label_aksi').hide();
                            $('#catatan').show();
                            $('#penanganan').show();
                            $('#aksi_kategori').val(data.kategori).prop("disabled", true);
                            $('#btnSaveAksi').prop("disabled",true);
                            $('#catatan_aksi').val(data.catatan).show();
                            $('#penanganan_aksi').val(data.penanganan).show();
                            $('#catatan_aksi').val(data.catatan).prop("disabled", true);
                            $('#penanganan_aksi').val(data.penanganan).prop("disabled", true);
                            $('#modal_aksi').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Informasi'); // Set title to Bootstrap modal title
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Mendapat Data Dari Ajax');
                        }
                    });
                }

                function update_informasi(data){
                    $('#form_aksi')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string

                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo site_url('support/getDataPenanganan')?>/" + data,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_aksi"]').val(data.id_transaksi);
                            $('[name="keluhan_aksi"]').val(data.keluhan);
                            $('#label_aksi').hide();
                            $('#aksi').val(data.status_keluhan);
                            $('#catatan').show();
                            $('#penanganan').show();
                            $('#aksi_kategori').val(data.kategori).prop("disabled", false);
                            $('#btnSaveAksi').prop("disabled",false);
                            $('#catatan_aksi').val(data.catatan).show();
                            $('#penanganan_aksi').val(data.penanganan).show();
                            $('#catatan_aksi').val(data.catatan).prop("disabled", false);
                            $('#penanganan_aksi').val(data.penanganan).prop("disabled", false);
                            $('#modal_aksi').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Update Informasi'); // Set title to Bootstrap modal title
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Mendapat Data Dari Ajax');
                        }
                    });
                }
            </script>
            <script type="text/javascript">
                $("#aksi").change(function(){
                    //get selected category
                    var selectedValue = $(this).find(":selected").val();

                    if(selectedValue != 4){
                        $('#penanganan').show();
                        $('#catatan').show();
                    }
                    else{
                        $('#penanganan').hide();
                        $('#catatan').hide();
                    }
                });
            </script>
        </div>
        <div id="main-admin" class="dynamic-content">
            <div class="container-fluid">
                <table>
                    <tr>
                        <td>
                            <h1 style="font-size:20pt">Data Admin</h1>
                            <br />
                            <button class="btn btn-success" onclick="add_admin()"><i class="glyphicon glyphicon-plus"></i> Tambah Akun</button>
                            <button class="btn btn-default" onclick="reload_table_admin()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
                            <button class="btn btn-danger" onclick="bulk_delete_admin()"><i class="glyphicon glyphicon-trash"></i> Hapus Massal</button>
                            <br />
                            <br />
                            <table id="table-admin" class="table table-responsive table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="th1"><center><input type="checkbox" id="check-all"></th>
                                    <th class="th2"><center>Nama Akun</th>
                                    <th class="th2"><center>Nama Pelaksana</th>
                                    <th class="th3"><center>Role</th>
                                    <th class="th3"><center>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th><center>Nama Akun</th>
                                    <th><center>Nama Pelaksana</th>
                                    <th><center>Role</th>
                                    <th><center>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <script type="text/javascript">

                var save_method; //for save method string
                var table_admin;
                var base_url = '<?php echo base_url();?>';

                $(document).ready(function() {
                    //datatables
                    table_admin = $('#table-admin').DataTable({

                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.

                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": "<?php echo site_url('admin/ajax_list')?>",
                            "type": "POST"
                        },

                        //Set column definition initialisation properties.
                        "columnDefs": [
                            {
                                "targets": [ 0 ], //first column
                                "orderable": false, //set not orderable
                            },
                            {
                                "targets": [ -1 ], //last column
                                "orderable": false, //set not orderable
                            },
                        ],
                    });

                    //set input/textarea/select event when change value, remove class error and remove text help block
                    $("input").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });
                    $("select").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });

                    //check all
                    $("#check-all").click(function () {
                        $(".data-check").prop('checked', $(this).prop('checked'));
                    });
                });

                function add_admin() {
                    save_method = 'add';
                    $('#form_admin')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string
                    $('#username').attr('type','text');
                    $('#nama').attr('type','text');
                    $('#password').attr('type','password');
                    $('#confirm_password').attr('type','password');
                    $('#modal_admin').modal('show'); // show bootstrap modal
                    $('.modal-title').text('Tambah Data Admin'); // Set Title to Bootstrap modal title
                }

                function edit_admin(id) {
                    save_method = 'update';
                    $('#form_admin')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string

                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo site_url('admin/ajax_edit')?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_admin"]').val(data.id_admin);
                            $('[name="username"]').val(data.username);
                            $('[name="nama"]').val(data.nama);
                            $('[name="pass"]').val(data.password);
                            $('[name="confirm_pass"]').val(data.password);
                            $('#modal_admin').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Ubah Data Admin'); // Set title to Bootstrap modal title
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Mendapat Data Dari Ajax');
                        }
                    });
                }

                function reload_table_admin() {
                    table_admin.ajax.reload(null,false); //reload datatable ajax
                }

                function save_admin() {
                    $('#btnSaveAdmin').text('Menyimpan...'); //change button text
                    $('#btnSaveAdmin').attr('disabled',true); //set button disable
                    var url;

                    if(save_method == 'add') {
                        url = "<?php echo site_url('admin/ajax_add')?>";
                    } else {
                        url = "<?php echo site_url('admin/ajax_update')?>";
                    }

                    // ajax adding data to database
                    var formData = new FormData($('#form_admin')[0]);
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data)
                        {

                            if(data.status) //if success close modal and reload ajax table
                            {
                                $('#modal_admin').modal('hide');
                                reload_table_admin();
                            }
                            else
                            {
                                for (var i = 0; i < data.inputerror.length; i++)
                                {
                                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                                }
                            }
                            $('#btnSaveAdmin').text('Simpan'); //change button text
                            $('#btnSaveAdmin').attr('disabled',false); //set button enable


                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error adding / update data');
                            $('#btnSaveAdmin').text('Simpan'); //change button text
                            $('#btnSaveAdmin').attr('disabled',false); //set button enable

                        }
                    });
                }

                function delete_admin(id) {
                    if(confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?'))
                    {
                        // ajax delete data to database
                        $.ajax({
                            url : "<?php echo site_url('admin/ajax_delete')?>/"+id,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                //if success reload ajax table
                                $('#modal_admin').modal('hide');
                                reload_table_admin();
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error Menghapus Data');
                            }
                        });

                    }
                }

                function bulk_delete_admin() {
                    var list_id = [];
                    $(".data-check:checked").each(function() {
                        list_id.push(this.value);
                    });
                    if(list_id.length > 0)
                    {
                        if(confirm('Apakah Anda Yakin Ingin Menghapus '+list_id.length+' Data Ini ?'))
                        {
                            $.ajax({
                                type: "POST",
                                data: {id:list_id},
                                url: "<?php echo site_url('admin/ajax_bulk_delete')?>",
                                dataType: "JSON",
                                success: function(data)
                                {
                                    if(data.status)
                                    {
                                        reload_table_admin();
                                    }
                                    else
                                    {
                                        alert('Gagal.');
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    alert('Error Menghapus Data');
                                }
                            });
                        }
                    }
                    else
                    {
                        alert('Tidak Ada Data Yang Dipilih');
                    }
                }

            </script>
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_admin" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Form Akun</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form_admin" class="form-horizontal">
                                <input type="hidden" value="" name="id_admin"/>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama Akun</label>
                                        <div class="col-md-9">
                                            <input name="username" id="username" placeholder="Nama Akun" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama Pelaksana</label>
                                        <div class="col-md-9">
                                            <input name="nama" id="nama" placeholder="Nama Pengguna" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Kata Sandi</label>
                                        <div class="col-md-9">
                                            <input name="pass" id="password" placeholder="********" class="form-control" type="password">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Konfirmasi Kata Sandi</label>
                                        <div class="col-md-9">
                                            <input name="confirm_pass" id="confirm_password" placeholder="*********" class="form-control" type="password">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSaveAdmin" onclick="save_admin()" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->
        </div>
        <div id="main-user" class="dynamic-content">
            <div class="container-fluid">
                <table>
                    <tr>
                        <td>
                            <h1 style="font-size:20pt">Data User</h1>
                            <br />
                            <button class="btn btn-success" onclick="add_user()"><i class="glyphicon glyphicon-plus"></i> Tambah Akun</button>
                            <button class="btn btn-default" onclick="reload_table_user()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
                            <button class="btn btn-danger" onclick="bulk_delete_user()"><i class="glyphicon glyphicon-trash"></i> Hapus Massal</button>
                            <br />
                            <br />
                            <table id="table-user" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="th1"><center><input type="checkbox" id="check-all-user"></th>
                                    <th class="th2"><center>Alamat IP</th>
                                    <th class="th2"><center>Nama User</th>
                                    <th class="th3"><center>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th><center>Alamat IP</th>
                                    <th><center>Nama User</th>
                                    <th><center>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <script type="text/javascript">

                var save_method; //for save method string
                var table_user;
                var base_url = '<?php echo base_url();?>';

                $(document).ready(function() {
                    //datatables
                    table_user = $('#table-user').DataTable({

                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.

                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": "<?php echo site_url('user/ajax_list')?>",
                            "type": "POST"
                        },

                        //Set column definition initialisation properties.
                        "columnDefs": [
                            {
                                "targets": [ 0 ], //first column
                                "orderable": false, //set not orderable
                            },
                            {
                                "targets": [ -1 ], //last column
                                "orderable": false, //set not orderable
                            },
                        ],
                    });

                    //set input/textarea/select event when change value, remove class error and remove text help block
                    $("input").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });
                    $("select").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });

                    //check all
                    $("#check-all-user").click(function () {
                        $(".data-check-user").prop('checked', $(this).prop('checked'));
                    });
                });

                function add_user() {
                    save_method = 'add';
                    $('#form_user')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string
                    $('#alamat-ip').attr('type','text');
                    $('#nama-user').attr('type','text');
                    $('#modal_user').modal('show'); // show bootstrap modal
                    $('.modal-title').text('Tambah Data User'); // Set Title to Bootstrap modal title
                }

                function edit_user(id) {
                    save_method = 'update';
                    $('#form_user')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string

                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo site_url('user/ajax_edit')?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_user"]').val(data.id_user);
                            $('[name="alamat-ip"]').val(data.alamat_ip);
                            $('[name="nama-user"]').val(data.nama);
                            $('#modal_user').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Ubah Data User'); // Set title to Bootstrap modal title
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Mendapat Data Dari Ajax');
                        }
                    });
                }

                function reload_table_user() {
                    table_user.ajax.reload(null,false); //reload datatable ajax
                }

                function save_user() {
                    $('#btnSaveUser').text('Menyimpan...'); //change button text
                    $('#btnSaveUser').attr('disabled',true); //set button disable
                    var url;

                    if(save_method == 'add') {
                        url = "<?php echo site_url('user/ajax_add')?>";
                    } else {
                        url = "<?php echo site_url('user/ajax_update')?>";
                    }

                    // ajax adding data to database
                    var formData = new FormData($('#form_user')[0]);
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data)
                        {

                            if(data.status) //if success close modal and reload ajax table
                            {
                                $('#modal_user').modal('hide');
                                reload_table_user();
                            }
                            else
                            {
                                for (var i = 0; i < data.inputerror.length; i++)
                                {
                                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                                }
                            }
                            $('#btnSaveUser').text('Simpan'); //change button text
                            $('#btnSaveUser').attr('disabled',false); //set button enable


                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error adding / update data');
                            $('#btnSaveUser').text('Simpan'); //change button text
                            $('#btnSaveUser').attr('disabled',false); //set button enable

                        }
                    });
                }

                function delete_user(id) {
                    if(confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?'))
                    {
                        // ajax delete data to database
                        $.ajax({
                            url : "<?php echo site_url('user/ajax_delete')?>/"+id,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                //if success reload ajax table
                                $('#modal_user').modal('hide');
                                reload_table_user();
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error Menghapus Data');
                            }
                        });

                    }
                }

                function bulk_delete_user() {
                    var list_id = [];
                    $(".data-check-user:checked").each(function() {
                        list_id.push(this.value);
                    });
                    if(list_id.length > 0)
                    {
                        if(confirm('Apakah Anda Yakin Ingin Menghapus '+list_id.length+' Data Ini ?'))
                        {
                            $.ajax({
                                type: "POST",
                                data: {id:list_id},
                                url: "<?php echo site_url('user/ajax_bulk_delete')?>",
                                dataType: "JSON",
                                success: function(data)
                                {
                                    if(data.status)
                                    {
                                        reload_table_user();
                                    }
                                    else
                                    {
                                        alert('Gagal.');
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    alert('Error Menghapus Data');
                                }
                            });
                        }
                    }
                    else
                    {
                        alert('Tidak Ada Data Yang Dipilih');
                    }
                }

            </script>
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_user" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Form Akun</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form_user" class="form-horizontal">
                                <input type="hidden" value="" name="id_user"/>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Alamat IP</label>
                                        <div class="col-md-9">
                                            <input name="alamat-ip" id="alamat-ip" placeholder="Alamat IP" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama User</label>
                                        <div class="col-md-9">
                                            <input name="nama-user" id="nama-user" placeholder="Nama Pengguna" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSaveUser" onclick="save_user()" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->
        </div>
        <div id="main-status" class="dynamic-content">
            <div class="container-fluid">
                <table>
                    <tr>
                        <td>
                            <h1 style="font-size:20pt">Data Status Keluhan</h1>
                            <br />
                            <button class="btn btn-success" onclick="add_status()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
                            <button class="btn btn-default" onclick="reload_table_status()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
                            <button class="btn btn-danger" onclick="bulk_delete_status()"><i class="glyphicon glyphicon-trash"></i> Hapus Massal</button>
                            <br />
                            <br />
                            <table id="table-status" class="table table-striped table-bordered" cellspacing="0" width="100%" style="table-layout: fixed">
                                <thead>
                                <tr>
                                    <th class="th1"><center><input type="checkbox" id="check-all"></th>
                                    <th class="th2"><center>Nama Status Keluhan</th>
                                    <th class="th3"><center>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th><center>Nama Status Keluhan</th>
                                    <th><center>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <script type="text/javascript">

                var save_method; //for save method string
                var table_status;
                var base_url = '<?php echo base_url();?>';

                $(document).ready(function() {
                    //datatables
                    table_status = $('#table-status').DataTable({

                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.

                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": "<?php echo site_url('status/ajax_list')?>",
                            "type": "POST"
                        },

                        //Set column definition initialisation properties.
                        "columnDefs": [
                            {
                                "targets": [ 0 ], //first column
                                "orderable": false, //set not orderable
                            },
                            {
                                "targets": [ -1 ], //last column
                                "orderable": false, //set not orderable
                            },
                        ],
                    });

                    //set input/textarea/select event when change value, remove class error and remove text help block
                    $("input").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });
                    $("select").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });

                    //check all
                    $("#check-all-status").click(function () {
                        $(".data-check-status").prop('checked', $(this).prop('checked'));
                    });
                });

                function add_status() {
                    save_method = 'add';
                    $('#form_status')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string
                    $('#status').attr('type','text');
                    $('#modal_status').modal('show'); // show bootstrap modal
                    $('.modal-title').text('Tambah Data Kategori'); // Set Title to Bootstrap modal title
                }

                function edit_status(id) {
                    save_method = 'update';
                    $('#form_status')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string

                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo site_url('status/ajax_edit')?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_status"]').val(data.id_status);
                            $('[name="status"]').val(data.nama_status);
                            $('#modal_status').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Ubah Data Status'); // Set title to Bootstrap modal title
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Mendapat Data Dari Ajax');
                        }
                    });
                }

                function reload_table_status() {
                    table_status.ajax.reload(null,false); //reload datatable ajax
                }

                function save_status() {
                    $('#btnSaveStatus').text('Menyimpan...'); //change button text
                    $('#btnSaveStatus').attr('disabled',true); //set button disable
                    var url;

                    if(save_method == 'add') {
                        url = "<?php echo site_url('status/ajax_add')?>";
                    } else {
                        url = "<?php echo site_url('status/ajax_update')?>";
                    }

                    // ajax adding data to database
                    var formData = new FormData($('#form_status')[0]);
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data)
                        {

                            if(data.status) //if success close modal and reload ajax table
                            {
                                $('#modal_status').modal('hide');
                                reload_table_status();
                            }
                            else
                            {
                                for (var i = 0; i < data.inputerror.length; i++)
                                {
                                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                                }
                            }
                            $('#btnSaveStatus').text('Simpan'); //change button text
                            $('#btnSaveStatus').attr('disabled',false); //set button enable


                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error adding / update data');
                            $('#btnSaveStatus').text('Simpan'); //change button text
                            $('#btnSaveStatus').attr('disabled',false); //set button enable

                        }
                    });
                }

                function delete_status(id) {
                    if(confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?'))
                    {
                        // ajax delete data to database
                        $.ajax({
                            url : "<?php echo site_url('status/ajax_delete')?>/"+id,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                //if success reload ajax table
                                $('#modal_status').modal('hide');
                                reload_table_status();
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error Menghapus Data');
                            }
                        });

                    }
                }

                function bulk_delete_status() {
                    var list_id = [];
                    $(".data-check-status:checked").each(function() {
                        list_id.push(this.value);
                    });
                    if(list_id.length > 0)
                    {
                        if(confirm('Apakah Anda Yakin Ingin Menghapus '+list_id.length+' Data Ini ?'))
                        {
                            $.ajax({
                                type: "POST",
                                data: {id:list_id},
                                url: "<?php echo site_url('status/ajax_bulk_delete')?>",
                                dataType: "JSON",
                                success: function(data)
                                {
                                    if(data.status)
                                    {
                                        reload_table_status();
                                    }
                                    else
                                    {
                                        alert('Gagal.');
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    alert('Error Menghapus Data');
                                }
                            });
                        }
                    }
                    else
                    {
                        alert('Tidak Ada Data Yang Dipilih');
                    }
                }

            </script>
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_status" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Form Status</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form_status" class="form-horizontal">
                                <input type="hidden" value="" name="id_status"/>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama Status</label>
                                        <div class="col-md-9">
                                            <input name="status" id="status" placeholder="Nama Status" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSaveStatus" onclick="save_status()" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->
        </div>
        <div id="main-category" class="dynamic-content">
            <div class="container-fluid">
                <table>
                    <tr>
                        <td>
                            <h1 style="font-size:20pt">Data Kategori</h1>
                            <br />
                            <button class="btn btn-success" onclick="add_category()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
                            <button class="btn btn-default" onclick="reload_table_category()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
                            <button class="btn btn-danger" onclick="bulk_delete_category()"><i class="glyphicon glyphicon-trash"></i> Hapus Massal</button>
                            <br />
                            <br />
                            <table id="table-category" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="th1"><center><input type="checkbox" id="check-all-kategori"></th>
                                    <th class="th2"><center>Nama Kategori</th>
                                    <th class="th3"><center>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th><center>Nama Kategori</th>
                                    <th><center>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <script type="text/javascript">

                var save_method; //for save method string
                var table_category;
                var base_url = '<?php echo base_url();?>';

                $(document).ready(function() {
                    //datatables
                    table_category = $('#table-category').DataTable({

                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.

                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": "<?php echo site_url('category/ajax_list')?>",
                            "type": "POST"
                        },

                        //Set column definition initialisation properties.
                        "columnDefs": [
                            {
                                "targets": [ 0 ], //first column
                                "orderable": false, //set not orderable
                            },
                            {
                                "targets": [ -1 ], //last column
                                "orderable": false, //set not orderable
                            },
                        ],
                    });

                    //set input/textarea/select event when change value, remove class error and remove text help block
                    $("input").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });
                    $("select").change(function(){
                        $(this).parent().parent().removeClass('has-error');
                        $(this).next().empty();
                    });

                    //check all
                    $("#check-all-kategori").click(function () {
                        $(".data-check-kategori").prop('checked', $(this).prop('checked'));
                    });
                });

                function add_category() {
                    save_method = 'add';
                    $('#form_category')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string
                    $('#kategori').attr('type','text');
                    $('#modal_category').modal('show'); // show bootstrap modal
                    $('.modal-title').text('Tambah Data Kategori'); // Set Title to Bootstrap modal title
                }

                function edit_category(id) {
                    save_method = 'update';
                    $('#form_category')[0].reset(); // reset form on modals
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string

                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo site_url('category/ajax_edit')?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_category"]').val(data.id_category);
                            $('[name="kategori"]').val(data.kategori);
                            $('#modal_category').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Ubah Data Kategori'); // Set title to Bootstrap modal title
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Mendapat Data Dari Ajax');
                        }
                    });
                }

                function reload_table_category() {
                    table_category.ajax.reload(null,false); //reload datatable ajax
                }

                function save_category() {
                    $('#btnSaveCategory').text('Menyimpan...'); //change button text
                    $('#btnSaveCategory').attr('disabled',true); //set button disable
                    var url;

                    if(save_method == 'add') {
                        url = "<?php echo site_url('category/ajax_add')?>";
                    } else {
                        url = "<?php echo site_url('category/ajax_update')?>";
                    }

                    // ajax adding data to database
                    var formData = new FormData($('#form_category')[0]);
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data)
                        {

                            if(data.status) //if success close modal and reload ajax table
                            {
                                $('#modal_category').modal('hide');
                                reload_table_category();
                            }
                            else
                            {
                                for (var i = 0; i < data.inputerror.length; i++)
                                {
                                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                                }
                            }
                            $('#btnSaveCategory').text('Simpan'); //change button text
                            $('#btnSaveCategory').attr('disabled',false); //set button enable


                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error adding / update data');
                            $('#btnSaveCategory').text('Simpan'); //change button text
                            $('#btnSaveCategory').attr('disabled',false); //set button enable

                        }
                    });
                }

                function delete_category(id) {
                    if(confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?'))
                    {
                        // ajax delete data to database
                        $.ajax({
                            url : "<?php echo site_url('category/ajax_delete')?>/"+id,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                //if success reload ajax table
                                $('#modal_category').modal('hide');
                                reload_table_category();
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error Menghapus Data');
                            }
                        });

                    }
                }

                function bulk_delete_category() {
                    var list_id = [];
                    $(".data-check-kategori:checked").each(function() {
                        list_id.push(this.value);
                    });
                    if(list_id.length > 0)
                    {
                        if(confirm('Apakah Anda Yakin Ingin Menghapus '+list_id.length+' Data Ini ?'))
                        {
                            $.ajax({
                                type: "POST",
                                data: {id:list_id},
                                url: "<?php echo site_url('category/ajax_bulk_delete')?>",
                                dataType: "JSON",
                                success: function(data)
                                {
                                    if(data.status)
                                    {
                                        reload_table_category();
                                    }
                                    else
                                    {
                                        alert('Gagal.');
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    alert('Error Menghapus Data');
                                }
                            });
                        }
                    }
                    else
                    {
                        alert('Tidak Ada Data Yang Dipilih');
                    }
                }

            </script>
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_category" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Form Kategori</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form_category" class="form-horizontal">
                                <input type="hidden" value="" name="id_category"/>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Kategori</label>
                                        <div class="col-md-9">
                                            <input name="kategori" id="kategori" placeholder="Kategori" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSaveCategory" onclick="save_category()" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->
        </div>
    </div>
<?php
}
else if(isset($_SESSION['hak_akses'] ) && ($_SESSION['hak_akses'] == "user" || $_SESSION['hak_akses'] == "admin1")){
?>
    <div class="container-fluid">
        <div class="row">
            <br />
            <br />
            <div class="container-fluid">
                <button class="btn btn-success" onclick="add_ticket()"><i class="glyphicon glyphicon-plus"></i> New Ticket</button>
                <button class="btn btn-info" onclick="reload_table()"><i class="glyphicon glyphicon-repeat"></i> Reload Tabel</button>
            </div>
            <br />
            <br />
            <input hidden id="jumlah" value="<?php echo $jumlah?>"/>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div id="tabs">
                    <ul>
                        <?php
                        foreach ($status as $item){
                            echo "<li><a href='#".$item->nama_status."'>$item->nama_status </a></li>";
                        }
                        ?>
                    </ul>
                    <?php
                    $no=1;
                    foreach ($status as $item){
                        echo "<div id='$item->nama_status'>";
                        ?>
                        <table id="table<?php echo $no?>" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                            <thead>
                            <tr>
                                <th class="th1"><center>No</th>
                                <th class="th2"><center>Tanggal</th>
                                <th class="th4"><center>Keluhan</th>
                                <th class="th3"><center>Pelaksana</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="th1"><center>No</th>
                                <th class="th2"><center>Tanggal</th>
                                <th class="th4"><center>Keluhan</th>
                                <th class="th3"><center>Pelaksana</th>
                            </tr>
                            </tfoot>
                        </table>
                        <?php
                        echo "</div>";
                        $no++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_aksi" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Aksi Lanjutan</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form_aksi" class="form-horizontal">
                        <input type="hidden" value="" name="id_aksi"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Keluhan</label>
                                <div class="col-md-9">
                                    <textarea disabled class="form-control" rows="4" style="min-width: 100%" name="keluhan_aksi" id="keluhan_aksi" placeholder="Keluhan Anda"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Kategori</label>
                                <div class="col-md-9">
                                    <select id="aksi_kategori" name="aksi_kategori" class="form-control">
                                        <option value="">----</option>
                                        <?php
                                        foreach ($kategori as $option) {
                                            ?>
                                            <option value="<?php echo $option->id_category?>"><?php echo $option->kategori?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="label_aksi" class="form-group">
                                <label class="control-label col-md-3">Aksi</label>
                                <div class="col-md-9">
                                    <input type="hidden" id="status_filter" name="status_filter">
                                    <select id="aksi" name="aksi" class="form-control">
                                        <option value="">----</option>
                                        <?php
                                        foreach ($status_filter as $option) {
                                            ?>
                                            <option value="<?php echo $option->id_status ?>"><?php echo $option->nama_status ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="penanganan" class="form-group">
                                <label class="control-label col-md-3">Penanganan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" rows="4" style="min-width: 100%" name="penanganan_aksi" id="penanganan_aksi" placeholder="Penanganan Anda"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="catatan" class="form-group">
                                <label class="control-label col-md-3">Catatan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" rows="4" style="min-width: 100%" name="catatan_aksi" id="catatan_aksi" placeholder="Catatan Anda"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSaveAksi" onclick="save_aksi()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->

    <script type="text/javascript">
        var table = [];
        var jumlah = $('#jumlah').val();
        var id_status = [];
        var save_method; //for save method string

        $(document).ready(function() {
            var no = 0;
            id_status = <?php echo json_encode($status)?>;

            while(true){
                table[no] = $('#table'+(no+1)).DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo base_url('support/ajax_tabel')?>",
                        "type": "POST",
                        "data": {
                            "status": id_status[no]['id_status'],
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0,3 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ],
                });

                no++;
                if(no == jumlah)
                    break;
            }
        });

        function add_ticket() {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#keluhan').attr('type','textarea');
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Form Support Ticket'); // Set Title to Bootstrap modal title
        }

        function reload_table() {
            var jumlah = $('#jumlah').val();
            for(var i = 0;i < jumlah;i++ ){
                table[i].ajax.reload(null,false); //reload datatable ajax
            }
        }

        function save() {
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            var url;

            if(save_method == 'add') {
                url = "<?php echo site_url('support/ajax_add')?>";
            } else {
                url = "<?php echo site_url('support/ajax_update')?>";
            }

            // ajax adding data to database
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url : url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++)
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable

                }
            });
        }

        function informasi(data){
            $('#form_aksi')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('support/getDataPenanganan')?>/" + data,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id_aksi"]').val(data.id_transaksi);
                    $('[name="keluhan_aksi"]').val(data.keluhan);
                    $('#label_aksi').hide();
                    $('#catatan').show();
                    $('#penanganan').show();
                    $('#aksi_kategori').val(data.kategori).prop("disabled", true);
                    $('#btnSaveAksi').prop("disabled",true);
                    $('#catatan_aksi').val(data.catatan).show();
                    $('#penanganan_aksi').val(data.penanganan).show();
                    $('#catatan_aksi').val(data.catatan).prop("disabled", true);
                    $('#penanganan_aksi').val(data.penanganan).prop("disabled", true);
                    $('#modal_aksi').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Informasi'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error Mendapat Data Dari Ajax');
                }
            });
        }
    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form Pengaduan Keluhan</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Keluhan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" rows="4" style="min-width: 100%" name="keluhan" id="keluhan" placeholder="Keluhan Anda"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
<?php
}
else{
?>
    <div class="container-fluid">
        <h3>IP Milik Anda Tidak Berhak Untuk Mengakses Ke Halaman Ini...</h3>
        <h3>Silahkan Menghubungi Ke Tim IT Untuk Tindakan Lebih Lanjut...</h3>
        <h4>IP Anda : <?php echo $ip ?></h4>
    </div>
<?php
}
?>