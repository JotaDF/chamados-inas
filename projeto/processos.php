<?php
//Atendimento
$mod = 5;
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

        <title>Processos - INAS</title>

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
                     var assuntos = [];
                     var tipos_liminar = [];
                     var situacoes = [];
                     var instancias = [];
                     var classes_judiciais = [];
<?php
include_once('./actions/ManterAssunto.php');
include_once('./actions/ManterLiminar.php');
include_once('./actions/ManterSituacaoProcessual.php');
include_once('./actions/ManterInstancia.php');
include_once('./actions/ManterClasseJudicial.php');

$manterAssunto = new ManterAssunto();
$listaA = $manterAssunto->listar();

$manterLiminar = new ManterLiminar();
$listaL = $manterLiminar->listar();

$manterSituacaoProcessual = new ManterSituacaoProcessual();
$listaS = $manterSituacaoProcessual->listar();

$manterInstancia = new ManterInstancia();
$listaI = $manterInstancia->listar();

$manterClasseJudicial = new ManterClasseJudicial();
$listaCJ = $manterClasseJudicial->listar();


foreach ($listaA as $obj) {
    ?>item = {id: "<?= $obj->id ?>", assunto: "<?= $obj->assunto ?>"};
                assuntos.push(item);
    <?php
}
foreach ($listaL as $obj) {
    ?>item = {id: "<?= $obj->id ?>", tipo: "<?= $obj->tipo ?>"};
                tipos_liminar.push(item);
    <?php
}
foreach ($listaS as $obj) {
    ?>item = {id: "<?= $obj->id ?>", situacao: "<?= $obj->situacao ?>"};
                situacoes.push(item);
    <?php
}
foreach ($listaI as $obj) {
    ?>item = {id: "<?= $obj->id ?>", instancia: "<?= $obj->instancia ?>"};
                instancias.push(item);
    <?php
}
foreach ($listaCJ as $obj) {
    ?>item = {id: "<?= $obj->id ?>", classe: "<?= $obj->classe ?>"};
                classes_judiciais.push(item);
    <?php
}

