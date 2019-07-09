<html>
<head>
    <title><?php echo $title ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/buttons.dataTables.min.css')?>" >


    <style>
        .topright {
            position: -webkit-sticky; /* Safari */
            position: sticky;
            top: 60px;
            right: 105px;
            padding:3px 3px 3px 3px;
        }
        .dynamic-content {
            display:none;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/transition.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/collapse.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.form.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/id.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/buttons.print.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jszip.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/vfs_fonts.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/buttons.html5.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/dataTables.buttons.min.js')?>"></script>
</head>
<header>
    <?php
        if(isset($_SESSION['hak_akses']) && ($_SESSION['hak_akses'] == 'admin')){
    ?>
            <script type="text/javascript">
                var myVar = setInterval(showNotifSupport, 3000);
                function showNotifSupport() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            if(xmlhttp.responseText != "0")
                                document.getElementById("notifSupport").innerHTML = "<a class='btn btn-danger' title='Support' onclick='notifikasi()'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                            else
                                document.getElementById("notifSupport").innerHTML = '';
                        }
                    };
                    xmlhttp.open("GET", "<?php echo base_url('main/cekNotifSupport') ?>" , true);
                    xmlhttp.send();
                }
            </script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#default-content').show("slow");
                });

                function changePage(page) {
                    if(page == 'user'){
                        $('#default-content').hide();
                        $('#main-status').hide();
                        $('#main-category').hide();
                        $('#main-admin').hide();
                        $('#main-user').show("slow");
                    }
                    else if(page == 'admin'){
                        $('#default-content').hide();
                        $('#main-status').hide();
                        $('#main-category').hide();
                        $('#main-admin').show("slow");
                        $('#main-user').hide();
                    }
                    else if(page == 'kategori'){
                        $('#default-content').hide();
                        $('#main-status').hide();
                        $('#main-category').show("slow");
                        $('#main-admin').hide();
                        $('#main-user').hide();
                    }
                    else if(page == 'status'){
                        $('#default-content').hide();
                        $('#main-status').show("slow");
                        $('#main-category').hide();
                        $('#main-admin').hide();
                        $('#main-user').hide();
                    }
                    else{
                        $('#default-content').show("slow");
                        $('#main-status').hide();
                        $('#main-category').hide();
                        $('#main-admin').hide();
                        $('#main-user').hide();
                    }
                }

                function notifikasi(){
                    changePage();
                    reload_table();
                }
            </script>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="<?php echo base_url();?>">Support Ticket</a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="javascript:void(0)" onclick="changePage()"><i class="glyphicon glyphicon-th"></i> Beranda</a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span></a>
                                    <ul class="dropdown-menu" hak_akses="menu">
                                        <li><a href="javascript:void(0)" onclick="changePage('user')">Data User</a></li>
                                        <li><a href="javascript:void(0)" onclick="changePage('admin')">Data Admin</a></li>
                                        <li><a href="javascript:void(0)" onclick="changePage('kategori')">Data Kategori</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="logout()"><i class="glyphicon glyphicon-log-out"></i> Log Out</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <br><span id="notifSupport" ></span>
                                </li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </nav>
    <?php
        }
        else if($this->session->userdata('hak_akses') == 'admin1'){
    ?>
            <script type="text/javascript">
                var myVar = setInterval(showNotifSupport, 3000);
                function showNotifSupport() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            if(xmlhttp.responseText != "0")
                                document.getElementById("notifSupport").innerHTML = "<a class='btn btn-danger' title='Support' onclick='notifikasi()'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                            else
                                document.getElementById("notifSupport").innerHTML = '';
                        }
                    };
                    xmlhttp.open("GET", "<?php echo base_url('main/cekNotifSupport') ?>" , true);
                    xmlhttp.send();
                }

                function notifikasi(){
                    reload_table();
                }
            </script>
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Support Ticket</a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <br><span id="notifSupport" ></span>
                                </li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </nav>
    <?php
        }
    ?>
</header>