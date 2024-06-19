<?php
//Juridico
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

        <title>Jurídico - Gerenciador de processos vinculados</title>

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
            $(document).ready(function () {
            });
            function excluir(id, id_processo, valor, tipo) {
                $('#delete').attr('href', 'remover_valor_processo.php?id=' + id + '&id_processo='+id_processo);
                $('#nome_excluir').text(tipo + " R$ " + valor);
                $('#confirm').modal({show: true});              
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
            <?php include './menu_juridico.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    <?php
                    include_once('actions/ManterProcesso.php');
                    include_once('actions/ManterValorProcesso.php');
                    include_once('actions/ManterTipoValor.php');

                    $manterProcesso = new ManterProcesso();
                    $manterValorProcesso = new ManterValorProcesso();
                    $manterTipoValor = new ManterTipoValor();

                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $processo       = $manterProcesso->getProcessoPorId($id);
                        $filtro = "WHERE id_processo=" . $id;
                        $valores_processo = $manterValorProcesso->listar($filtro);
                        $tipos_valores  = $manterTipoValor->listar();
                        $editar = false;
                        
                        ?>
                        <div class="container-fluid">
                            <!-- Exibe dados da  tarefa -->
                            <div class="card mb-3 border-primary" style="max-width: 800px;">
                                <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                    <div class="row">
                                        <div class="col c2 ml-2">
                                            <div class="h5 mb-0 text-white font-weight-bold">Gerenciamento de opções de processo</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-credit-card fa-3x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="c1 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">ID</div>
                                            <div class="mb-0"><?= $processo->id ?></div>
                                        </div>
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Processo</div>
                                            <div class="mb-0"><?= $processo->numero ?></div>
                                        </div> 
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Valor da causa</div>
                                            <div class="mb-0"><?= $processo->valor_causa ?></div>
                                        </div> 
                                        <div class="c3 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">CPF</div>
                                            <div class="mb-0"><?= $processo->cpf ?></div>
                                        </div> 
                                        <div class="c3 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Beneficiário</div>
                                            <div class="mb-0"><?= $processo->beneficiario ?></div>
                                        </div>                                        
                                    </div>
                                    <br/>
                                    <?php
                                        if($usuario_logado->perfil<=2){
                                     ?>
                                    <p class=" ml-2 card-text">
                                    <span class="mt-3 ml-2 h6 card-title">Novo valor</span>
                                    <form id="form_cadastro" action="save_valor_processo.php" method="post">
                                        <input type="hidden" id="id_processo" name="id_processo" value="<?=$processo->id ?>"/>
                                        <div class="form-group row">
                                            <label for="opcao" class="col-sm-2 col-form-label">Tipo:</label>
                                            <div class="col-sm-10">
                                            <select id="tipo" name="id_tipo_valor" class="form-control form-control-sm" required>
                                                <option value="">Selecione</option>    
                                                <?php
                                                foreach ($tipos_valores as $tv) {
                                                ?> 
                                                    <option value="<?=$tv->id ?>"><?=$tv->tipo ?></option> 
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="valor" class="col-sm-2 col-form-label">Valor:</label>
                                            <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" onInput="mascaraMoeda(event);" name="valor" id="valor" placeholder="R$ 0,00" required>
                                            </div>
                                        </div>
                                        <div class="form-group row float-right mr-1">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Adicionar</button>
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


                        <div class="card mb-4 border-primary" style="max-width:800px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-credit-card fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Valores cadastrados</span>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Valor</th>        
                                            <th scope="col">REMOVER</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="valores">
                                        <?php                                                 
                                                $soma = 0;
                                                foreach ($valores_processo as $obj) {
                                                    $valor = str_replace(".","",$obj->valor);
                                                    $valor = str_replace(",",".",$valor);
                                                    $valor = str_replace("R$","",$valor);
                                                    $valor = str_replace(" ","",$valor);                                                                                                                                                      
                                                    $soma += $valor;

                                                    $tipo = $manterTipoValor->getTipoValorPorId($obj->id_tipo_valor);
                                                    echo "<tr>";
                                                    echo "  <td>".$obj->id."</td>";
                                                    echo "  <td>".$tipo->tipo."</td>";
                                                    echo "  <td>".$obj->valor."</td>";
                                                    if($usuario_logado->perfil <= 2){
                                                        echo "  <td align='center'><button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",".$obj->id_processo.",\"".$obj->valor."\",\"".$tipo->tipo."\")'><i class='far fa-trash-alt'></i></button></td>";
                                                    } else {
                                                        echo "  <td align='center'> - </td>";                
                                                    }
                                                    echo "</tr>";
                                                }
                                                //Imprime soma
                                                echo "<tr>";
                                                echo "  <td colspan='2'>Valor Total</td>";
                                                echo "  <td>". number_format($soma,2,",",".") ."</td>";
                                                echo "  <td align='center'> - </td>";                
                                                echo "</tr>";
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
