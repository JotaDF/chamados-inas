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
            font-size: 0.95rem;
            background-color: #f8f9fa;
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
</head>

<body>
    <div class="wrapper">
        <br>
        <div class="container mb-2">
            <div class="d-flex justify-content-center">
                <div class="card mb-3 border shadow-sm p-3 mb-5 bg-white rounded" style="max-width: 600px;">
                    <div class="card-body text-center" style="text-align: justify;">
                        <h4 class="card-title border-bottom p-2" >Obrigado por sua participação!</h4>
                        <p class="card-text border-bottom p-2" style="text-align: justify;">
                            Sua colaboração ao responder este questionário é de grande importância para nós. As
                            informações fornecidas ajudarão a aprimorar nossos serviços e a desenvolver iniciativas mais
                            eficazes.

                            Agradecemos seu tempo, sua atenção e seu compromisso!
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="index.php" class="btn btn-primary btn-sm" id="btnProsseguir" role="button"
                            aria-disabled="true">
                            Concluir
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>