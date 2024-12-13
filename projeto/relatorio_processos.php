<?php
//Jurídico
$mod = 6;
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

        <title>Relatório de processos</title>

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
                    let table = $("#inscritos");
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

        <?php
        include_once('actions/ManterProcesso.php');

        $mProcesso = new ManterProcesso();

        $ano = $_REQUEST['ano'];
        $assuntos = $mProcesso->relatorioTotalPorAssunto($ano);
        $totais = $mProcesso->relatorioTotais($ano);
        ?>
        <!-- Begin Page Content -->
        <div id="containerProcesso" class="container-fluid align-items-center" style="width:95%">
            <!-- Content Row -->
            <div id="totaisProcesso" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Total de processos</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
            Ano: <b><?=$ano ?></b><br/>
            Total de processos: <b><?=$totais->total_processos ?></b><br/>
            Total de processos com liminares deferidas: <b><?=$totais->total_deferido ?></b><br/>
            Total de processo com liminares indeferidas: <b><?=$totais->total_indeferido ?></b><br/>
            Total de processos arquivados: <b><?=$totais->total_arquivado ?></b><br/>
            Total de processos com pedido de dano moral: <b><?=$totais->total_danos_moraes ?></b><br/>
            </div>
            <?php
            if (count($assuntos) > 0) {
                ?>

            <div id="containerProcesso" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Total de processos por assunto</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="inscritos">
                        <tr class="thead-dark">
                            <th class="header c0 text-nowrap text-center" style="" scope="col">ID </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col"> ASUNTO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"> TOTAL </th>
                        </tr>
                        <?php
                        foreach ($assuntos as $obj) {
                            ?>
                            <tr class="">
                                <td class="cell c0 text-dark " style=""><?= $obj->id ?></td>
                                <td class="cell c1 text-dark " style=""><?= strtoupper($obj->assunto) ?></td>
                                <td class="cell c2 text-dark " style=""><?= $obj->total ?></td>                         
                            </tr>   
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>  
                <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</body>

</html>
