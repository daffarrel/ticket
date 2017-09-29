<?php
/**
 * Created by PhpStorm.
 * User: fendykwan
 * Date: 9/28/17
 * Time: 1:27 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata('role' == "admin")){

}
else if($this->session->userdata('role' == "user")){
?>
    <script type="text/javascript">
        $(function() {
            $("#tabs").tabs({
                collapsible: false
            });
        });
    </script>
    <script type="text/javascript">

        var table = [];
        var status = "false";
        var jumlah;
        var tahun = [];

        $(document).ready(function() {

            //datatables
            jumlah = $('#jumlah').val();
            var no = 0;
            tahun = <?php echo json_encode($tahun); ?>;
            while(status = "false"){
                table = $('#table'+(no+1)).DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('main/ajax_list')?>",
                        "type": "POST",
                        "data": {
                            "tahun": tahun[no]['tahun']
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ],
                });

                no++;
                if(no == jumlah)
                    break;
            }

        });
    </script>
<?php
}
else{

}
?>