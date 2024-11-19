<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de Excel</title>
</head>

<body>
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