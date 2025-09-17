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

        <title>GERENTE - Gerenciador de chamados</title>

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
                    let table = $("#chamados");
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
        include_once('actions/ManterChamado.php');
        include_once('actions/ManterUsuario.php');
        include_once('actions/ManterCategoria.php');

        $mUsuario = new ManterUsuario();
        $mChamado = new ManterChamado();
        $mCategoria = new ManterCategoria();

        $inicio = isset($_REQUEST['inicio']) ? $_REQUEST['inicio'] : 0;
        $termino = isset($_REQUEST['termino']) ? $_REQUEST['termino'] : 0;

        $where = " ";
        $cont_param = 1;
        if ($inicio != 0) {
            if ($cont_param > 0) {
                $where .= " AND ";
            }
            $where .= " data_abertura >='" . $inicio . " 07:00'";
            $cont_param++;
        }
        if ($termino != 0) {
            if ($cont_param > 0) {
                $where .= " AND ";
            }
            $where .= " data_atendido <='" . $termino . " 19:00'";
            $cont_param++;
        }

        $chamados = array();
        if ($cont_param > 0) {
            $chamados = $mChamado->listar($where);
        } else {
            $chamados = $mChamado->listar();
        }
        ?>
        <!-- Begin Page Content -->
        <div id="containerChamado" class="container-fluid align-items-center" style="width:95%">
            <!-- Content Row -->

            <?php
            if (count($chamados) > 0) {
                ?>

            <div id="containerChamado" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Relatório de Chamados</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="chamados">
                        <tr class="thead-dark">
                            <th class="header c0 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c0" onclick="naover('c0');" aria-hidden="true" title="Remover coluna"></i> MATRÍCULA </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c1" onclick="naover('c1');" aria-hidden="true" title="Remover coluna"></i> NOME </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c2" onclick="naover('c2');" aria-hidden="true" title="Remover coluna"></i> CATEGORIA </th>
                            <th class="header c3 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c3" onclick="naover('c3');" aria-hidden="true" title="Remover coluna"></i> DESCRIÇAO </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c4" onclick="naover('c4');" aria-hidden="true" title="Remover coluna"></i> ABERTURA </th>
                            <th class="header c5 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c5" onclick="naover('c5');" aria-hidden="true" title="Remover coluna"></i> ATENDIDO </th>
                            <th class="header c6 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c6" onclick="naover('c6');" aria-hidden="true" title="Remover coluna"></i> TEMPO </th>
                            <th class="header c7 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c7" onclick="naover('c7');" aria-hidden="true" title="Remover coluna"></i> ATENDENTE </th>
                        </tr>
                        <?php
                        foreach ($chamados as $obj) {
                            $usuario = $mUsuario->getUsuarioPorId($obj->id_usuario);
                            $atendente = $mUsuario->getUsuarioPorId($obj->id_atendente);

                            ?>
                            <tr class="">
                                <td class="cell c0 text-dark " style=""><?= $usuario->matricula ?></td>
                                <td class="cell c1 text-dark " style=""><?= $usuario->nome ?></td>
                                <td class="cell c2 text-dark " style=""><?= $mCategoria->getCategoriaPorId($obj->categoria)->nome ?></td>
                                <td class="cell c3 text-dark " style=""><?= $obj->descricao ?></td>
                                <td class="cell c4 text-dark " style=""><?= date('d/m/Y h:i', strtotime($obj->data_abertura)) ?></td>
                                <td class="cell c5 text-dark " style=""><?= date('d/m/Y h:i', strtotime($obj->data_atendido)) ?></td>
                                <td class="cell c6 text-dark " style=""> - minutos</td>                                
                                <td class="cell c7 text-dark " style=""><?= $atendente->nome ?></td>                                
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
