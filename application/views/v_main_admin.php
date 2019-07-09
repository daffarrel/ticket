<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata('hak_akses') == 'admin1'){
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
            width: 10% !important;
        }
    </style>
    <div class="container-fluid">
        <div id="default-content">
            <div class="container-fluid">
                <br>
                <br>
                <br/>
                <button class="btn btn-info" onclick="login()"><i class="glyphicon glyphicon-log-in"></i> Login</button>
                <button class="btn btn-info" onclick="reload_table()"><i class="glyphicon glyphicon-repeat"></i> Reload Tabel</button>
                <br />
                <br />
                <input hidden id="jumlah" value="<?php echo $jumlah?>"/>
                <div id="tabs">
                    <ul>
                        <?php
                        $no=1;
                        foreach ($status as $item){
                            if($no > 1 )
                                break;
                            echo "<li><a href='#".$item->nama_status."'>$item->nama_status </a></li>";
                            $no++;
                        }
                        ?>
                    </ul>
                    <?php
                    $no=1;
                    foreach ($status as $item){
                        if($no > 1 )
                            break;
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
                                <th class="th3"><center>Pelaksana</th>
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

                function reload_table() {
                    var jumlah = $('#jumlah').val();
                    for(var i = 0;i < jumlah;i++ ){
                        table[i].ajax.reload(null,false); //reload datatable ajax
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
                
                function login() {
                    window.location = base_url+"admin/login";
                }
            </script>
        </div>
    </div>
<?php
} else{

    redirect('main');
}