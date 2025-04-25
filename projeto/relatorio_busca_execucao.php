<?php
$mod = 10;
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

        <title>GERENTE - Gerenciador de atendimentos</title>

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
                    let table = $("#registros");
                    TableToExcel.convert(table[0], {// html code may contain multiple tables so here we are refering to 1st table tag
                        name: 'relatorio_execucao.xlsx', // fileName you could use any name
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
        include_once('actions/ManterCartaRecursada.php');
        include_once('actions/ManterCartaRecurso.php');
        include_once('actions/ManterNotaGlosa.php');
        include_once('actions/ManterNotaPagamento.php');
         $mCartaRecurso = new ManterCartaRecurso();
         $mNotaPagamento= new ManterNotaPagamento();
        $cnpj = isset($_POST['cnpj']) && $_POST['cnpj'] !== '' ? $_POST['cnpj'] : '';
        $informativo = isset($_POST['informativo'])   ? $_POST['informativo'] : '';
        $competencia = isset($_POST['competencia'])   ? $_POST['competencia'] : '';
        $nota_fiscal = isset($_POST['nota_fiscal'])   ? $_POST['nota_fiscal'] : '';
        $data_emissao = isset($_POST['data_emissao']) ? $_POST['data_emissao'] : '';
        $data = strtotime($data_emissao);
    
        $filtros_carta = [
            'pr.cnpj' => $cnpj,
            'cr.carta_informativo' => $informativo,
            'cr.competencia' => $competencia,
            'cr.data_emissao' => $data,
            'ng.numero' => $nota_fiscal
        ];
        $filtros_nota = [
            'pr.cnpj' => $cnpj,
            'p.informativo' => $informativo,
            'p.competencia' => $competencia,
            'np.data_emissao' => $data,
            'np.numero ' => $nota_fiscal  
        ];

        $where_carta = '';
        foreach ($filtros_carta as $campo => $valor) {
        if (!empty($valor)) {
            $where_carta .= " AND $campo = '" . $valor . "'";
        }
    }
        $where_nota = '';
        foreach ($filtros_nota as $campo => $valor) {
        if (!empty($valor)) {
            $where_nota .= " AND $campo = '" . $valor . "'";
        }
    }
        $carta = $mCartaRecurso->listarCartaPorFiltro($where_carta);
        $nota = $mNotaPagamento->listarNotaPorFiltro($where_nota);
        $total = array_merge($carta, $nota);
        ?>
        <div id="containerNotaGlosa" class="container-fluid align-items-center" style="width:95%">
            <?php
            if (count($total) > 0) {
                ?>

            <div id="containerNotaGlosa" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Relatório da Execução</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="registros">
                    <tr class="thead-dark">
                            <th class="header c0 text-nowrap text-center" style="" scope="col">TIPO</th>
                            <th class="header c0 text-nowrap text-center" style="" scope="col">STATUS </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col">CREDENCIADO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">CNPJ </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">NF </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">VALOR NF </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">INFORMATIVO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">COMPETENCIA </th> 
                            <th class="header c3 text-nowrap text-center" style="" scope="col">EMISSAO DA NF </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">DATA RECEBIMENTO </th>
                            <th class="header c5 text-nowrap text-center" style="" scope="col">DATA ATESTO </th>
                            <th class="header c6 lastcol text-nowrap text-center" style="" scope="col">FISCAL </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">DATA LIMITE PAGAMENTO </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">DATA PAGAMENTO </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">LINK SEI ORDEM BANCARIA </th>
                        </tr>
                        <?php
                            foreach ($total as $obj) {
                                $data_limite = strtotime("+30 day", $obj->data_validacao);
                                $data_executado = isset($obj->data_executado) ? date('d/m/Y', $obj->data_executado) : "-";
                                $data_atesto = isset($obj->data_atesto) ? date('d/m/Y', $obj->data_atesto) : "-";
                                $data_pagamento = isset($obj->data_pagamento) ? date('d/m/Y', $obj->data_pagamento) : "-";
                                $tipo = ($obj->tipo == 'carta') ? 'Carta' : "Nota";
                            ?>
                            <tbody>
                                <tr class=" ">
                                    <td class="cell c2 text-dark"><?= $tipo ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->status ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->razao_social ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->cnpj ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->numero ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->valor ?></td>
                                    <td class="cell c0 text-dark"><?= $obj->informativo ?></td>
                                    <td class="cell c0 text-dark"><?= $obj->competencia ?> </td> <!-- Está sem competencia pois no meu banco não está atualizado com a coluna competencia e, por motivos de desenvolvimento e debug, desenvolvi sem trazer a competencia mesmo. -->
                                    <td class="cell c2 text-dark"><?= date('d/m/Y', $obj->data_emissao) ?></td>
                                    <td class="cell c2 text-dark"><?= date('d/m/Y', $obj->data_validacao) ?></td>
                                    <td class="cell c2 text-dark"><?= $data_atesto ?></td>
                                    <td class="cell c2 text-dark"><?= $obj->nome ?></td>
                                    <td class="cell c2 text-dark"><?= date('d/m/Y', $data_limite) ?></td>
                                    <td class="cell c2 text-dark"><?= $data_pagamento ?></td>
                                    <td class="cell c3 text-dark"><?= $obj->doc_sei ?></td>
                                </tr>
                                <?php
                            }
                                ?>
                                </tbody>
                                </table>
                            <?php
            }
                        // } else if (count($carta) > 0) {
                            ?>
                    <!-- <div id="containerNotaGlosa" role="main" class="align-items-center" style="width:100%"><h2 class="text-center">Relatório da Execução: Nota Pagamento</h2><img src="img/iconexcel.png" width="30" height="30" class="d-print-none" id="btnExport" />
                    <table class="table table-striped" id="registros">
                        
                        <tr class="thead-dark">
                            <th class="header c0 text-nowrap text-center" style="" scope="col">STATUS </th>
                            <th class="header c1 text-nowrap text-center" style="" scope="col">CREDENCIADO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">CNPJ </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">NF </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">VALOR NF </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">INFORMATIVO </th>
                            <th class="header c2 text-nowrap text-center" style="" scope="col" style="width:50%">COMPETENCIA </th>
                            <th class="header c3 text-nowrap text-center" style="" scope="col">EMISSAO DA NF </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">DATA RECEBIMENTO </th>
                            <th class="header c5 text-nowrap text-center" style="" scope="col">DATA ATESTO </th>
                            <th class="header c6 lastcol text-nowrap text-center" style="" scope="col">FISCAL </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">DATA LIMITE PAGAMENTO </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">DATA PAGAMENTO </th>
                            <th class="header c4 text-nowrap text-center" style="" scope="col">LINK SEI ORDEM BANCARIA </th>
                        </tr>
                        
                        <?php

                            foreach ($nota_pagamento as $obj) {
                                $data_limite = strtotime("+30 day", $obj->data_validacao);
                                $data_atesto = isset($obj->data_atesto) ? date('d/m/Y', $obj->data_atesto) : "-";
                                $data_pagamento = isset($obj->data_pagamento) ? date('d/m/Y', $obj->data_pagamento) : "-";
                                ?>
                                <tbody>
                                   <tr class="">
                                       <td class="cell c2 text-dark " style=""><?= $obj->status ?></td>
                                       <td class="cell c2 text-dark " style=""><?= $obj->razao_social ?></td>
                                       <td class="cell c2 text-dark " style=""><?= $obj->cnpj ?></td>
                                       <td class="cell c2 text-dark " style=""><?= $obj->numero ?></td>
                                       <td class="cell c2 text-dark " style=""><?= $obj->valor ?></td>
                                       <td class="cell c0 text-dark " style=""><?= $obj->informativo ?></td>
                                       <td class="cell c0 text-dark " style=""><?= $obj->competencia ?></td>
                                       <td class="cell c2 text-dark " style=""><?= date('d/m/Y', $obj->data_emissao) ?></td>
                                       <td class="cell c2 text-dark " style=""><?= date('d/m/Y', $obj->data_validacao) ?></td>
                                       <td class="cell c2 text-dark " style=""><?= $obj->nome?></td>
                                       <td class="cell c2 text-dark " style=""><?= $data_atesto ?></td>
                                       <td class="cell c2 text-dark " style=""><?= date('d/m/Y', $data_limite) ?></td>
                                       <td class="cell c2 text-dark " style=""><?= $data_pagamento ?></td>
                                       <td class="cell c3 text-dark " style=""><?= $obj->doc_sei ?></td>
                                       </tr>
                                   <?php
                        }
                    
                        ?>
                        </tbody>
                    </table>
                </div>   -->
                <?php
            
            ?>
        </div>

</div>
<!-- /.container-fluid -->

</body>

</html>
