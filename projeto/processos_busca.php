<?php
//Juridico
$mod = 6;
require_once('./verifica_login.php');

$remover_filtro = isset($_REQUEST['rn']) ? $_REQUEST['rn'] : '';
$busca = [];
if ($remover_filtro == '1') {
    unset($_SESSION['filtro_processo']);
    unset($_SESSION['post_busca']);
    header('Location: processos.php');
} else {
    if (isset($_SESSION['post_busca'])) {
        $busca = $_SESSION['post_busca'];
    }
}

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

        <title>Busca Processos - INAS</title>

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
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script type="text/javascript" class="init">
                     var assuntos = [];
                     var sub_assuntos = [];
                     var motivos = [];
                     var tipos_liminar = [];
                     var situacoes = [];
                     var instancias = [];
                     var classes_judiciais = [];
                     var orgaos_origem = [];
<?php
include_once('./actions/ManterAssunto.php');
include_once('./actions/ManterSubAssunto.php');
include_once('./actions/ManterMotivo.php');
include_once('./actions/ManterLiminar.php');
include_once('./actions/ManterSituacaoProcessual.php');
include_once('./actions/ManterInstancia.php');
include_once('./actions/ManterClasseJudicial.php');
include_once('./actions/ManterOrgaoOrigem.php');

$manterAssunto = new ManterAssunto();
$listaA = $manterAssunto->listar();

$manterSubAssunto = new ManterSubAssunto();
$listaSA = $manterSubAssunto->listar();

$manterMotivo = new ManterMotivo();
$listaM = $manterMotivo->listar();

$manterLiminar = new ManterLiminar();
$listaL = $manterLiminar->listar();

$manterSituacaoProcessual = new ManterSituacaoProcessual();
$listaS = $manterSituacaoProcessual->listar();

$manterInstancia = new ManterInstancia();
$listaI = $manterInstancia->listar();

$manterClasseJudicial = new ManterClasseJudicial();
$listaCJ = $manterClasseJudicial->listar(" WHERE vinculado='0' ");

$manterOrgaoOrigem = new ManterOrgaoOrigem();
$listaO = $manterOrgaoOrigem->listar();

foreach ($listaA as $obj) {
    ?>item = {id: "<?= $obj->id ?>", assunto: "<?= $obj->assunto ?>"};
                assuntos.push(item);
    <?php
}
foreach ($listaSA as $obj) {
    ?>item = {id: "<?= $obj->id ?>", sub_assunto: "<?= $obj->sub_assunto ?>"};
                sub_assuntos.push(item);
    <?php
}
foreach ($listaM as $obj) {
    ?>item = {id: "<?= $obj->id ?>", motivo: "<?= $obj->motivo ?>"};
                motivos.push(item);
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

foreach ($listaO as $obj) {
    ?>item = {id: "<?= $obj->id ?>", orgao: "<?= $obj->nome ?>"};
                orgaos_origem.push(item);
    <?php
}

?>

            $(document).ready(function () {
                carregaAssuntos(<?= isset($busca['assunto']) ? $busca['assunto'] : 0 ?>);
                carregaSubAssuntos(<?= isset($busca['sub_assunto']) ? $busca['sub_assunto'] : 0 ?>);
                carregaMotivos(<?= isset($busca['motivo']) ? $busca['motivo'] : 0 ?>);
                carregaTiposLiminar(<?= isset($busca['liminar']) ? $busca['liminar'] : 0 ?>);
                carregaSituacoes(<?= isset($busca['situacao']) ? $busca['situacao'] : 0 ?>);
                carregaInstancias(<?= isset($busca['instancia']) ? $busca['instancia'] : 0 ?>);
                carregaClassesJudiciais(<?= isset($busca['classe_judicial']) ? $busca['classe_judicial'] : 0 ?>);
                carregaOrgaosOrigem(<?= isset($busca['orgao_origem']) ? $busca['orgao_origem'] : 0 ?>);
                $('input[name="arquivado"][value="<?= isset($busca['arquivado']) ? $busca['arquivado'] : '' ?>"]').prop('checked', true);
                if(isset($busca['arquivado']) && $busca['arquivado'] == 1){
                    $('#arquivado_sim').prop('checked', true);
                } else if(isset($busca['arquivado']) && $busca['arquivado'] == 0){
                    $('#arquivado_nao').prop('checked', true);
                }
                if(isset($busca['inas_parte']) && $busca['inas_parte'] == 1){
                    $('#inas_parte_sim').prop('checked', true);
                } else if(isset($busca['inas_parte']) && $busca['inas_parte'] == 0){
                    $('#inas_parte_nao').prop('checked', true);
                }
                if(isset($busca['pediu_danos']) && $busca['pediu_danos'] == 1){
                    $('#pediu_danos_sim').prop('checked', true);
                } else if(isset($busca['pediu_danos']) && $busca['pediu_danos'] == 0){
                    $('#pediu_danos_nao').prop('checked', true);
                }
            });
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
            function carregaSubAssuntos(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < sub_assuntos.length; i++) {
                    var option = sub_assuntos[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.sub_assunto + '</option>';
                }
                $('#sub_assunto').html(html);
            }
            function carregaMotivos(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < motivos.length; i++) {
                    var option = motivos[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.motivo + '</option>';
                }
                $('#motivo').html(html);
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
            function carregaOrgaosOrigem(id_atual) {
                var html = '<option value="">Selecione </option>';
                for (var i = 0; i < orgaos_origem.length; i++) {
                    var option = orgaos_origem[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.orgao + '</option>';
                }
                $('#orgao_origem').html(html);
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
                        <?php include './form_processo_busca.php'; ?>
                        <!-- Project Card Example -->
                        
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

    </body>

</html>