?>

            $(document).ready(function () {
                $('#numeros').DataTable();
                carregaAssuntos(0);
                carregaTiposLiminar(0);
                carregaSituacoes(0) ;
                carregaInstancias(0);
                carregaClassesJudiciais(0);
                $('#processo_vinculado').prop("disabled", true);                                                                                                            
                $('#data_cumprimento_liminar').prop("disabled", true);
            });
            var sei_t = "";
            var sei = "";
            var sei_html = "";
            var sei_arr;
            function addSei() {
                sei_t = $('#sei_t').val();
                sei = $('#sei').val();
                
                //alert(sei_t);
                //alert(sei);
                if($(sei_t !="")){
                    sei_html = "";
                    sei_arr = sei. split(";");
                    var achou = false;
                    for (let i = 0; i < sei_arr.length; i++) {
                        if(sei_arr[i] == sei_t){
                            achou = true;
                        }
                    }
                    if(!achou) {
                        sei += sei_t + ";";
                    } else {
                        alert("Processo SEI já adicionado!");
                    }
                    sei_arr = sei. split(";");
                    for (let i = 0; i < sei_arr.length; i++) {
                        if(sei_arr[i] !=""){
                            sei_html += sei_arr[i] + " <a href='#' onclick='delSei(\""+ sei_arr[i] +";\")'><i class='text-danger far fa-trash-alt'></i></a> ";
                        }
                    }
                    $('#txt_sei').html(sei_html);
                    $('#sei').val(sei);
                    $('#sei_t').val("");
                }
                //alert(sei);    
            }
            function delSei(numero) {
                sei_html = "";
                sei = $('#sei').val();
                sei = sei.replace(numero, '');
                sei_arr = sei. split(";");
                for (let i = 0; i < sei_arr.length; i++) {
                    if(sei_arr[i] !=""){
                        sei_html += sei_arr[i] + " <a href='#' onclick='delSei(\""+ sei_arr[i] +";\")'><i class='text-danger far fa-trash-alt'></i></a> ";
                    }
                }
                $('#txt_sei').html(sei_html);
                $('#sei').val(sei);
                //alert(sei);    
            }
            function verificaClasse(classe) {
                if (classe != "") {
                    $('#processo_vinculado').prop("disabled", false);
                } else {
                    $('#processo_vinculado').prop("disabled", true);
                }
            }
            function verificaLiminar(liminar) {
                if (liminar != "") {
                    $('#data_cumprimento_liminar').prop("disabled", false);
                } else {
                    $('#data_cumprimento_liminar').prop("disabled", true);
                }
            }
            function excluir(id, numero) {
                $('#delete').attr('href', 'del_processo.php?id=' + id);
                $('#excluir').text(numero);
                $('#confirm').modal({show: true});              
            }
            function alterar(id, numero) {
                $('#id').val(id);
                $('#numero').val(numero);
                $('#form_processo').collapse("show");
                carregaAssuntos(0);
                carregaTiposLiminar(0);
                carregaSituacoes(0) ;
                carregaInstancias(0);
                carregaClassesJudiciais(0);
                $('#btn_cadastrar').hide();
            }

            function selectByText(select, text) {
                $(select).find('option:contains("' + text + '")').prop('selected', true);
            }
            function carregaAssuntos(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < assuntos.length; i++) {
                    var option = assuntos[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.assunto + '</option>';
                }
                $('#assunto').html(html);
            }
            function carregaTiposLiminar(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < tipos_liminar.length; i++) {
                    var option = tipos_liminar[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.tipo + '</option>';
                }
                $('#liminar').html(html);
            }
            function carregaSituacoes(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < situacoes.length; i++) {
                    var option = situacoes[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.situacao + '</option>';
                }
                $('#situacao').html(html);
            }
            function carregaInstancias(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < instancias.length; i++) {
                    var option = instancias[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.instancia + '</option>';
                }
                $('#instancia').html(html);
            }
            function carregaClassesJudiciais(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < classes_judiciais.length; i++) {
                    var option = classes_judiciais[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.classe + '</option>';
                }
                $('#classe_judicial').html(html);
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
            function validarCPF() {
                var cpf = $('#cpf').val();
                if(!validarCPFX(cpf)){
                    alert("Número de CPF inválido!");
                    return false;
                }
                return true;
            }
            function validarCPFX(cpf) {	
                cpf = cpf.replace(/\D+/g, '');	
                if(cpf == '') return false;	
                // Elimina CPFs invalidos conhecidos	
                if (cpf.length != 11 || 
                    cpf == "00000000191" ||
                    cpf == "00000000000" ||  
                    cpf == "11111111111" || 
                    cpf == "22222222222" || 
                    cpf == "33333333333" || 
                    cpf == "44444444444" || 
                    cpf == "55555555555" || 
                    cpf == "66666666666" || 
                    cpf == "77777777777" || 
                    cpf == "88888888888" || 
                    cpf == "99999999999")
                        return false;		
                // Valida 1o digito	
                add = 0;	
                for (i=0; i < 9; i ++)		
                    add += parseInt(cpf.charAt(i)) * (10 - i);	
                    rev = 11 - (add % 11);	
                    if (rev == 10 || rev == 11)		
                        rev = 0;	
                    if (rev != parseInt(cpf.charAt(9)))		
                        return false;		
                // Valida 2o digito	
                add = 0;	
                for (i = 0; i < 10; i ++)		
                    add += parseInt(cpf.charAt(i)) * (11 - i);	
                rev = 11 - (add % 11);	
                if (rev == 10 || rev == 11)	
                    rev = 0;	
                if (rev != parseInt(cpf.charAt(10)))
                    return false;		
                return true;   
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
            <?php include './menu_juridico.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>

                    <div class="container-fluid">
                        <?php include './form_processo.php'; ?>
                        <!-- Project Card Example -->
                        <div class="card mb-4 border-primary" style="max-width:900px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-balance-scale fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Processos</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button" data-toggle="collapse" data-target="#form_processo" aria-expanded="false" aria-controls="form_processo">
                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="numeros" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Número</th>
                                            <th scope="col">CPF</th>
                                            <th scope="col">BENEFICIÁRIO</th>
                                            <th scope="col">AUTUAÇÃO</th>
                                            <th scope="col">ASSUNTO</th>
                                            <th scope="col">VALOR CAUSA</th>
                                            <th scope="col" style="width:30px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include './get_processo.php'; ?>
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
                        <p>Deseja excluir <strong>"<span id="excluir"></span>"</strong>?</p>
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
