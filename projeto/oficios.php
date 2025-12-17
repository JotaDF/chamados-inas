<?php
//Oficios
$mod = 23;
require_once('./verifica_login.php');

include_once('actions/ManterAcessoOficio.php');   
        
$manterAcessoOficio = new ManterAcessoOficio();
$acessoUsuario = $manterAcessoOficio->getAcessoOficioPorUsuario($usuario_logado->id);
$editar = false;
$disable = "disabled";
if ($usuario_logado->perfil < 3 or $acessoUsuario->editor == 1) {
    $editar = true;
    $disable = "";
}

require_once('./actions/ManterSetor.php');
$db_setor = new ManterSetor();
$setor = $db_setor->getSetorPorId($usuario_logado->setor);
$array_setor = explode("/", $setor->sigla);
$origem  = "";
if (count($array_setor) > 1) {
if($array_setor[1] == "DIPLAS" or $array_setor[1] == "DIAD" or $array_setor[1] == "DIJUR" or $array_setor[1] == "DIFIN" ){
    $origem = trim($array_setor[0] . "/" . $array_setor[1]);
} else {
    $origem = trim($array_setor[0]);
}
} else {
    $origem = trim($array_setor[0]);
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

        <title>Gestão de Ofícios</title>

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

        $(document).ready(function () {
            $('#oficios').DataTable({
                order: [2, 'asc']
            });
            $('#id').val(0);
            const quillOpcoes = {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ 'align': [] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
                    ],
                },
                theme: 'snow',
            };

            // Instanciar o Quill para o editor de TAP
            quillEditor = new Quill('#editor', quillOpcoes);
            document.getElementById('form_oficio').addEventListener('submit', function () {
                const quillEditorHTML = quillEditor.root.innerHTML;
                document.querySelector('input[name="assunto"]').value = quillEditorHTML;
            });
        });
        function novo() {
            $('#id').val(0);
            $('#setor').val('<?= $origem ?>');
            $('#id_usuario').val('<?= $usuario_logado->id ?>');
            $('#processo').prop('disabled', false);
            $('#link_sei').prop('disabled', false);
            $('#numero').prop('disabled', false);
            $('#destino').prop('disabled', false);
            $('#origem').prop('disabled', false);
            $('#enviado').prop('disabled', false);
            $('#btn_salvar').prop('disabled', false);

            quillEditor.root.innerHTML = '';
            $('#form_oficio').collapse("show");
            $('#btn_cadastrar').hide();
        }
        function excluir(id, nome) {
            $('#delete').attr('href', 'del_oficio.php?op=1&id=' + id);
            $('#nome_excluir').text(nome);
            $('#confirm').modal({show: true});
        }
        
        function alterar(id,processo,link_sei,numero,assunto,destino,origem,enviado,atendido,setor,usuario, editor) {
            $('#id').val(id);
            $('#processo').val(processo);
            $('#link_sei').val(link_sei);
            $('#numero').val(numero);
            $('#destino').val(destino);
            $('#origem').val(origem);
            $('#enviado').val(enviado);
            $('#atendido').val(atendido);
            $('#setor').val(setor);
            let conteudo = document.getElementById(id + '_assunto').value;
                quillEditor.root.innerHTML = conteudo;
            if(editor == 1){
                $('#processo').prop('disabled', false);
                $('#link_sei').prop('disabled', false);
                $('#numero').prop('disabled', false);
                $('#destino').prop('disabled', false);
                $('#origem').prop('disabled', false);
                $('#enviado').prop('disabled', false);
                $('#btn_salvar').prop('disabled', false);
            } else {
                $('#processo').prop('disabled', true);
                $('#link_sei').prop('disabled', true);
                $('#numero').prop('disabled', true);
                $('#destino').prop('disabled', true);
                $('#origem').prop('disabled', true);
                $('#enviado').prop('disabled', true);
                $('#btn_salvar').prop('disabled', true);
            }
            $('#form_oficio').collapse("show");
            $('#btn_cadastrar').hide();
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
            <?php include './menu_oficio.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>

                    <div class="container-fluid">
                        <?php include './form_oficio.php'; ?>
                        <!-- Project Card Example -->
                        <div class="card mb-4 border-primary" style="max-width:1200px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-th-large fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Ofícios</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <?php
                                    if($editar){
                                    ?>
                                    <button id="btn_cadastrar" onclick="novo()" class="btn btn-outline-light btn-sm" type="button" data-toggle="collapse" data-target="#form_oficio" aria-expanded="false" aria-controls="form_oficio">
                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                    </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="oficios" class="table-sm table-striped table-bordered dt-responsive wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width:15%;">Processo</th>
                                            <th scope="col" style="width:8;">Link SEI</th>
                                            <th scope="col" style="width:10%;">Ofício Nº</th>
                                            <th scope="col" style="width:35%;">Assunto</th>
                                            <th scope="col">Origem</th>
                                            <th scope="col">Destino</th>
                                            <th scope="col" style="width:8%;">Enviado</th>
                                            <th scope="col">Setor</th>
                                            <th scope="col" class="align-middle nowrap" style="width:15%;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include './get_oficio.php'; ?>
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
