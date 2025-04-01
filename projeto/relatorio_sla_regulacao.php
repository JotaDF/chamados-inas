<?php
$mod = 14;
require_once('./verifica_login.php');
include_once('actions/ManterSlaRegulacao.php');
$manterSlaRegulacao = new ManterSlaRegulacao(); 
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';
$autorizado = array();
$nao_autorizado = array();
$todos = array();
if ($filtro == "vazio") {
    header('Location: gerar_relatorio_sla.php?msg=1');
    exit();
} else if ($filtro == "autorizado") {
    $autorizado = $manterSlaRegulacao->getAutorizados();
} else if ($filtro == "nao_autorizado") {
    $nao_autorizado = $manterSlaRegulacao->getNaoAutorizados();
} else if ($filtro == "todos") {
    $todos = $manterSlaRegulacao->listarSlaRegulacaoTodas();
}
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Relatório SLA - REGULÇÃO</title>

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
        <script type="text/javascript" class="init">
    function naover(classe) {
        $("." + classe).css("display", "none");
        //$('#btn_editar').toggleClass('fa-lock fa-unlock');
    }
    $(document).ready(function () {
        $("#btnExport").click(function () {
            let table = $("#sla_regulacao");
            TableToExcel.convert(table[0], {// html code may contain multiple tables so here we are refering to 1st table tag
                name: 'relatorio_sla_regulacao.xlsx', // fileName you could use any name
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
        <style>
            body{
                font-size: small;
            }
            .nao-ver{
                display:none;
            }
        </style>
<div id="containerAutorizados" class="container-fluid align-items-center" style="width:95%">
            <?php
            if ($autorizado && count($autorizado) > 0) {
                ?>

            <div id="containerAutorizado" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Relatório de SLA - Regulação: Autorizados</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="sla_regulacao">
                    <tr class="thead-dark">
                    <th class="header c0 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c0" onclick="naover('c0');"  aria-hidden="true" title="Remover coluna"></i> AUTORIZAÇÃO </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c1" onclick="naover('c1');" aria-hidden="true" title="Remover coluna"></i> TIPO DE GUIA </th>
                            <th class="header c3 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c2" onclick="naover('c2');" aria-hidden="true" title="Remover coluna"></i> AREA </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c3" onclick="naover('c3');" aria-hidden="true" title="Remover coluna"></i> FILA </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c4" onclick="naover('c4');" aria-hidden="true" title="Remover coluna"></i> ENCAMINHAMENTO MANUAL </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c5" onclick="naover('c5');" aria-hidden="true" title="Remover coluna"></i> DATA DE SOLICITAÇÃO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c6" onclick="naover('c6');" aria-hidden="true" title="Remover coluna"></i> ATRASO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c7" onclick="naover('c7');" aria-hidden="true" title="Remover coluna"></i> AUTORIZADO </th>
                        </tr>
                        <?php
                            foreach ($autorizado as $obj) {
                                $encaminhamento_manual = ($obj->encaminhamento_manual == "1") ? "SIM" :  "NÃO";
                            ?>
                            <tbody>
                                <tr class=" ">
                                    <td class="cell c2 text-dark"><?= $obj->autorizacao ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->tipo_guia ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->area ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->fila ?></td>
                                    <td class="cell c2 text-dark"><?= $encaminhamento_manual?></td>
                                    <td class="cell c0 text-dark"><?= $obj->data_solicitacao_d ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->atraso ?></td>
                                    <td class="cell c3 text-dark"><?= $obj->autorizado ?></td>
                                </tr>
                                </tbody>
                            <?php
                        }
                        ?>
                                </table>
                                <?php
                        } else if ($nao_autorizado && count($nao_autorizado) > 0) {
                            ?>
                    <div id="containerAutorizados" class="container-fluid align-items-center" style="width:95%">
            <div id="containerAutorizado" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Relatório de SLA - Regulação: Não Autorizados</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="sla_regulacao">
                    <tr class="thead-dark">
                    <th class="header c0 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c0" onclick="naover('c0');"  aria-hidden="true" title="Remover coluna"></i> AUTORIZAÇÃO </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c1" onclick="naover('c1');" aria-hidden="true" title="Remover coluna"></i> TIPO DE GUIA </th>
                            <th class="header c3 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c2" onclick="naover('c2');" aria-hidden="true" title="Remover coluna"></i> AREA </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c3" onclick="naover('c3');" aria-hidden="true" title="Remover coluna"></i> FILA </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c4" onclick="naover('c4');" aria-hidden="true" title="Remover coluna"></i> ENCAMINHAMENTO MANUAL </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c5" onclick="naover('c5');" aria-hidden="true" title="Remover coluna"></i> DATA DE SOLICITAÇÃO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c6" onclick="naover('c6');" aria-hidden="true" title="Remover coluna"></i> ATRASO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c7" onclick="naover('c7');" aria-hidden="true" title="Remover coluna"></i> AUTORIZADO </th>
                        </tr>
                        <?php
                            foreach ($nao_autorizado as $obj) {
                                $encaminhamento_manual = ($obj->encaminhamento_manual == "1") ? "SIM" :  "NÃO";
                            ?>
                            <tbody>
                                <tr class=" ">
                                    <td class="cell c2 text-dark"><?= $obj->autorizacao ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->tipo_guia ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->area ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->fila ?></td>
                                    <td class="cell c2 text-dark"><?= $encaminhamento_manual?></td>
                                    <td class="cell c0 text-dark"><?= $obj->data_solicitacao_d ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->atraso ?></td>
                                    <td class="cell c3 text-dark"> - </td>
                                </tr>
                                </tbody>
                            <?php
                        }
                        ?>
                                </table>
                                <?php
                        } else if ($todos && count($todos) > 0) {
                        ?>
                          <div id="containerAutorizados" class="container-fluid align-items-center" style="width:95%">
            <div id="containerAutorizado" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Relatório de SLA - Regulação: Todas</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="sla_regulacao">
                    <tr class="thead-dark">
                    <th class="header c0 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c0" onclick="naover('c0');"  aria-hidden="true" title="Remover coluna"></i> AUTORIZAÇÃO </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c1" onclick="naover('c1');" aria-hidden="true" title="Remover coluna"></i> TIPO DE GUIA </th>
                            <th class="header c3 text-nowrap text-center" style="" scope="col"><i class="fa fa-minus-square text-white c2" onclick="naover('c2');" aria-hidden="true" title="Remover coluna"></i> AREA </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c3" onclick="naover('c3');" aria-hidden="true" title="Remover coluna"></i> FILA </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c4" onclick="naover('c4');" aria-hidden="true" title="Remover coluna"></i> ENCAMINHAMENTO MANUAL </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c5" onclick="naover('c5');" aria-hidden="true" title="Remover coluna"></i> DATA DE SOLICITAÇÃO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c6" onclick="naover('c6');" aria-hidden="true" title="Remover coluna"></i> ATRASO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%"><i class="fa fa-minus-square text-white c7" onclick="naover('c7');" aria-hidden="true" title="Remover coluna"></i> AUTORIZADO </th>
                        </tr>
                        <?php 
                        foreach($todos as $obj) {
                            $encaminhamento_manual = ($obj->encaminhamento_manual == "1") ? "SIM" :  "NÃO";
                            $autorizado = ($obj->autorizado == NULL) ? " NÃO AUTORIZADO " : $obj->autorizado;
                        ?>
                        <tbody>
                                <tr class=" ">
                                    <td class="cell c2 text-dark"><?= $obj->autorizacao ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->tipo_guia ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->area ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->fila ?></td>
                                    <td class="cell c2 text-dark"><?= $encaminhamento_manual?></td>
                                    <td class="cell c0 text-dark"><?= $obj->data_solicitacao_d ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->atraso ?></td>
                                    <td class="cell c3 text-dark"><?= $autorizado ?></td>
                                </tr>
                                </tbody>
                                <?php
                        }
                        }
                        ?>
                </div>  
                <?php
            
            ?>
        </div>

</div>
<!-- /.container-fluid -->

</body>

</html>
