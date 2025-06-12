<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceite de Questionário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        body {
            font-size: small;
        }

        /* Estilo para simular um botão desabilitado em <a> */
        .btn.disabled {
            pointer-events: none;
            /* Impede que o clique seja detectado */
            opacity: 0.65;
            /* Opacidade para indicar desabilitação */
            cursor: not-allowed;
            /* Altera o cursor */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            const checkboxAceite = document.getElementById('checkboxAceite');
            const btnProsseguir = document.getElementById('btnProsseguir');
            function toggleButtonState() {
                if (checkboxAceite.checked) {
                    btnProsseguir.classList.remove('disabled');
                    btnProsseguir.removeAttribute('aria-disabled');
                    btnProsseguir.style.pointerEvents = 'auto';
                } else {
                    btnProsseguir.classList.add('disabled');
                    btnProsseguir.setAttribute('aria-disabled', 'true');
                    btnProsseguir.style.pointerEvents = 'none';
                }
            }
            checkboxAceite.addEventListener('change', toggleButtonState);
            toggleButtonState();
        });
    </script>

</head>

<body>
    <div class="wrapper">
        <br>
        <div class="container mb-2">
            <div class="d-flex justify-content-center">
                <div class="card mb-3 border shadow-sm p-3 mb-5 bg-white rounded" style="max-width: 600px;">
                    <div class="card-body text-center">
                        <h4 class="card-title border-bottom p-2">Termo de Consentimento Livre e Esclarecido</h4>
                        <p class="card-text border-bottom p-2">
                            Ao participar deste questionário, você concorda voluntariamente em fornecer suas respostas
                            para fins de pesquisa e/ou aprimoramento de serviços.

                            Garantimos que:

                            <li><strong> respostas serão mantidas em total anonimato, sem qualquer identificação
                                    pessoal;</strong></li>

                            <li>
                                <strong>Os dados coletados serão utilizados exclusivamente para fins estatísticos e de
                                    análise, não
                                    sendo compartilhados individualmente com terceiros;</strong>
                            </li>

                            <li><strong>Sua participação é totalmente voluntária, podendo ser interrompida a qualquer
                                    momento sem
                                    prejuízo algum.</strong></li>
                            <br>
                            Ao prosseguir, você declara estar ciente e de acordo com os termos acima.
                        </p>

                        <input class="form-check-input" type="checkbox" id="checkboxAceite">
                        <label class="form-check-label" for="checkboxAceite">
                            Eu li e concordo com os termos e condições.
                        </label>
                    </div>
                    <div class="d-flex justify-content-center">
                        <?php
                        if (isset($_REQUEST['id']) && isset($_REQUEST['aplicacao'])) {
                            $id_questionario = $_REQUEST['id'];
                            $id_aplicacao = $_REQUEST['aplicacao'];
                        }
                        $parametros = "?id=" . $id_questionario . "&aplicacao=" . $id_aplicacao;
                        ?>
                        <a href="aplicar_questionario.php" class="btn btn-primary btn-sm disabled" id="btnProsseguir"
                            role="button" aria-disabled="true">
                            Prosseguir para o Questionário
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>