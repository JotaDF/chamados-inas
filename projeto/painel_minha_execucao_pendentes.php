<?php
//Execucao
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

        <title>Painel de execuções pendentes</title>

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
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script type="text/javascript" class="init">
            var duplicado = 0;
            $(document).ready(function () {
            });
            function excluir(id_prestador,id, informativo, competencia, usuario) {
                $('#delete').attr('href', 'remover_glosa_prestador.php?id_prestador='+id_prestador+'&id=' + id + '&id_usuario=' + usuario);
                $('#nome_excluir').text(competencia + " - " + informativo);
                $('#confirm').modal({show: true});
            }
            function excluirNota(id_prestador,id, numero, valor, exercicio,usuario) {
                $('#delete').attr('href', 'remover_nota_glosa.php?id_prestador='+id_prestador+'&id=' + id + '&id_usuario=' + usuario);
                $('#nome_excluir').text(numero + " - " + valor + " - " + exercicio);
                $('#confirm').modal({show: true});
            }
            function pagarNota(id_prestador,id_nota, numero, valor, exercicio,usuario) {
                $('#id_prestador_pg').val(id_prestador);
                $('#id_usuario_pg').val(usuario);
                $('#id_nota_pg').val(id_nota);
                $('#nome_pg').text("Nota: "+numero + " Valor: " + valor + " Exercício: " + exercicio);
                $('#pagar').modal({show: true});
            }
            function novaNota(id_recurso_glosa, carta_recursada, valor_original) {
                $('#id_recurso_glosa').val(id_recurso_glosa);
                $('#txt_carta_recursada').text(carta_recursada);
                $('#txt_valor_original').text(valor_original);
                $("#msg_nota").html("");
                $('#form_nota').collapse('show');  
            }

           function novaNotaInfo(id_nota_glosa, numero, lote, valor) {
                $('#id_nota_glosa').val(id_nota_glosa);
                $('#txt_numero').text(numero);
                $('#txt_lote').text(lote);
                $('#txt_valor').text(valor);
                 $("#msg_nota").html("");
                $('#form_nota_informativo').collapse('show');
           }

            function verificaNotaExiste(id_prestador) {
                duplicado = 0;
                var numero = $("#numero").val();
                var resp = getNotaBloolean(id_prestador, numero);
                if (duplicado > 0) {
                    $("#msg_nota").html("Esta Nota já existe para este prestador!");
                    return false;
                } else {
                    $("#msg_nota").html("");
                    return true;
                }
            }

            function getNotaBloolean(id_prestador,numero) {
                $.ajax({
                    type: 'post',
                    async: false,
                    url: 'verifica_nota_pagamento.php',
                    data:{
                        'id_prestador': id_prestador,
                        'numero': numero
                    },
                    success: function (data) {
                        duplicado = data;
                        return (data);
                    }
                });
            }

            function verificaInformativoExiste(id_prestador) {
                duplicado = 0;
                var informativo = $("#informativo").val();
                var resp = getInformativoBloolean(id_prestador, informativo);
                if (duplicado > 0) {
                    $("#msg_informativo").html("Este Informativo já existe para este prestador!");
                    return false;
                } else {
                    $("#msg_informativo").html("");
                    return true;
                }
            }
            function getInformativoBloolean(id_prestador,informativo) {
                $.ajax({
                    type: 'post',
                    async: false,
                    url: 'verifica_informativo_pagamento.php',
                    data:{
                        'informativo': informativo,
                        'id_prestador': id_prestador
                    },
                    success: function (data) {
                        duplicado = data;
                        return (data);
                    }
                });
            }


            const mascaraMoeda = (event) => {
            const onlyDigits = event.target.value
                .split("")
                .filter(s => /\d/.test(s))
                .join("")
                .padStart(3, "0")
            const digitsFloat = onlyDigits.slice(0, -2) + "." + onlyDigits.slice(-2)
            event.target.value = maskCurrency(digitsFloat)
            }

            const maskCurrency = (valor, locale = 'pt-BR', currency = 'BRL') => {
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency
            }).format(valor)
            }   

        </script>
        <style>
            body{
                font-size: small;
            }
        </style>
    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            <?php  include './menu_execucao.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php  include './top_bar.php'; ?>
                    <?php
                    include_once('actions/ManterPrestador.php');
                    include_once('actions/ManterNotaGlosa.php');
                    include_once('actions/ManterNotaPagamento.php');
                    
                    $manterNotaGlosa = new ManterNotaGlosa ();
                    $manterNotaPagamento = new ManterNotaPagamento ();
                    $manterPrestador = new ManterPrestador();   
                    
                    if ($usuario_logado->perfil >= 2) {
                        ?>

                        
                        <div class="card mb-4 ml-2 border-primary" style="max-width:1500px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-check-square fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Execuções pendentes</span>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">PPROCESSO MÃE</th>
                                            <th scope="col">CNPJ</th>
                                            <th scope="col">RAZÃO SOCIAL</th>          
                                            <th scope="col">NF</th> 
                                            <th scope="col">VALOR</th>
                                            <th scope="col">EXERCÍCIO</th> 
                                            <th scope="col">EMISSÃO</th>
                                            <th scope="col">VALIDAÇÃO</th>
                                            <th scope="col">LIMITI PG</th>
                                            <th scope="col">STATUS</th>
                                            <th scope="col">EXECUTAR</th>
                                            <th scope="col">TIPO</th>
                                            <th scope="col">ATRASO</th>
                                            <th scope="col">SITUAÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="prestadores">
                                    <?php
                                            $tp = isset($_REQUEST['tp']) ? $_REQUEST['tp'] : 0;
                                            $prestadores    = $manterPrestador->listarPorExecutor($usuario_logado->id);

                                            $valor_original = 0;
                                            $out_notas = "";
                                            foreach ($prestadores as $p) {
                                                $executor = $manterPrestador->getExecutorPorId($p->id, $usuario_logado->id);
                                                $editar = false;
                                                if ($executor->editor == 1 || $usuario_logado->perfil <= 2) {
                                                    $editar = true;
                                                }

                                                $mostrar = true;
                                                if ($tp == 2 && $editar) {
                                                    $mostrar = false;
                                                } else if ($tp == 1 && !$editar) {
                                                    $mostrar = false;
                                                }
                                                if ($mostrar) {
                                                    $notas_pagamento = $manterNotaPagamento->getExecucaoPentendesPrestador($p->id);
                                                    $notas_glosa = $manterNotaGlosa->getExecucaoPentendesPrestador($p->id);

                                                    foreach ($notas_pagamento as $np) {
                                                        $vln = str_replace("R$","",$np->valor);
                                                        $vln= str_replace(" ","",$vln); 
                                                        $vln= str_replace(".","",$vln);
                                                        $vln= str_replace(",",".",$vln); 
                                                        
                                                        $out_notas .= "<tr>";
                                                        $out_notas .= "  <td>".$p->processo_sei."</td>";
                                                        $out_notas .= "  <td>".$p->cnpj."</td>";
                                                        $out_notas .= "  <td>".$p->razao_social."</td>";
                                                        $out_notas .= "  <td>".$np->numero."</td>";
                                                        $out_notas .= "  <td>".$np->valor."</td>";
                                                        $out_notas .= "  <td>".$np->exercicio."</td>";
                                                        $out_notas .= "  <td>".date('d/m/Y', $np->data_emissao)."</td>";
                                                        $out_notas .= "  <td>".date('d/m/Y', $np->data_validacao)."</td>";
                                                        $out_notas .= "  <td>".date('d/m/Y', strtotime('+30 days', $np->data_validacao))."</td>";
                                                        $out_notas .= "  <td><b>".$np->status."</b></td>";
                                                        $btn_nt_executar = " - ";
                                                        if($editar){
                                                            $btn_nt_executar = "<a class='btn btn-primary btn-sm' title='Executar nota!' href='executar_nota_pagamento.php?painel=1&id_prestador=".$p->id."&id=".$np->id."&id_usuario=".$usuario_logado->id."'><i class='fa fa-play'></i></a>";
                                                        }
                                                        $out_notas .= "  <td><b>".$btn_nt_executar."</b></td>";
                                                        $out_notas .= "  <td class='text-primary'> Nota Pag. </td>";

                                                        $hoje = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
                                                        $dias = ($hoje - strtotime('+30 days', $np->data_validacao))/(60*60*24);
                                                        $out_notas .= "  <td>".$dias."</td>";
                                                        $txt_situacao = "NO PRAZO";
                                                        if($dias > 0){
                                                            $txt_situacao = "EM ATRASO";
                                                        }
                                                        $out_notas .= "  <td> ".$txt_situacao ." </td>";
                                                        $out_notas .= "</tr>";
                                                    }
                                                    foreach ($notas_glosa as $np) {
                                                        $vln = str_replace("R$","",$np->valor);
                                                        $vln= str_replace(" ","",$vln); 
                                                        $vln= str_replace(".","",$vln);
                                                        $vln= str_replace(",",".",$vln); 
                                                        
                                                        $out_notas .= "<tr>";
                                                        $out_notas .= "  <td>".$p->processo_sei."</td>";
                                                        $out_notas .= "  <td>".$p->cnpj."</td>";
                                                        $out_notas .= "  <td>".$p->razao_social."</td>";
                                                        $out_notas .= "  <td>".$np->numero."</td>";
                                                        $out_notas .= "  <td>".$np->valor."</td>";
                                                        $out_notas .= "  <td>".$np->exercicio."</td>";
                                                        $out_notas .= "  <td>".date('d/m/Y', $np->data_emissao)."</td>";
                                                        $out_notas .= "  <td>".date('d/m/Y', $np->data_validacao)."</td>";
                                                        $out_notas .= "  <td>".date('d/m/Y', strtotime('+30 days', $np->data_validacao))."</td>";
                                                        $out_notas .= "  <td><b>".$np->status."</b></td>";
                                                        $btn_nt_executar = " - ";
                                                        if($editar){
                                                            $btn_nt_executar = "<a class='btn btn-primary btn-sm' title='Executar nota!' href='executar_nota_glosa.php?painel=1&id_prestador=".$p->id."&id=".$np->id."&id_usuario=".$usuario_logado->id."'><i class='fa fa-play'></i></a>";
                                                        }
                                                        $out_notas .= "  <td><b>".$btn_nt_executar."</b></td>";                                         
                                                        $out_notas .= "  <td class='text-danger'> Nota Glosa </td>";
                                                        $hoje = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
                                                        $dias = ($hoje - strtotime('+30 days', $np->data_validacao))/(60*60*24);
                                                        $out_notas .= "  <td>".$dias."</td>";
                                                        $txt_situacao = "NO PRAZO";
                                                        if($dias > 0){
                                                            $txt_situacao = "EM ATRASO";
                                                        }
                                                        $out_notas .= "  <td> ".$txt_situacao ." </td>";
                                                        $out_notas .= "</tr>";
                                                    }
                                                }
                                            }
                                            echo $out_notas;
                                           ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    }
                        ?>
                    <!-- End of Main Content -->

                </div>
                <?php include './rodape.php'; ?>

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Modal pagamento -->
        <div class="modal fade" id="pagar" role="dialog">
            <div class="modal-dialog modal-sm">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Pagamento de Nota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form id="form_cadastro" action="pagar_nota_glosa.php" method="post">
                        <input type="hidden" id="id_nota_pg" name="id_nota"/>
                        <input type="hidden" id="id_usuario_pg" name="id_usuario"/>
                        <input type="hidden" id="id_prestador_pg" name="id_prestador"/>
                        <div class="form-row">
                        <p><strong><span id="nome_pg"></span></strong></p>
                            <div class="form-group">
                            <label for="data_pagamento">Data de pagamento:<span class="text-danger font-weight-bold">*</span></label>
                            <input type="date" name="data_pagamento" class="form-control form-control-sm" id="data_pagamento" required>
                            </div>     
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning" id="pagar">Pagar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal excluir -->
        <div class="modal fade" id="confirm" role="dialog">
            <div class="modal-dialog modal-sm">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja excluir <strong>"<span id="nome_excluir"></span>"</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-danger" id="delete">Excluir</a>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>

            </div>
        </div>

    </body>

</html>
