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

    $dias_fim_semana = [
        "Saturday" => "SÁBADO",
        "Sunday" => "DOMINGO"
    ];
    $assinatura_servidor = $dias_fim_semana[$nome_dia_semana] ?? "";

    // verifica se o dia é feriado
    if (in_array($data_dia, $data_feriados)) {
        $assinatura_servidor = "FERIADO";
    }

    $is_dia_especial = in_array($assinatura_servidor, ["SÁBADO", "DOMINGO", "FERIADO"], true);
    $td_class = $is_dia_especial ? "final_semana" : "";


    // Horários
    if ($is_dia_especial) {
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
    echo "<td class='horario $td_class' $editable data-tipo='entrada' data-horario='$entrada'><b>$entrada</b></td>";
    echo "<td class='horario $td_class' $editable data-tipo='saida_almoco' data-horario='$saida_almoco'><b>$saida_almoco</b></td>";
    echo $assinatura_vespertino;
    echo "<td class='horario $td_class' $editable data-tipo='volta_almoco' data-horario='$volta_almoco'><b>$volta_almoco</b></td>";
    echo "<td class='horario $td_class' $editable data-tipo='saida' data-horario='$saida'><b>$saida</b></td>";
    echo "<td class='$td_class codigo'></td>";
    echo "</tr>";


    $data->modify('+1 day');
}

?>
<script>
    const opcoesAssinatura = {
        "": "",
        "219": "ABONO ANUAL",
        "340": "ATESTADO - COMPARECIMENTO",
        "310": "DOAÇÃO DE SANGUE",
        "313": "FALECIMENTO FAMÍLIA",
        "314": "A. JÚRI",
        "317": "A. CASAMENTO",
        "318": "TREINAMENTO/CURSO",
        "345": "ATESTADO DE ATÉ (03) DIAS",
        "118": "EXAME MÉDICO",
        "119": "FALTA INJUSTIFICADA",
        "594": "FÉRIAS",
        "211": "L. ADOÇÃO (07) DIAS",
        "207": "L. MATERNIDADE",
        "205": "L. MOTIVO DOENÇA FAMILIA",
        "339": "P. PARTERNIDADE (23) Dias",
        "258": "RECESSO"
    };

    const turnoMap = {
        1: [2, 3], // assinatura matutino => entrada, saida_almoco
        4: [5, 6]  // assinatura vespertino => volta_almoco, saida
    };


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

            td.innerHTML = `<span title="${descricao}"><b>${descricao}</b></span>`;
            td.setAttribute("data-codigo", codigo);


            const tr = td.closest("tr");
            const tdCodigo = tr.querySelector("td.codigo");
            if (tdCodigo) tdCodigo.innerHTML = `<b>${codigo}</b>`;


            aplicarValorSelecionado(tr, descricao, td);
        });
    }


    function criarSelect(valorAtual) {
        const select = document.createElement("select");
        select.className = "form-control form-control-sm";

        Object.keys(opcoesAssinatura).forEach(codigo => {
            const option = document.createElement("option");
            option.value = codigo;
            option.textContent = opcoesAssinatura[codigo];
            option.setAttribute("data-full", opcoesAssinatura[codigo]);
            if (codigo === valorAtual) option.selected = true;
            select.appendChild(option);
        });

        return select;
    }

    function atualizarAssinaturas(tr, valor, tdClicada) {
        const celulasAssinatura = tr.querySelectorAll("td[data-assinatura]");
        celulasAssinatura.forEach(cel => {
            if ((valor === "ATESTADO - COMPARECIMENTO" || valor === "TREINAMENTO/CURSO")) {
                if (tdClicada && cel === tdClicada) {
                    cel.innerHTML = `<span title="${valor}"><b>${valor}</b></span>`;
                }
            } else {
                cel.innerHTML = `<span title="${valor}"><b>${valor}</b></span>`;
            }
        });
    }

    // Atualiza horários de um turno
    // Função para atualizar horários com base no valor da assinatura
    function atualizarHorarios(tr, valor, indicesTurno) {
        indicesTurno.forEach(i => {
            const tdHorario = tr.children[i];
            if (!tdHorario) return;

            const valorOriginal = tdHorario.getAttribute("data-horario") || "";

            // prioridade 1: se coluna estiver "oculta manualmente", não mexe
            if (tdHorario.getAttribute("data-oculto") === "1") {
                tdHorario.innerHTML = "";
                return;
            }

            // prioridade 2: regras de assinatura
            if (valor === "ATESTADO - COMPARECIMENTO" || valor === "TREINAMENTO/CURSO") {
                tdHorario.innerHTML = "<b>-----</b>";
            } else if (valor !== "") {
                tdHorario.innerHTML = "<b>-----</b>";
            } else {
                tdHorario.innerHTML = `<b>${valorOriginal}</b>`;
            }
        });
    }

    // Clica no TH para ocultar/restaurar toda a coluna
    function toggleColunaHorario(index) {
        const linhas = document.querySelectorAll("table tbody tr");
        linhas.forEach(tr => {
            const td = tr.children[index];
            if (!td) return;

            // se for final de semana/feriado → não permite ocultar
            if (td.classList.contains("final_semana")) {
                td.innerHTML = "<b>-----</b>";
                td.removeAttribute("data-oculto");
                return;
            }

            const valorOriginal = td.getAttribute("data-horario") || "";

            if (td.getAttribute("data-oculto") === "1") {
                // restaurar
                td.removeAttribute("data-oculto");
                td.innerHTML = `<b>${valorOriginal}</b>`;
            } else {
                // ocultar
                td.setAttribute("data-oculto", "1");
                td.innerHTML = "";
            }
        });
    }



    function aplicarValorSelecionado(tr, valorSelecionado, tdClicada = null) {
        atualizarAssinaturas(tr, valorSelecionado, tdClicada);

        if (valorSelecionado === "DOMINGO" || valorSelecionado === "SÁBADO") return;

        if (tdClicada) {
            const sigCol = Array.prototype.indexOf.call(tr.children, tdClicada);
            const indicesTurno = turnoMap[sigCol] || [];
            atualizarHorarios(tr, valorSelecionado, indicesTurno);
        } else {

            atualizarHorarios(tr, valorSelecionado, [2, 3, 5, 6]);
        }
    }

</script>