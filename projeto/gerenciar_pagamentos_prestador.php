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

        <title>Usuários - Gerenciador de acessos</title>

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
            function alterarInformativo(id, competencia, informativo, id_fiscal_prestador) {
                $('#id').val(id);
                $('#id_fiscal_prestador').val(id_fiscal_prestador);
                $('#competencia').val(competencia);
                $('#informativo').val(informativo);
                $('#txt_cadastro_informativo').text("Alterar pagamento: " + id);    
                $('#form_cadastro').removeAttr('onsubmit');  
                $('#competencia').focus();   
            }
            function excluir(id_prestador,id, informativo, competencia, usuario) {
                $('#delete').attr('href', 'remover_pagamento_prestador.php?id_prestador='+id_prestador+'&id=' + id + '&id_usuario=' + usuario);
                $('#nome_excluir').text(competencia + " - " + informativo);
                $('#confirm').modal({show: true});
            }
            function excluirNota(id_prestador,id, numero, valor, exercicio,usuario) {
                $('#delete').attr('href', 'remover_nota_pagamento.php?id_prestador='+id_prestador+'&id=' + id + '&id_usuario=' + usuario);
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
            function novaNota(id_pagamento, competencia, informativo) {
                $('#id_pagamento').val(id_pagamento);
                $('#txt_id_pagamento').text(id_pagamento);
                $('#txt_competencia').text(competencia);
                $('#txt_informativo').text(informativo);
                $("#msg_nota").html("");
                $('#form_nota').collapse('show');
            }
            function mostrarOcorrencias(id_nota,id_prestador) {
                var ocorrencias = $('#ocorrencia_'+id_nota).val();
                const vet_ocorrencias = ocorrencias.split("###");
                var txt_ocorrencia = "";
                var i = 0;
                for (const ocorrencia of vet_ocorrencias) {
                    if (ocorrencia != "") {
                    i++;
                    txt_ocorrencia += i+" - "+ ocorrencia + "<hr/>";
                    }
                }
                if (txt_ocorrencia != "") {
                    $("#txt_ocorrencias").html(txt_ocorrencia); 
                } else {
                    $("#txt_ocorrencias").html("Não existem ocorrências para essa nota!");
                }
                $('#link_ocorrencia').attr('href', 'gerenciar_ocorrencias_nota.php?id_prestador='+id_prestador+'&id='+id_nota+'&tp=1');
                $('#modal_ocorrencias').modal({show: true});
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
            <?php include './menu_execucao.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    <?php
                    include_once('actions/ManterPrestador.php');
                    include_once('actions/ManterTipoPrestador.php');
                    include_once('actions/ManterPagamento.php');
                    include_once('actions/ManterOcorrenciaNota.php');

                    $manterPrestador = new ManterPrestador();
                    $manterTipoPrestador = new ManterTipoPrestador();
                    $manterPagamento = new ManterPagamento();
                    $manterOcorrenciaNota = new ManterOcorrenciaNota();
                    

                    if (isset($_REQUEST['id'])) {
                        $id_prestador = $_REQUEST['id'];
                        $prestador    = $manterPrestador->getPrestadorPorId($id_prestador);
                        $pagamentos   = $manterPagamento->getPagamentosPorPrestador($id_prestador);
                        $executor = $manterPrestador->getExecutorPorId($id_prestador, $usuario_logado->id);
                        
                        $editar = false;
                        if ($executor->editor == 1 || $usuario_logado->perfil <=2) {
                            $editar = true;
                        }
                        ?>
                        <div class="container-fluid">
                            <!-- Exibe dados da  tarefa -->
                            <div class="card mb-3 border-primary" style="max-width: 950px;">
                                <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                    <div class="row">
                                        <div class="col c2 ml-2">
                                            <div class="h5 mb-0 text-white font-weight-bold">Gerenciamento de pagamentos</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-credit-card fa-3x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="c1 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">CNPJ:</div>
                                            <div class="mb-0"><?= $prestador->cnpj ?></div>
                                        </div>
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">PRESTADOR:</div>
                                            <div class="mb-0"><?= $prestador->razao_social ?></div>
                                        </div> 
                                        <div class="c3 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">TIPO:</div>
                                            <div class="mb-0"><?=$manterTipoPrestador->getTipoPrestadorPorId($prestador->tipo_prestador)->tipo ?></div>
                                        </div> 
                                        <div class="c4 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">PROCESSO SEI:</div>
                                            <div class="mb-0"><?= $prestador->processo_sei ?></div>
                                        </div>
                                    </div>
                                    <br/>
                                    <?php
                                        if($editar){
                                     ?>
                                    <p class=" ml-2 card-text">
                                    <span id="txt_cadastro_informativo" class="mt-3 ml-2 h6 card-title">Novo pagamento</span>
                                    <form id="form_cadastro" action="save_pagamento_prestador.php" method="post" onsubmit="return verificaInformativoExiste(<?=$prestador->id ?>)">
                                        <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$usuario_logado->id ?>"/>
                                        <input type="hidden" id="id_prestador" name="id_prestador" value="<?=$prestador->id ?>"/>
                                        <input type="hidden" id="id_fiscal_prestador" name="id_fiscal_prestador" value="<?=$executor->id_fiscal_prestador ?>"/>
                                        <input type="hidden" id="id" name="id" value="0"/>
                                        <div class="form-group row ml-1">
                                            <label for="competencia" class="col-sm-2 col-form-label">Competência:</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="competencia" name="competencia" class="form-control form-control-sm" required />
                                            </div>
                                        </div>
                                        <div class="form-group row ml-1">
                                            <label for="informativo" class="col-sm-2 col-form-label">Informativo:</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="informativo" name="informativo" class="form-control form-control-sm" required />
                                            </div>
                                            <br/><span id="msg_informativo" class="text-danger font-weight-bold"></span>
                                        </div>

                                        <div class="form-group row float-right">
                                            <button type="button" class="btn btn-danger btn-sm mr-3" onclick="location.reload();"><i class="fas fa-undo"></i> Cancelar</button>
                                            <button type="submit" class="btn btn-primary btn-sm mr-3"><i class="fas fa-save"></i> Salvar</button>
                                        </div>
                                    </form>   

                                    </p>
                                    <?php
                                     }
                                    ?>
                                </div>
                            </div>
                            <!-- fim da exibição -->
                            <?php
                        }
                        ?>

                        <?php include './form_nota_pagamento.php'; ?>
                        <div class="card mb-4 border-primary" style="max-width:1200px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-credit-card fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Pagamentos cadastrados</span>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">COMPETÊNCIA</th>
                                            <th scope="col">INFORMATIVO</th>         
                                            <th scope="col">OPÇÕES</th> 
                                            <th scope="col" class="text-center">NOTAS FISCAIS</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="opcoes">
                                        <?php 
                                                foreach ($pagamentos as $obj) {
                                                    $notas     = $manterPagamento->getNotasPorPagamento($obj->id);

                                                    echo "<tr>";
                                                    echo "  <td>".$obj->id."</td>";
                                                    echo "  <td>".$obj->competencia."</td>";
                                                    echo "  <td>".$obj->informativo."</td>";
                                                    $btn_nova = "<button id='btn_cadastrar' onclick='novaNota(".$obj->id.",\"".$obj->competencia."\",\"".$obj->informativo."\")' title='Adicionar nota!' class='btn btn-primary btn-sm' type='button'>
                                                                    <i class='fa fa-plus-circle text-white' aria-hidden='true'></i>
                                                                </button>";
                                                    $btn_alterar = "<button id='btn_cadastrar' onclick='alterarInformativo(".$obj->id.",\"".$obj->competencia."\",\"".$obj->informativo."\",\"".$obj->fiscal_prestador."\")' title='Alterar informativo!' class='btn btn-warning btn-sm' type='button'>
                                                                    <i class='fas fa-edit text-white' aria-hidden='true'></i>
                                                                </button>";
                                                    if($editar){
                                                        if ($obj->excluir) {
                                                            echo "  <td align='center'>".$btn_alterar."&nbsp;&nbsp;".$btn_nova."&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$prestador->id.",".$obj->id.",\"".$obj->informativo."\",\"".$obj->competencia."\",".$usuario_logado->id.")'><i class='far fa-trash-alt'></i></button></td>";
                                                        } else {
                                                            echo "  <td align='center'>".$btn_alterar."&nbsp;&nbsp;".$btn_nova."&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possui notas!'><i class='far fa-trash-alt'></i></button></td>";

                                                        }
                                                    } else {
                                                        echo "  <td align='center'> - </td>";                
                                                    }
                                                    echo "  <td>";
                                                    $tem_nota = false;
                                                    $out_notas = "";
                                                    foreach ($notas as $n) {
                                                        $tem_nota = true;
                                                        $out_notas .= "<tr>";
                                                        $out_notas .= "  <td>".$n->numero."</td>";
                                                        $out_notas .= "  <td>".$n->valor."</td>";
                                                        $out_notas .= "  <td>".$n->exercicio."</td>";

                                                        $ocorrencias = $manterOcorrenciaNota->getOcorrenciasPorIdNotaPagamento($n->id);
                                                        $total_ocorrencias = count($ocorrencias);
                                                        $txt_dados_ocorrencia = "";
                                                        foreach ($ocorrencias as $o) {
                                                            if($txt_dados_ocorrencia == ""){
                                                                $txt_dados_ocorrencia = $o->descricao;
                                                            } else {
                                                                $txt_dados_ocorrencia .= "###" .$o->descricao;
                                                            }
                                                        }
                                                        $campo_ocorrencias = "<input type='hidden' id='ocorrencia_".$n->id."' name='ocorrencia_".$n->id."' value='". $txt_dados_ocorrencia ."'/>";
                                                        $btn_ocorrencias = "<button id='btn_ocorrencias' onclick='mostrarOcorrencias(".$n->id.",".$prestador->id.")' title='Mostrar Ocorrências' class='btn btn-info btn-sm' type='button'>".$total_ocorrencias."</button>&nbsp;";

                                                        $btn_nt_excluir = "<button class='btn btn-danger btn-sm' type='button' onclick='excluirNota(".$prestador->id.",".$n->id.",\"".$n->numero."\",\"".$n->valor."\",\"".$n->exercicio."\",".$usuario_logado->id.")'><i class='far fa-trash-alt'></i></button>";
                                                        $btn_nt_executar = "<a class='btn btn-primary btn-sm' title='Executar nota!' href='executar_nota_pagamento.php?id_prestador=".$prestador->id."&id=".$n->id."&id_usuario=".$usuario_logado->id."'><i class='fa fa-play'></i></a>";
                                                        $btn_nt_reverter_exec = "<a class='btn btn-danger btn-sm' title='Reverter execução!' href='reverter_execucao_nota_pagamento.php?id_prestador=".$prestador->id."&id=".$n->id."&id_usuario=".$usuario_logado->id."'><i class='fa fa-random'></i></a>&nbsp;";
                                                        $btn_nt_reverter_atst = "<a class='btn btn-danger btn-sm' title='Reverter atesto!' href='reverter_atesto_nota_pagamento.php?id_prestador=".$prestador->id."&id=".$n->id."&id_usuario=".$usuario_logado->id."'><i class='fa fa-random'></i></a>&nbsp;";
                                                        $btn_nt_reverter_pag = "<a class='btn btn-danger btn-sm' title='Reverter pagamento!' href='reverter_pagamento_nota_pagamento.php?id_prestador=".$prestador->id."&id=".$n->id."&id_usuario=".$usuario_logado->id."'><i class='fa fa-random'></i></a>&nbsp;";
                                                        $btn_nt_atestar = "<a class='btn btn-success btn-sm' title='Atestar nota!' href='atestar_nota_pagamento.php?id_prestador=".$prestador->id."&id=".$n->id."&id_usuario=".$usuario_logado->id."'><i class='fa fa-check'></i></a>";                                                    
                                                        $btn_nt_pagar = "<button title='Pagar nota!' class='btn btn-warning btn-sm' type='button' onclick='pagarNota(".$prestador->id.",".$n->id.",\"".$n->numero."\",\"".$n->valor."\",\"".$n->exercicio."\",".$usuario_logado->id.")'><i class='fa fa-credit-card'></i></button>";
                                                        $txt_btns = " - ";
                                                        $txt_doc_sei = "";
                                                        if($editar){
                                                            $txt_btns = "";
                                                            $txt_status = "";
                                                            switch ($n->status) {
                                                                case 'Em análise':
                                                                    $txt_btns = $btn_nt_executar . " " . $btn_nt_excluir;
                                                                    break;
                                                                case 'Executado':
                                                                    if($usuario_logado->perfil <= 2){
                                                                        $txt_btns =  $btn_nt_reverter_exec . " " . $btn_nt_atestar;
                                                                    } else {
                                                                        $txt_btns = " - ";
                                                                    }
                                                                    break;
                                                                case 'Atestado':
                                                                    if($usuario_logado->perfil <= 2){
                                                                        $txt_btns =  $btn_nt_reverter_atst . " " . $btn_nt_pagar;
                                                                    } else {
                                                                        $txt_btns = $btn_nt_pagar;
                                                                    }
                                                                    break;
                                                                case 'Pago':
                                                                    if($usuario_logado->perfil <= 2){
                                                                        $txt_btns =  $btn_nt_reverter_pag ;
                                                                    } else {
                                                                        $txt_btns = " - ";
                                                                    }
                                                                    $txt_doc_sei = "</br>(" . $n->doc_sei . ")";
                                                                    break;
                                                            }
                                                            
                                                        }
                                                        $out_notas .= "  <td><b>".$n->status."</b>".$txt_doc_sei."</td>";
                                                        $out_notas .= "  <td align='center'>".$txt_btns . $btn_ocorrencias . $campo_ocorrencias ."</td>";
                                                        $out_notas .= "</tr>";
                                                    }
                                                    if ($tem_nota) {
                                                        ?>
                                                        <table id="notas" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">NOTA FISCAL</th> 
                                                                    <th scope="col">VALOR</th> 
                                                                    <th scope="col">EXERCÍCIO</th>
                                                                    <th scope="col">SITUAÇÃO</th> 
                                                                    <th scope="col">OPÇÕES</th> 
                                                                </tr>
                                                            </thead>
                                                        <?php                                                        
                                                        echo $out_notas;
                                                        echo "</table>";
                                                    }
                                                    echo "  </td>";
                                                    echo "</tr>";
                                                }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                    <form id="form_cadastro" action="pagar_nota_pagamento.php" method="post">
                        <input type="hidden" id="id_nota_pg" name="id_nota"/>
                        <input type="hidden" id="id_usuario_pg" name="id_usuario"/>
                        <input type="hidden" id="id_prestador_pg" name="id_prestador"/>
                        <div class="form-row">
                        <p><strong><span id="nome_pg"></span></strong></p>
                            <div class="form-group">
                                <label for="data_pagamento">Data de pagamento:<span class="text-danger font-weight-bold">*</span></label>
                                <input type="date" name="data_pagamento" class="form-control form-control-sm" id="data_pagamento" required>
                            </div> 
                            <div class="form-group">
                                <label for="doc_sei">Doc. SEI:</label>
                                <input type="text" name="doc_sei" class="form-control form-control-sm" id="doc_sei" required>
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

 <!-- Modal Ocorrencias -->
<div class="modal fade" id="modal_ocorrencias" tabindex="-1" role="dialog" aria-labelledby="TituloModalOcorrencias" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalOcorrencias">Ocorrências Nota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="txt_ocorrencias"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <a id="link_ocorrencia" href="" class="btn btn-primary">Editar ocorrências</a>
      </div>
    </div>
  </div>
</div>

    </body>

</html>
