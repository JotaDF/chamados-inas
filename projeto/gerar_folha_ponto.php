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

    // Função principal para mostrar select na célula
    // Mapeamento do turno: coluna assinatura => índices de horário
    const turnoMap = {
        1: [2, 3], // matutino
        4: [5, 6]  // vespertino
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

            const sigCol = Array.prototype.indexOf.call(tr.children, td);
            const isTurnoEspecial = descricao === "ATESTADO - COMPARECIMENTO" || descricao === "TREINAMENTO/CURSO";

            if (descricao === "") {
                // 🔹 Restaurar os horários originais
                [2, 3, 5, 6].forEach(i => {
                    const tdHorario = tr.children[i];
                    if (tdHorario) {
                        tdHorario.innerHTML = `<b>${tdHorario.getAttribute("data-horario") || ""}</b>`;
                    }
                });
            } else if (isTurnoEspecial) {
                // 🔹 Apenas colunas do turno clicado
                const indicesTurno = turnoMap[sigCol] || [];
                indicesTurno.forEach(i => {
                    const tdHorario = tr.children[i];
                    if (tdHorario) tdHorario.innerHTML = "<b>-----</b>";
                });
            } else {
                // 🔹 Todas as colunas de horário recebem traço
                [2, 3, 5, 6].forEach(i => {
                    const tdHorario = tr.children[i];
                    if (tdHorario) tdHorario.innerHTML = "<b>-----</b>";
                });
            }
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
            option.value = codigo;
            option.text = opcoesAssinatura[codigo];
            option.setAttribute("data-full", opcoesAssinatura[codigo]);
            if (codigo === valorAtual) option.selected = true;
            select.appendChild(option);
        });

        return select;
    }

    function atualizarAssinaturas(tr, valor, tdClicada = null) {
        const celulasAssinatura = tr.querySelectorAll("td[data-assinatura]");

        celulasAssinatura.forEach(cel => {
            if (valor === "ATESTADO - COMPARECIMENTO" || valor === "TREINAMENTO/CURSO") {
                // Atualiza só a célula clicada, preservando a outra
                if (tdClicada && cel === tdClicada) {
                    cel.innerHTML = `<span title="${valor}"><b>${valor}</b></span>`;
                    cel.setAttribute("data-codigo", cel.getAttribute("data-codigo") || "");
                }
            } else {
                // Comportamento padrão: todas as assinaturas recebem o mesmo valor
                cel.innerHTML = `<span title="${valor}"><b>${valor}</b></span>`;
                cel.setAttribute("data-codigo", cel.getAttribute("data-codigo") || "");
            }
        });
    }



    // Atualiza horários de uma linha, apenas nas colunas indicadas
    function atualizarHorarios(tr, valor, colunas) {
        colunas.forEach(i => {
            const tdHorario = tr.children[i];
            if (!tdHorario) return;

            if (valor === "ATESTADO - COMPARECIMENTO" || valor === "TREINAMENTO/CURSO") {
                tdHorario.innerHTML = "<b>-----</b>";
                return;
            }

            // Restaurar valores originais se valor não especial
            const valorOriginal = tdHorario.getAttribute("data-horario") || "";
            tdHorario.innerHTML = `<b>${valorOriginal}</b>`;
        });
    }



    function aplicarValorSelecionado(tr, valorSelecionado, tdClicada = null) {
        atualizarAssinaturas(tr, valorSelecionado, tdClicada);

        if (valorSelecionado === "DOMINGO" || valorSelecionado === "SÁBADO") return;

        const isEspecial = valorSelecionado === "ATESTADO - COMPARECIMENTO" || valorSelecionado === "TREINAMENTO/CURSO";

        if (tdClicada) {
            const sigCol = Array.prototype.indexOf.call(tr.children, tdClicada);
            if (isEspecial) {
                const indicesTurno = turnoMap[sigCol] || [];
                atualizarHorarios(tr, valorSelecionado, indicesTurno);
            }
        } else if (isEspecial) {
            atualizarHorarios(tr, valorSelecionado, [2, 3, 5, 6]);
        }
    }


    document.querySelectorAll("#folha_pontos thead tr:nth-child(2) th").forEach((th, index) => {
        th.addEventListener("click", () => {
            const linhas = document.querySelectorAll("#folha_pontos tbody tr");

            linhas.forEach(tr => {
                const td = tr.children[index];
                if (!td || !td.classList.contains('horario') || td.textContent === "-----") return;

                if (td.textContent === "") {
                    td.innerHTML = `<b>${td.dataset.horario || ""}</b>`;
                    th.title = "Remover horários";
                } else {
                    td.textContent = "";
                    th.title = "Carregar horários";
                }
            });
        });
    });

</script>