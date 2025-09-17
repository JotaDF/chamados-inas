<?php
include('./actions/ManterFeriadoAno.php');
$manterFeriadoAno = new ManterFeriadoAno();
$feriados = $manterFeriadoAno->lista();
$numero_mes = $_GET['numero_mes'];
$horarios = explode(";", $usuario->horario);
$data = new DateTime("$ano-$numero_mes-01");
$ultimo_dia = (clone $data)->modify('last day of this month')->format('d');

$data_feriados = array_map(fn($f) => $f->data, $feriados);

for ($i = 1; $i <= $ultimo_dia; $i++) {
    $numero_dia = sprintf('%02d', $i);
    $data_dia = $data->format('Y-m-d');
    $nome_dia_semana = $data->format('l');

    $td_class = "";
    $editable = "contenteditable='true'";
    $assinatura_servidor = "";

    // Feriados
    if (in_array($data_dia, $data_feriados)) {
        $assinatura_servidor = "FERIADO";
        $td_class = "final_semana";
        $editable = "";
    }

    // Finais de semana
    if ($nome_dia_semana === "Saturday") {
        $assinatura_servidor = "SÁBADO";
        $td_class = "final_semana";
        $editable = "";
    } elseif ($nome_dia_semana === "Sunday") {
        $assinatura_servidor = "DOMINGO";
        $td_class = "final_semana";
        $editable = "";
    }

    // Horários
    if ($assinatura_servidor !== "") {
        [$entrada, $saida_almoco, $volta_almoco, $saida] = ["-----", "-----", "-----", "-----"];
    } else {
        [$entrada, $saida_almoco, $volta_almoco, $saida] = $horarios;
    }

    if ($assinatura_servidor == "DOMINGO" || $assinatura_servidor == "SÁBADO" || $assinatura_servidor == "FERIADO") {
        $assinatura_vespertino = "<td class='$td_class' ><b>$assinatura_servidor</b></td>";
        $assinatura_matutino = "<td class='$td_class' ><b>$assinatura_servidor</b></td>";
    } else {
        $assinatura_vespertino = "<td class='$td_class' onclick='mostrarSelect(this)' data-assinatura><b>$assinatura_servidor</b></td>";
        $assinatura_matutino = "<td class='$td_class' onclick='mostrarSelect(this)' data-assinatura><b>$assinatura_servidor</b></td>";
    }

    echo "<tr>";
    echo "<td class='$td_class' style='height: 12px'><b>$numero_dia</b></td>";
    echo $assinatura_matutino;
    echo "<td class='$td_class' $editable data-horario='$entrada'><b>$entrada</b></td>";
    echo "<td class='$td_class' $editable data-horario='$saida_almoco'><b>$saida_almoco</b></td>";
    echo $assinatura_vespertino;
    echo "<td class='$td_class' $editable data-horario='$volta_almoco'><b>$volta_almoco</b></td>";
    echo "<td class='$td_class' $editable data-horario='$saida'><b>$saida</b></td>";
    echo "<td class='$td_class codigo'></td>";
    echo "</tr>";


    $data->modify('+1 day');
}

?>
<script>
const opcoesAssinatura = {
    ""   : "",
    "219" :"ABONO ANUAL",
    "340" :"ATESTADO - COMPARECIMENTO",
    "310" :"DOAÇÃO DE SANGUE",
    "313" :"FALECIMENTO FAMÍLIA",
    "314" :"A. JÚRI",
    "317" :"A. CASAMENTO",
    "318" :"TREINAMENTO/CURSO",
    "345" :"ATESTADO DE ATÉ (03) DIAS",
    "118" :"EXAME MÉDICO",
    "119" :"FALTA INJUSTIFICADA",
    "594" :"FÉRIAS",
    "211" :"L. ADOÇÃO (07) DIAS",
    "207" :"L. MATERNIDADE",
    "205" :"L. MOTIVO DOENÇA FAMILIA",
    "339" :"P. PARTERNIDADE (23) Dias",
    "258" :"RECESSO"
};

// Função principal para mostrar select na célula
function mostrarSelect(td) {
    if (td.querySelector("select")) return;

    const valorAtual = td.getAttribute("data-codigo") || "";
    const select = criarSelect(valorAtual);

    td.innerHTML = "";
    td.appendChild(select);
    select.focus();

    select.addEventListener("blur", function () {
        const selecionado = select.options[select.selectedIndex];
        const codigo = selecionado.value;
        const descricao = selecionado.getAttribute("data-full");

        // Atualiza célula de assinatura
        td.innerHTML = `<span title="${descricao}"><b>${descricao}</b></span>`;
        td.setAttribute("data-codigo", codigo);

        // Atualiza coluna "cód"
        const tr = td.closest("tr");
        const tdCodigo = tr.querySelector("td.codigo");
        if (tdCodigo) tdCodigo.innerHTML = `<b>${codigo}</b>`;

        // Atualiza horários
        aplicarValorSelecionado(tr, descricao);
    });
}

// Cria o select com opções
function criarSelect(valorAtual) {
    const select = document.createElement("select");
    select.className = "form-control form-control-sm";
    select.style.overflow = "hidden";
    select.style.textOverflow = "ellipsis";

    Object.keys(opcoesAssinatura).forEach(codigo => {
        const option = document.createElement("option");
        option.value = codigo;               // código
        option.text = opcoesAssinatura[codigo]; // descrição/abreviação
        option.setAttribute("data-full", opcoesAssinatura[codigo]); // descrição completa
        if (codigo === valorAtual) option.selected = true;
        select.appendChild(option);
    });

    return select;
}


function atualizarAssinaturas(tr, valor) {
    const celulasAssinatura = tr.querySelectorAll("td[data-assinatura]");
    celulasAssinatura.forEach(cel => {
        cel.innerHTML = `<span title="${valor}"><b>${valor}</b></span>`;
    });
}

// Atualiza horários
function atualizarHorarios(tr, valor) {
    const colunasHorarios = [2, 3, 5, 6]; // índices das colunas de horários

    colunasHorarios.forEach(i => {
        const tdHorario = tr.children[i];
        if (!tdHorario) return;

        if (valor !== "") {
            tdHorario.innerHTML = "<b>----</b>";
        } else {
            const valorOriginal = tdHorario.getAttribute("data-horario") || "";
            tdHorario.innerHTML = `<b>${valorOriginal}</b>`;
        }
    });
}

// Função auxiliar
function aplicarValorSelecionado(tr, valorSelecionado) {
    atualizarAssinaturas(tr, valorSelecionado);

    if (valorSelecionado === "DOMINGO" || valorSelecionado === "SÁBADO") return;

    atualizarHorarios(tr, valorSelecionado);
}
</script>


</script>