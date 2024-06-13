<?php
require_once('./verifica_login.php');
?> 
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Relatório de avaliação</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="favicon.ico" />
        <!------ Include the above in your HEAD tag ---------->

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>

        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>


        <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.min.js"></script>

        <style>
            body{
                font-size: small;
            }
            .nao-ver{
                display:none;
            }
        </style>
    </head>

    <body id="page-top">
    <!-- Begin Page Content -->
    <div id="containerEnquete" class="container-fluid align-items-center" style="width:95%">
    <div class="row text-center">
     <h3>RESULTADO ENQUETE</h3>
    </div>
    <div class="row">
        <?php
        include_once('actions/ManterEnquete.php');

        $mEnquete = new ManterEnquete();

        $id = $_REQUEST['id'];

        $enquete = $mEnquete->getEnquetePorId($id);
        $opcoes = $mEnquete->getOpcoesEnquete($enquete->id);
        $total_votos = $mEnquete->getTotalVotosEnquete();

        ?>
        <!-- Project Card Example -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?=$enquete->descricao . "(" . $total_votos .")" ?></h6>
                </div>
                <div class="card-body">
        <?php
        $cores = array('primary', 'success', 'danger', 'warning', 'info', 'secondary', 'dark');
        $cont = 0;
        foreach ($opcoes as $obj) {
            $total_opcao = $mEnquete->getTotalVotosPorOpcao($enquete->id,$obj->id);
            $p_opcao = (($total_opcao * 100) / $total_votos);
            ?>
            <h4 class="small font-weight-bold"><?=$obj->opcao ?><span class="float-right"><?=$p_opcao ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-<?=$cores[$cont] ?>" role="progressbar" style="width: <?=$p_opcao ?>%"
                        aria-valuenow="<?=$p_opcao ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
        <?php
            $cont++;
        }
        ?>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</body>

</html>
