<?php
//Contratos
$mod = 11;
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

        <title>Prestadores</title>

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

            var tipos_prestador = [];
<?php
include_once('./actions/ManterTipoPrestador.php');

$manterTipoPrestador = new ManterTipoPrestador();
$listaS = $manterTipoPrestador->listar();


foreach ($listaS as $obj) {
    ?>item = {id: "<?= $obj->id ?>", tipo: "<?= $obj->tipo ?>"};
                tipos_prestador.push(item);
    <?php
}

?>

        function carregaTipoPrestadores(id_atual) {
            var html = '<option value="">Selecione </option>';
            for (var i = 0; i < tipos_prestador.length; i++) {
                var option = tipos_prestador[i];
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
            $('#tipo_prestador').html(html);
        }
        $(document).ready(function () {
            $('#prestadores').DataTable({
                order: [2, 'asc']
            });
            $('#id').val(0);
            carregaTipoPrestadores(0);
        });
        function novo() {
            $('#id').val(0);
            carregaTipoPrestadores(0);

            $('#form_prestador').collapse("show");
            $('#btn_cadastrar').hide();
        }
        function excluir(id, nome) {
            $('#delete').attr('href', 'del_prestador.php?op=1&id=' + id);
            $('#nome_excluir').text(nome);
            $('#confirm').modal({show: true});
        }
        function alterar(id, cnpj, razao_social, nome_fantasia,credenciado, telefone,ativo,id_tipo_prestador) {
            $('#op').val(1);
            $('#id').val(id);
            $('#cnpj').val(cnpj);
            $('#razao_social').val(razao_social);
            $('#nome_fantasia').val(nome_fantasia);
            $('#telefone').val(telefone);
            $('#credenciado').val(credenciado);
            if (credenciado == 1) {
                $('#credenciado').prop('checked', true);
            } else {
                $('#credenciado').prop('checked', false);
            }
            carregaTipoPrestadores(id_tipo_prestador);
            $('#form_prestador').collapse("show");
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
            <?php include './menu_contratos.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>

                    <div class="container-fluid">
                        <?php include './form_prestador.php'; ?>
                        <!-- Project Card Example -->
                        <div class="card mb-4 border-primary" style="max-width:1000px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-th-large fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Prestadores</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <button id="btn_cadastrar" onclick="novo()" class="btn btn-outline-light btn-sm" type="button" data-toggle="collapse" data-target="#form_prestador" aria-expanded="false" aria-controls="form_prestador">
                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="prestadores" class="table-sm table-striped table-bordered dt-responsive wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width:5%;">ID</th>
                                            <th scope="col" style="width:20%;">CNPJ</th>
                                            <th scope="col" style="width:35%;">Nome Fantasia</th>
                                            <th scope="col">Tipo Prestador</th>
                                            <th scope="col">Ativo</th>
                                            <th scope="col" class="align-middle nowrap" style="width:18%;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include './get_prestador_contrato.php'; ?>
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
