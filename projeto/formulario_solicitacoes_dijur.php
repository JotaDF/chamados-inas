<?php
//Chamados
$mod = 6;
require_once('./verifica_login.php');
$setor = "dijur";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Minhas Solicitações - INAS</title>

    <!-- Font Awesome -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- SB Admin -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="favicon.ico" />

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <!-- Quill -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <script>
        $(document).ready(function () {

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
            document.getElementById('form_solicitacoes').addEventListener('submit', function () {
                const quillEditorHTML = quillEditor.root.innerHTML;
                document.querySelector('input[name="descricao"]').value = quillEditorHTML;
            });
            bsCustomFileInput.init();
        });
        $(document).on('change', '.custom-file-input', function () {

            const arquivo = this.files[0];

            if (!arquivo) {
                return;
            }

            // Atualiza o nome do arquivo no label
            $(this)
                .next('.custom-file-label')
                .text(arquivo.name);

            // Verifica se já existe algum input vazio
            let existeInputVazio = false;

            $('.custom-file-input').each(function () {
                if (this.files.length === 0) {
                    existeInputVazio = true;
                    return false;
                }
            });

            // Se já existe um input vazio, não cria outro
            if (existeInputVazio) {
                return;
            }

            // Cria um novo input
            const indice = $('.custom-file-input').length;

            $('#container-anexos').append(`
        <div class="custom-file mb-2">
            <input type="file"
                   class="custom-file-input"
                   id="anexo_${indice}"
                   name="anexos[]">

            <label class="custom-file-label" for="anexo_${indice}">
                Escolher arquivo...
            </label>
        </div>
    `);
        });
    </script>
    <style>
        body {
            font-size: small;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include './menu_solicitacoes_dijur.php'; ?>
        <?php

        include_once('actions/ManterSetor.php');
        $manterSetor = new ManterSetor();
        $setor_usuario = $manterSetor->getSetorPorId($usuario_logado->setor);
        $sigla = explode('/', $setor_usuario->sigla);
        $sigla = count($sigla) > 1 ? $sigla[1] : $sigla[0]; 
        ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include './top_bar.php'; ?>

                <div class="container-fluid">

                    <div class="row justify-content-center">

                        <div class="col-12">

                            <?php include './form_solicitacoes_dijur.php'; ?>

                        </div>

                    </div>

                </div>

            </div>

            <?php include './rodape.php'; ?>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

</body>

</html>