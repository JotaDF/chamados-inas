<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Meus chamados</title>
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <!------ Include the above in your HEAD tag ---------->

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" language="javascript" src = "js/jquery.dataTables.min.js" defer ></script>

        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>



        
        <script type="text/javascript" class="init">
         

            $(document).ready(function () {
                //$('#setores').DataTable();
                $('#setores').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "get_setor.php?p=2"
                });
            });
            function excluir(id, sigla) {
                $('#delete').attr('href', 'del_setor.php?id=' + id);
                $('#sigla_excluir').text(sigla);
                $('#confirm').modal({show: true});              
            }
            function alterar(id, sigla,descricao) {
                $('#id').val(id);
                $('#sigla').val(sigla);
                $('#descricao').val(descricao);
                $('#form_setor').collapse("show");
                $('#btn_cadastrar').hide();
            }

            function selectByText(select, text) {
                $(select).find('option:contains("' + text + '")').prop('selected', true);
            }


        </script>
        <style>
            body{
                font-size: small;
            }
            .bd-titulo {
                background-color: #4369d7;
            }
            .bd-titulo-tabela {
                background-color: #e1e1e1;
            }
            .border-box{
                border-color: #4369d7;
            }
        </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once("menu.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include_once("topbar.php"); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                        <?php include './form_setor.php'; ?>
                        <!-- Project Card Example -->
                        <div class="card mb-4 border-box" style="max-width:850px">
                            <div class="row ml-0 card-header py-2 bd-titulo" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-laptop fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h6 m-0 font-weight text-white">Setores</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button" data-toggle="collapse" data-target="#form_setor" aria-expanded="false" aria-controls="form_setor">
                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="setores" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr class="bd-titulo-tabela">
                                            <th scope="col" style="width:10%;">ID</th>
                                            <th scope="col" style="width:30%;">Sigla</th>
                                            <th scope="col" style="width:60%;">Descrição</th>
                                            <th scope="col" class="nowrap">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php //include './get_setor.php'; ?>
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
                        <p>Deseja excluir <strong>"<span id="sigla_excluir"></span>"</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-danger" id="delete">Excluir</a>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>

            </div>
        </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>