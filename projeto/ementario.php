<?php
//Ascom
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

        <title>Ementário - INAS</title>

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
        <!-- Quill Editor -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
        <script type="text/javascript" class="init">
            $(document).ready(function () {
                $('#ementarios').DataTable({
                    paging: true,
                    columnDefs: [
                        {
                        targets: 0, // índice da coluna onde você quer quebrar a linha
                        className: 'text-wrap'
                        }
                    ]  
                });

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

                const quillDescricao = new Quill('#editor-ementa', quillOpcoes);

                document.getElementById('form_ementario').addEventListener('submit', function () {
                    const descHTML = quillDescricao.root.innerHTML;
                    document.querySelector('input[name="ementa"]').value = descHTML;
                });

                function alterar(id, processo_sei, doc_sei, nota_juridica) {
                    $('#id').val(id);
                    $('#processo_sei').val(processo_sei);
                    quillDescricao.root.innerHTML = $('#'+id+'_ementa').val();

                    $('#doc_sei').val(doc_sei);
                    $('#nota_juridica').val(nota_juridica);

                    $('#form_ementario').collapse("show");
                    $('#btn_cadastrar').hide();
                }

                function novo() {
                    $('#id').val("");
                    $('#processo_sei').val("");
                    quillDescricao.root.innerHTML = "";
                    $('#doc_sei').val("");
                    $('#nota_juridica').val("");

                    $('#form_ementario').collapse("show");
                    $('#btn_cadastrar').hide();
                }

                window.alterar = alterar;
                window.novo = novo;
            });

            function excluir(id, nome) {
                $('#delete').attr('href', 'del_ementario.php?id=' + id);
                $('#nome_excluir').text(nome);
                $('#confirm').modal({show: true});
            }

            function selectByText(select, text) {
                $(select).find('option').filter(function () {
                    return $(this).text().trim() === text;
                }).prop('selected', true);
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
                        <?php include './form_ementario.php'; ?>
                        <!-- Project Card Example -->
                        <div class="card mb-4 border-primary" style="max-width:1200px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-rss fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Ementário</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <button id="btn_cadastrar" onclick="novo()" class="btn btn-outline-light btn-sm" type="button" data-toggle="collapse" data-target="#form_ementario" aria-expanded="false" aria-controls="form_ementario">
                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="ementarios" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width:5%;">ID</th>
                                            <th scope="col" style="width:10%;">Precesso SEI</th>
                                            <th scope="col" style="width:5%;">DOC SEI</th>
                                            <th scope="col" style="width:15%;">Nota Jurídica</th>
                                            <th scope="col" style="width:45%;">Ementa</th>
                                            <th scope="col" style="width:5%;">Atualizado</th>
                                            <th scope="col" style="width:5%;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include './get_ementario.php'; ?>
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
