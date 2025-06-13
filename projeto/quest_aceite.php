<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aceite de Questionário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

    <style>
        body {
            font-size: 0.95rem;
            background-color: #f8f9fa;
        }

        .card {
            max-width: 650px;
        }

        .card-text {
            text-align: justify;
        }

        .btn.disabled {
            pointer-events: none;
            opacity: 0.65;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-center">
            <div class="card border shadow-sm p-4 bg-white rounded" style="max-width: 600px;">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4 border-bottom pb-2"> Termo de consentimento livre e
                        esclarecido</h4>
                    <p class="card-text mb-3" style="text-align: justify;">
                        Ao participar deste questionário, você concorda voluntariamente em fornecer suas respostas para
                        fins de
                        pesquisa e/ou aprimoramento de serviços.
                        <br>
                        <strong>Suas respostas serão mantidas em total anonimato</strong>, sem qualquer identificação
                        pessoal.
                        Os dados coletados serão utilizados exclusivamente para fins estatísticos e de análise.
                        As informações não serão compartilhadas individualmente com terceiros.
                    </p>


                    <div class="form-check mb-4 border-top text-center">
                        <br>
                        <input class="form-check-input" type="checkbox" id="checkboxAceite" />
                        <label class="form-check-label" for="checkboxAceite">
                            Eu li e concordo com os termos e condições.
                        </label>
                    </div>

                    <div class="text-center">
                        <?php
                        if (isset($_REQUEST['id']) && isset($_REQUEST['aplicacao'])) {
                            $id_questionario = $_REQUEST['id'];
                            $id_aplicacao = $_REQUEST['aplicacao'];
                        }
                        $parametros = "?id=" . $id_questionario . "&aplicacao=" . $id_aplicacao;
                        ?>
                        <a href="aplicar_questionario.php<?= $parametros ?>" class="btn btn-primary btn-sm disabled"
                            id="btnProsseguir" role="button" aria-disabled="true">
                            Prosseguir para o Questionário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
</body>

</html>