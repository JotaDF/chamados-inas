<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Leitor de Excel</title>
</head>

<body id="page-top">
    <div class="wrapper">
        <?php include './menu_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './top_bar.php'; ?>
            <div class="container-fluid">

            </div>
        </div>
    </div>
    <form action="xml_3.php" method="POST" enctype="multipart/form-data">
        <label for="excel">Selecione o seu Excel:</label>
        <input type="file" id="excel" name="excel" accept=".xlsx, .xls, .xlt" required>
        <label for="">Retificação</label>
        <select name="reti" id="reti">
            <option>1</option>
            <option>2</option>
        </select>
        <label for="">TpAmb</label>
        <select name="tpamb" id="tpamb">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <label for="">procEmi</label>
        <select name="procEmi" id="procEmi">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <label for="">Periodo de apuração</label>
        <input type="date" name="data">
        <label for="">Natureza do Rendimendo</label>
        <select name="rend" id="rend">
            <option value="1705">1705</option>
            <option value="2">2</option>
        </select>
        <button type="submit">Ver Xml</button>
        <button type="submit" name="baixar">Baixar</button>
    </form>
    <form action="baixar.php" method="POST">
    </form>
    <?php

    ?>
    </div>
</body>

</html>