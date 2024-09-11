<?php
//Contratos
$mod = 12;
require_once('./verifica_login.php');

$numero = $_REQUEST['numero'];
$ano = $_REQUEST['ano'];
$id = $_REQUEST['id'];

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

        <title>Gerenciar arquivos ponto</title>

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
             function deleteFile(fileName) {
                var xhr = new XMLHttpRequest();
                var item = document.getElementById("file-"+fileName);
                xhr.open("GET", "del_arquivo_contrato.php?numero=<?=$numero ?>&ano=<?=$ano ?>&file=" + fileName, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log("Arquivo deletado");
                        item.remove();
                    }
                };
                xhr.send();
                $('#confirm').modal('hide');
            }

            function excluir(fileName) {
                $('#delete').attr('onclick', 'deleteFile("'+fileName+'")');
                $('#excluir').text(fileName);
                $('#confirm').modal({show: true});              
            }

            function atualizar(){
                // Fazendo requisição AJAX
                $.ajax({
                    url: 'get_arquivos_contrato.php?numero=<?=$numero ?>&ano=<?=$ano ?>',
                    dataType: 'html',
                    success: function (html) {
                        $('#arquivos_contrato').html(html);
                    }
                });
            }

        </script>
        <style>
            body{
                font-size: small;
            }
            #teste{position:relative}
            #teste:hover{top:-1px;box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.1)}

            .texto{
                padding: 5px;
                text-align: center;
                font-family:'Times New Roman', Times, serif, sans-serif;
                padding: 10px;
            }

            .pdf{
                background-color: #F2F2F2;
                border: solid gray 1px;
                width: 250px;
                height: 15px;
                border-radius: 3px;
                box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.1);
                padding: 1px;
                
            }

            .pdf2{
                background-color: #81DAF5;
                border-top: 5px solid #2E9AFE ;
                width: 293px;
                height: relative;
                border-radius: 4px;
                padding: 4px;
            }

            .opcoes{
                float: right;
                font-size: 13px;
                font-family: Arial, Helvetica, sans-serif;
                padding: 2px;
                text-decoration: none;
                border-radius: 2px;
                box-shadow: 0px 2px 3px  0px rgba(0, 0, 0, 0.1);
                padding: 2px;
            }

            .conteudo {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .drop-section {
            border: 5px dashed #ccc;
            padding: 50px;
            margin-bottom: 20px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            transition: border-color 0.3s;
        }

        .drag-over-effect {
            border-color: #007bff;
            animation-delay: 3s;
            animation-delay: 0s;
            animation-delay: -1500ms;

        }

        .file-selector-button, .upload-all-button, .upload-single-button {
            cursor: pointer;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 5px;
            transition: background-color 0.3s;
        }

        .file-selector-button:hover, .upload-all-button:hover, .upload-single-button:hover {
            background-color: #0056b3;
        }

        .list-section {
            width: 80%;
            max-width: 600px;
            margin-top: 20px;
        }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .list li.in-prog {
            background-color: #f0f8ff;
        }

        .list li.complete {
            background-color: #e6ffed;
        }

        .list .col {
            display: flex;
            align-items: center;
        }

        .list .col img {
            width: 40px;
            margin-right: 15px;
        }

        .list .file-name {
            font-size: 16px;
            margin-right: 15px;
        }

        .list .file-progress span {
            display: block;
            height: 5px;
            background-color: #007bff;
            width: 0;
            transition: width 0.3s;
        }

        .list .file-size {
            margin-left: auto;
            margin-right: 15px;
            font-size: 14px;
            color: #666;
        }

        .list .cross, .list .upload-single-button {
            margin-left: 10px;
            fill: #ff5b5b;
            cursor: pointer;
            transition: fill 0.3s;
        }

        .list .cross:hover {
            fill: #ff0000;
        }

        .list .upload-single-button {
            background-color: transparent;
            color: #007bff;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        .list .upload-single-button:hover {
            background-color: #007bff;
            color: white;
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
                        <?php

                        $uploadDir = 'contratos/';
                        $uploadDir .= $numero;
                        $uploadDir .= '_';
                        $uploadDir .= $ano;
                        $uploadDir .= '/';
                        ?>
                        <div class="card" style="max-width:900px">
                        <div class="form-group row float-right">
                                <a href="gerenciar_contratos_prestador.php?id=<?=$id ?>" class="btn btn-success btn-sm"><i class="fa fa-arrow-left text-white"></i> Voltar</a>
                            </div>
                        </div>
                        <!-- Collapsable Form -->
                        <div class="card mb-4 collapse hide border-primary" id="form_arquivos_contrato" style="max-width:900px">
                            <!-- Card Header - Accordion -->
                            <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
                                <span class="h6 m-0 font-weight text-white">Enviar arquivos do contrato (<?=$numero . '/' . $ano ?>)</span>
                            </div>                  
                            <!-- Card Content - Collapse -->
                            <div class="card-body">
                                <div class="card-group">
                                <div class="drop-section">Solte seus arquivos aqui</div>
                                <button class="file-selector-button">Buscar arquivos</button>
                                <input type="file" class="file-selector-input" multiple style="display: none;">
                                <button class="upload-all-button" id="uploadButton">Enviar Todos</button>
                                <div class="list-section">
                                    <ul class="list"></ul>
                                </div>               
                            </div>
                            <div class="form-group row float-right">
                                <button type="reset" data-toggle="collapse" data-target="#form_arquivos_contrato" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                            </div>
                        </div>
                        </div>

                        <div class="card mb-4 border-primary" style="max-width:900px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-address-card fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Arquivos de do contrato (<?=$numero . '/' . $ano ?>)</span> <button class='btn btn-outline-light btn-sm' type='button' title="Atualizar lista!" onclick="atualizar()"><i class="fa fa-spinner text-white" aria-hidden="true"></i></button>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button" data-toggle="collapse" data-target="#form_arquivos_contrato" aria-expanded="false" aria-controls="form_arquivos_contrato">
                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <div class="card-group" id="arquivos_contrato">
                                    <?php
                           
                                    $files = array_diff(scandir($uploadDir), array('.', '..'));

                                    foreach ($files as $file) { ?>
                                        <div id='file-<?=$file ?>' class='col-xl-3 col-md-2 mb-4' style='max-width: 280px; max-height: 100px;'>
                                                <a href="<?=$uploadDir . $file ?>" target="_blank"><img src="img/pdf_icon.svg" width="50" height="50" /></a> <?=str_replace(".pdf","",$file) ?> 
                                                <a  href="javascript:void(0);" onclick="excluir('<?=$file ?>')"><i class='far fa-trash-alt text-danger'></i></a>
                                        </div>
                                   <?php
                                    }
                                    ?>
                                </div>
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

        <script>
        //upload de arquivos
        const dropArea = document.querySelector('.drop-section');
        const listSection = document.querySelector('.list-section');
        const listContainer = document.querySelector('.list');
        const fileSelectorButton = document.querySelector('.file-selector-button');
        const fileSelectorInput = document.querySelector('.file-selector-input');
        const uploadButton = document.getElementById('uploadButton');
        let filesToUpload = [];

        fileSelectorButton.onclick = () => fileSelectorInput.click();

        fileSelectorInput.onchange = () => {
            [...fileSelectorInput.files].forEach((file) => {
                if (typeValidation(file.type)) {
                    addFileToList(file);
                }
            });
        };

        dropArea.ondragover = (e) => {
            e.preventDefault();
            [...e.dataTransfer.items].forEach((item) => {
                if (typeValidation(item.type)) {
                    dropArea.classList.add('drag-over-effect');
                }
            });
        };

        dropArea.ondragleave = () => {
            dropArea.classList.remove('drag-over-effect');
        };

        dropArea.ondrop = (e) => {
            e.preventDefault();
            dropArea.classList.remove('drag-over-effect');
            if (e.dataTransfer.items) {
                [...e.dataTransfer.items].forEach((item) => {
                    if (item.kind === 'file') {
                        const file = item.getAsFile();
                        if (typeValidation(file.type)) {
                            addFileToList(file);
                        }
                    }
                });
            } else {
                [...e.dataTransfer.files].forEach((file) => {
                    if (typeValidation(file.type)) {
                        addFileToList(file);
                    }
                });
            }
        };

        function typeValidation(type) {
            var splitType = type.split('/')[0];
            return type === 'application/pdf' || splitType === 'image' || splitType === 'video';
        }

        function addFileToList(file) {
            listSection.style.display = 'block';
            var li = document.createElement('li');
            li.classList.add('in-prog');
            li.innerHTML = `
                <div class="col">
                    <img src="img/${iconSelector(file.type)}" alt="">
                </div>
                <div class="col">
                    <div class="file-name">
                        <div class="name">${file.name}</div>
                        <span>0%</span>
                    </div>
                    <div class="file-progress">
                        <span></span>
                    </div>
                    <div class="file-size">${(file.size / (1024 * 1024)).toFixed(5)} MB</div>
                </div>
                <div class="col">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cross" height="20" width="20">
                        <path d="m5.979 14.917-.854-.896 4-4.021-4-4.062.854-.896 4.042 4.062 4-4.062.854.896-4 4.062 4 4.021-.854.896-4-4.063Z"/>
                    </svg>
                    <button class="upload-single-button">Enviar</button>
                </div>`;
            listContainer.prepend(li);

            // Adiciona o arquivo e o elemento li à lista de arquivos para upload
            filesToUpload.push({ file, li });

            // Adiciona o evento de clique ao botão de exclusão
            li.querySelector('.cross').onclick = () => removeFileFromList(file, li);

            // Adiciona o evento de clique ao botão de envio individual
            li.querySelector('.upload-single-button').onclick = () => uploadFile(file, li);
        }

        function removeFileFromList(file, li) {
            // Remove o arquivo da lista de arquivos para upload
            filesToUpload = filesToUpload.filter(item => item.file !== file);
            // Remove o elemento li do DOM
            li.remove();
            // Se a lista estiver vazia, esconde a seção da lista
            if (filesToUpload.length === 0) {
                listSection.style.display = 'none';
            }
        }

        uploadButton.onclick = () => {
            filesToUpload.forEach(({ file, li }) => {
                uploadFile(file, li);
            });
            filesToUpload = [];
            atualizar();
        };

        function uploadFile(file, li) {
            var http = new XMLHttpRequest();
            var data = new FormData();
            data.append('file', file);
            http.onload = () => {
                li.classList.add('complete');
                li.classList.remove('in-prog');
            };
            http.upload.onprogress = (e) => {
                var percent_complete = (e.loaded / e.total) * 100;
                li.querySelectorAll('span')[0].innerHTML = Math.round(percent_complete) + '%';
                li.querySelectorAll('span')[1].style.width = percent_complete + '%';
            };
            data.append('numero', '<?=$numero ?>');
            data.append('ano', '<?=$ano ?>');
            http.open('POST', 'save_arquivo_contrato.php', true);
            http.send(data);
            atualizar();
        }

        function iconSelector(type) {
            var splitType = (type.split('/')[0] == 'application') ? type.split('/')[1] : type.split('/')[0];
            return splitType + '.png';
        }


    </script>        


    </body>

</html>
