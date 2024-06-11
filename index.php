<?php 

@session_start();

date_default_timezone_set('America/Sao_Paulo');

require_once("conexao.php");
require_once("config.php");

$data_atual = date('Y-m-d');


if(@$_GET['pag'] == ""){
	$pag = 'importar';
}else{
	$pag = $_GET['pag'];
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title><?php echo $nome_sistema ?></title>

    <link rel="icon" type="image/png" href="../img/icone_otologica.png">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    

    

    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <!-- font-awesome icons CSS -->
    <link href="css/font-awesome.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- //font-awesome icons CSS-->

    <!-- side nav css file -->
    <link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css' />
    <!-- //side nav css file -->

    <link rel="stylesheet" href="css/monthly.css">

    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/webfonts/fa-brands-400.ttf">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/webfonts/fa-regular-400.ttf">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/webfonts/fa-brands-400.woff2">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/webfonts/fa-regular-400.woff2">


    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/webfonts/fa-regular-400.woff2">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/webfonts/fa-regular-400.woff2">

    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
        integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <!--//webfonts-->

    <!-- chart -->
    <script src="js/Chart.js"></script>
    <!-- //chart -->

    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
    <style>
    #chartdiv {
        width: 100%;
        height: 295px;
    }
    </style>
    <!--pie-chart -->
    <!-- index page sales reviews visitors pie chart -->
    <script src="js/pie-chart.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#demo-pie-1').pieChart({
            barColor: '#2dde98',
            trackColor: '#eee',
            lineCap: 'round',
            lineWidth: 8,
            onStep: function(from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });

        $('#demo-pie-2').pieChart({
            barColor: '#8e43e7',
            trackColor: '#eee',
            lineCap: 'butt',
            lineWidth: 8,
            onStep: function(from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });

        $('#demo-pie-3').pieChart({
            barColor: '#ffc168',
            trackColor: '#eee',
            lineCap: 'square',
            lineWidth: 8,
            onStep: function(from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });


    });
    </script>
    <!-- //pie-chart -->
    <!-- index page sales reviews visitors pie chart -->


    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>


</head>

<body class="cbp-spmenu-push">
    <div class="main-content" style="padding:5px; margin: 0px;">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!--left-fixed -navigation-->
            <aside class="sidebar-left">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target=".collapse" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <h1><a class="navbar-brand" href="index.php"><span class="fas fa-laptop-medical"></span>
                                Sistema<span class="dashboard_text"><?php echo $nome_sistema ?></span></a></h1>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="sidebar-menu">
                            <li class="header">MENU DE NAVEGAÇÃO</li>


                            <li class="treeview">
                                <a href="index.php">
                                    <i class="fas fa-home"></i>
                                    <span>Home</span>
                                </a>
                            </li>



                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-file"></i>
                                    <span>Relatórios</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">

                                    <li><a href="index.php?pag=importar"><i class="fa fa-angle-right"></i>Exportar
                                            Tabelas</a>
                                    </li>


                                </ul>
                            </li>



                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </aside>
        </div>
        <!--left-fixed -navigation-->

        <!-- header-starts -->
        <div class="sticky-header header-section ">
            <div class="header-left">
                <!--toggle button start-->
                <a href="index.php">


                </a>
                <!--toggle button end-->
                <div class="profile_details_left">
                    <!--notifications of menu start -->
                    <ul class="nofitications-dropdown">


                    </ul>
                    <div class="clearfix"> </div>
                </div>
                <!--notification menu end -->
                <div class="clearfix"> </div>
            </div>
            <div class="header-right">




                <div class="profile_details">
                    <ul>
                        <li class="dropdown profile_details_drop">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <div class="profile_img">

                                    <div class="user-name">

                                    </div>
                                    <i class="fa fa-angle-down lnr"></i>
                                    <i class="fa fa-angle-up lnr"></i>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            <ul class="dropdown-menu drp-mnu">

                                <li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i
                                            class="fa fa-suitcase"></i> Editar Perfil</a> </li>
                                <li> <a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="clearfix"> </div>

        </div>
        <!-- //header-ends -->








        <!-- main content start-->
        <div id="page-wrapper">
            <?php require_once("paginas/".$pag.'.php') ?>
        </div>









        <!--footer-->
        <div class="footer">
            <p> Desenvolvidor Por JF Sistemas</p>
        </div>
        <!--//footer-->
    </div>


    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- side nav js -->
    <script src='js/SidebarNav.min.js' type='text/javascript'></script>
    <script>
    $('.sidebar-menu').SidebarNav()
    </script>
    <!-- //side nav js -->



    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
    <!-- //Bootstrap Core JavaScript -->

</body>

</html>





<!-- Mascaras JS -->
<script type="text/javascript" src="js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>




<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style type="text/css">
.select2-selection__rendered {
    line-height: 36px !important;
    font-size: 16px !important;
    color: #666666 !important;

}

.select2-selection {
    height: 36px !important;
    font-size: 16px !important;
    color: #666666 !important;

}
</style>


<!-- Modal Perfil-->
<div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Editar Perfil</h4>
                <button id="btn-fechar-perfil" type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="margin-top: -20px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form-perfil">
                <div class="modal-body">


                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="exampleInputEmail1">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="cpf"
                                    value="<?php echo $cpf_usuario ?>" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Senha</label>
                                <input type="text" class="form-control" id="senha" name="senha" placeholder="senha">
                            </div>
                        </div>


                    </div>

                    <input type="hidden" name="id" value="<?php echo $id_usuario ?>">

                    <br>
                    <small>
                        <div id="mensagem-perfil" align="center"></div>
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
$("#form-perfil").submit(function() {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: "editar-perfil.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {
            $('#mensagem-perfil').text('');
            $('#mensagem-perfil').removeClass()
            if (mensagem.trim() == "Editado com Sucesso") {

                $('#btn-fechar-perfil').click();
                location.reload();

            } else {

                $('#mensagem-perfil').addClass('text-danger')
                $('#mensagem-perfil').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>








<script type="text/javascript">
function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto-usu").files[0];

    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);

    } else {
        target.src = "";
    }
}
</script>







<script type="text/javascript">
$("#form-config").submit(function() {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: "editar-config.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {
            $('#mensagem-config').text('');
            $('#mensagem-config').removeClass()
            if (mensagem.trim() == "Editado com Sucesso") {

                $('#btn-fechar-config').click();
                location.reload();

            } else {

                $('#mensagem-config').addClass('text-danger')
                $('#mensagem-config').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>




<script type="text/javascript">
function carregarImgLogo() {
    var target = document.getElementById('target-logo');
    var file = document.querySelector("#foto-logo").files[0];

    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);

    } else {
        target.src = "";
    }
}
</script>





<script type="text/javascript">
function carregarImgLogoRel() {
    var target = document.getElementById('target-logo-rel');
    var file = document.querySelector("#foto-logo-rel").files[0];

    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);

    } else {
        target.src = "";
    }
}
</script>





<script type="text/javascript">
function carregarImgIcone() {
    var target = document.getElementById('target-icone');
    var file = document.querySelector("#foto-icone").files[0];

    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);

    } else {
        target.src = "";
    }
}
</script>