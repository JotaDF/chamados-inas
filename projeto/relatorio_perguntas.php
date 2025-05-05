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
        <script type="text/javascript" class="init">
            function naover(classe) {
                $("." + classe).css("display", "none");
                //$('#btn_editar').toggleClass('fa-lock fa-unlock');
            }
            $(document).ready(function () {
                $("#btnExport").click(function () {
                    let table = $("#perguntas");
                    TableToExcel.convert(table[0], {// html code may contain multiple tables so here we are refering to 1st table tag
                        name: 'export.xlsx', // fileName you could use any name
                        sheet: {
                            name: 'Sheet 1' // sheetName
                        }
                    });
                });

                $("#btnPDF").click(function () {
                    savePDF();
                });

            });




        </script>
    </head>

    <body id="page-top">
    <!-- Begin Page Content -->
    <div id="containerPergunta" class="container-fluid align-items-center" style="width:95%">
    <div class="row text-center">
     <h4 style="width:100%">RELATÓRIO DAS AVALIAÇÕES</h4>
    </div>
    <div class="row">
        <?php
        include_once('actions/ManterPergunta.php');
        include_once('actions/ManterNota.php');

        $mPergunta = new ManterPergunta();
        $mNota = new ManterNota();

        $inicio = isset($_REQUEST['inicio']) ? $_REQUEST['inicio'] : 0;
        $termino = isset($_REQUEST['termino']) ? $_REQUEST['termino'] : 0;

        $where = " ";
        $cont_param = 1;
        if ($inicio != 0) {
            if ($cont_param > 0) {
                $where .= " AND ";
            }
            $where .= " n.hora_registro >='" . $inicio . " 07:00'";
            $cont_param++;
        }
        if ($termino != 0) {
            if ($cont_param > 0) {
                $where .= " AND ";
            }
            $where .= " n.hora_registro <='" . $termino . " 19:00'";
            $cont_param++;
        }

        $perguntas = array();
        $perguntas = $mPergunta->listar(" WHERE status=1");
        $count = 0;
        foreach ($perguntas as $obj) {
            $ediv = false;
            $nota1 = $mNota->listarRelatorio(" WHERE n.id_pergunta=" . $obj->id . $where . " AND n.nota = 1");
            $nota2 = $mNota->listarRelatorio(" WHERE n.id_pergunta=" . $obj->id . $where . " AND n.nota = 2");
            $nota3 = $mNota->listarRelatorio(" WHERE n.id_pergunta=" . $obj->id . $where . " AND n.nota = 3");
            $nota4 = $mNota->listarRelatorio(" WHERE n.id_pergunta=" . $obj->id . $where . " AND n.nota = 4");
            $nota5 = $mNota->listarRelatorio(" WHERE n.id_pergunta=" . $obj->id . $where . " AND n.nota = 5");

            $total = $nota1 + $nota2 + $nota3 + $nota4 + $nota5;
            $pnota1 = round(($nota1*100)/$total , 2);
            $pnota2 = round(($nota2*100)/$total , 2);
            $pnota3 = round(($nota3*100)/$total , 2);
            $pnota4 = round(($nota4*100)/$total , 2);
            $pnota5 = round(($nota5*100)/$total , 2);

        ?>

        <!-- Project Card Example -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?=$obj->descricao . "(" . $total .")" ?></h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">MUITO RUIM<span
                            class="float-right"><?=$pnota1 ?>%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?=$pnota1 ?>%"
                            aria-valuenow="<?=$pnota1 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">RUIM<span
                            class="float-right"><?=$pnota2 ?>%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?=$pnota2 ?>%"
                            aria-valuenow="<?=$pnota2 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">REGULAR<span
                            class="float-right"><?=$pnota3 ?>%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: <?=$pnota3 ?>%"
                            aria-valuenow="<?=$pnota3 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">BOM<span
                            class="float-right"><?=$pnota4 ?>%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?=$pnota4 ?>%"
                            aria-valuenow="<?=$pnota4 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">ÓTIMO<span
                            class="float-right"><?=$pnota5 ?>%</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?=$pnota5 ?>%"
                            aria-valuenow="<?=$pnota5 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Content Row -->

            <?php
        }
            /*
            if (count($perguntas) > 0) {
                ?>

            <div id="containerPergunta" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Relatório de Visitas</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="perguntas">
                        <tr class="thead-dark">
                            <th class="header c0 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c0" onclick="naover('c0');" aria-hidden="true" title="Remover coluna"></i> VISITANTE </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c1" onclick="naover('c1');" aria-hidden="true" title="Remover coluna"></i> ÓRGÃO/EMPRESA </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c2" onclick="naover('c2');" aria-hidden="true" title="Remover coluna"></i> SETOR </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c3" onclick="naover('c3');" aria-hidden="true" title="Remover coluna"></i> HORÁRIO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c4" onclick="naover('c4');" aria-hidden="true" title="Remover coluna"></i> ASSUNTO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c5" onclick="naover('c5');" aria-hidden="true" title="Remover coluna"></i> RECEBIDO POR </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c6" onclick="naover('c6');" aria-hidden="true" title="Remover coluna"></i> DATA </th>
                            <th class="header c3 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c7" onclick="naover('c7');" aria-hidden="true" title="Remover coluna"></i> USUÁRIO </th>
                        </tr>
                        <?php
                        foreach ($perguntas as $obj) {
                            ?>
                            <tr class="">
                                <td class="cell c0 text-dark " style=""><?= $obj->visitante ?></td>
                                <td class="cell c1 text-dark " style=""><?= $obj->empresa ?></td>
                                <td class="cell c2 text-dark " style=""><?= $obj->setor ?></td>
                                <td class="cell c3 text-dark " style=""><?= $obj->horario ?></td>
                                <td class="cell c4 text-dark " style=""><?= $obj->assunto ?></td>
                                <td class="cell c5 text-dark " style=""><?= $obj->recebido_por ?></td>
                                <td class="cell c6 text-dark " style=""><?= date('d/m/Y H:i', strtotime($obj->hora_registro)) ?></td>
                                <td class="cell c7 text-dark " style=""><?= $obj->usuario ?></td>                                
                            </tr>   
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>  
                <?php
            }
            */
            ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</body>

</html>
