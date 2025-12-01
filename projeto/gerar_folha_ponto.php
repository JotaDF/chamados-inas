<?php
include('./actions/ManterFeriadoAno.php');

$manterFeriadoAno = new ManterFeriadoAno();
$feriados = $manterFeriadoAno->lista();

$numero_mes = $_GET['numero_mes'];
$horarios = explode(";", $usuario->horario);
$data = new DateTime("$ano-$numero_mes-01");
$ultimo_dia = (clone $data)->modify('last day of this month')->format('d');

// Horário padrão do servidor
list($entrada_default, $saida_almoco_default, $volta_almoco_default, $saida_default) = $horarios;

// Prepara lista de feriados
$data_feriados = [];
foreach ($feriados as $f) {
    $data_feriados[$f->data] = $f->descricao;
}

for ($i = 1; $i <= $ultimo_dia; $i++) {

    $numero_dia = sprintf('%02d', $i);
    $data_dia = $data->format('Y-m-d');
    $assinatura_servidor = "";
    $td_class = "";

    // Dia da semana
    $diaNum = (int) $data->format('N');
    $dias_fim_semana = [6 => "SÁBADO", 7 => "DOMINGO"];

    // Por padrão  editáveis
    $editable_matutino = "onclick='mostrarSelect(this)' data-assinatura";
    $editable_vespertino = "onclick='mostrarSelect(this)' data-assinatura";
    $classe_dia = "";
    $editable = "";
    [$entrada, $saida_almoco, $volta_almoco, $saida] = $horarios;


    // -------------------- FIM DE SEMANA --------------------
    if (isset($dias_fim_semana[$diaNum])) {

        $assinatura_servidor = $dias_fim_semana[$diaNum];

        $classe_dia = "dia_cinza";
        $td_class = "final_semana";

        $entrada = $saida_almoco = $volta_almoco = $saida = "-----";

        $editable_matutino = "";
        $editable_vespertino = "";
        $editable = "";
        $matutino_class = "final_semana";
        $vespertino_class = "final_semana";

    // ---------------------- FERIADO / PONTO FACULTATIVO / VÉSPERA ----------------------
    } elseif (!empty($data_feriados) && array_key_exists($data_dia, $data_feriados)) {

        $descricao = strtolower($data_feriados[$data_dia]);
        $classe_dia = "dia_cinza";

        // ----------- VÉSPERA (detecta "após") -----------
        if (strpos($descricao, "após") !== false) {

            $assinatura_servidor = "PONTO FACULTATIVO";

            // Matutino normal (editável)
            $entrada = $entrada_default;
            $saida_almoco = $saida_almoco_default;
            $matutino_class = "";
            $editable_matutino = "onclick='mostrarSelect(this)' data-assinatura";
            $saida_almoco = "14:00";

            // Vespertino bloqueado
            $volta_almoco = $saida = "-----";
            $vespertino_class = "final_semana";
            $editable_vespertino = "";
            $td_class_vespertino = "final_semana";
            $editable = "contenteditable=true";

        } else {

            // Feriado ou ponto facultativo completo
            $assinatura_servidor =
                strpos($descricao, "facultativo") !== false
                ? "PONTO FACULTATIVO "
                : "FERIADO";

            $td_class = "final_semana";
            
            $entrada = $saida_almoco = $volta_almoco = $saida = "-----";

            $editable_matutino = "";
            $editable_vespertino = "";

            $matutino_class = "final_semana";
            $vespertino_class = "final_semana";
        }

    // ---------------------- DIA NORMAL ----------------------
    } else {

        $assinatura_servidor = "";

        $entrada = $entrada_default;
        $saida_almoco = $saida_almoco_default;
        $volta_almoco = $volta_almoco_default;
        $saida = $saida_default;

        $matutino_class = "";
        $vespertino_class = "";
        $editable = "contenteditable='true'";
        $classe_dia = ""; // dia normal = sem cinza
    }

    // -------------------- RENDERIZAÇÃO --------------------
    echo "<tr>";

    // Número do dia
    echo "<td class='$td_class $classe_dia'><b>$numero_dia</b></td>";

    // Assinatura matutina
    echo "<td class='$td_class' $editable_matutino><b>";
    if ($assinatura_servidor !== "PONTO FACULTATIVO") {
        echo $assinatura_servidor;
    }
    echo "</b></td>";

    // Horário matutino (sem select!)
    echo "<td class='horario $matutino_class' $editable  data-tipo='entrada' data-horario='$entrada'><b>$entrada</b></td>";
    echo "<td class='horario $matutino_class'  $editable data-tipo='saida_almoco' data-horario='$saida_almoco'><b>$saida_almoco</b></td>";

    // Assinatura vespertina
    if ($assinatura_servidor === "PONTO FACULTATIVO") {
        echo "<td class='final_semana'><b>PONTO FACULTATIVO</b></td>"; // vespertino bloqueado
    } else {
        echo "<td class='$td_class' $editable_vespertino><b>$assinatura_servidor</b></td>";
    }

    // Horários vespertinos (sem select!)
    echo "<td class='horario $vespertino_class'  $editable  data-tipo='volta_almoco' data-horario='$volta_almoco'><b>$volta_almoco</b></td>";
    echo "<td class='horario $vespertino_class'  $editable  data-tipo='saida' data-horario='$saida'><b>$saida</b></td>";

    echo "<td class='codigo'></td>";
    echo "</tr>";

    $data->modify('+1 day');
}

?>
<script>
    const opcoesAssinatura = {
        "1": "-------||LIMPAR||-------",
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
        "258": "RECESSO",
        "400": "QUARTA FEIRA DE CINZAS"
    };

    // Mapeamento do turno: coluna assinatura => índices de horário
    const turnoMap = {
        1: [2, 3], // matutino
        4: [5, 6]  // vespertino
    };

    // Função chamada quando o usuário clica em uma célula para exibir um <select>
    function mostrarSelect(td) {
        // Se já existir um <select> dentro da célula, não faz nada
        if (td.querySelector("select")) return;

        // Pega os valores atuais da célula
        const valorAtual = td.getAttribute("data-codigo") || ""; // código armazenado em atributo
        const descricaoAtual = td.textContent || ""; // texto mostrado

        // Cria o <select> com a opção atual
        const select = criarSelect(valorAtual);

        // Limpa a célula e insere o <select>
        td.innerHTML = "";
        td.appendChild(select);
        select.focus(); // foca no select automaticamente

        // Evento disparado quando o select perde o foco
        select.addEventListener("blur", function () {
            const selecionado = select.options[select.selectedIndex]; // opção escolhida
            const codigo = selecionado.value;
            const descricao = selecionado.getAttribute("data-full");

            const tr = td.closest("tr"); // linha da tabela
            const tdCodigo = tr.querySelector("td.codigo"); // célula que exibe o código


            if (descricao !== "") {
                // Atualiza célula e código com a nova escolha
                td.innerHTML = `<span title="${descricao}"><b>${descricao}</b></span>`;
                td.setAttribute("data-codigo", codigo);

                if (tdCodigo) tdCodigo.innerHTML = `<b>${codigo}</b>`;

                aplicarValorSelecionado(tr, descricao, td);
            } else {
                // Se o usuário escolheu vazio, mantém os valores antigos
                td.innerHTML = `<span title="${descricaoAtual}"><b>${descricaoAtual}</b></span>`;
                td.setAttribute("data-codigo", valorAtual);

                if (tdCodigo) tdCodigo.innerHTML = `<b>${valorAtual}</b>`;
            }
        });
    }

    // Cria o <select> com todas as opções possíveis
    function criarSelect(valorAtual) {
        const select = document.createElement("select");
        select.className = "form-control form-control-sm";
        select.style.overflow = "hidden";
        select.style.textOverflow = "ellipsis";

        const optionVazio = document.createElement("option");
        optionVazio.value = "";
        optionVazio.text = ""; // ou "" se preferir
        optionVazio.setAttribute("data-full", "");
        if (valorAtual === "") optionVazio.selected = true;
        select.appendChild(optionVazio);
        Object.keys(opcoesAssinatura).forEach(codigo => {
            const option = document.createElement("option");
            option.text = opcoesAssinatura[codigo];
            option.setAttribute("data-full", opcoesAssinatura[codigo]);

            // Se for a opção de limpar, o value fica vazio
            if (codigo === "1") {
                option.value = "";
            } else {
                option.value = codigo;
            }

            if (codigo === valorAtual) option.selected = true;
            select.appendChild(option);
        });

        return select;
    }

    // Atualiza todas as células de assinatura da linha
    function atualizarAssinaturas(tr, valor, tdClicada = null) {
        const celulasAssinatura = tr.querySelectorAll("td[data-assinatura]");

        // Se for um valor "especial", atualiza só a célula clicada
        if (valor === "ATESTADO - COMPARECIMENTO" || valor === "TREINAMENTO/CURSO" || valor === "QUARTA FEIRA DE CINZAS") {
            if (tdClicada) {
                tdClicada.innerHTML = `<span title="${valor}"><b>${valor}</b></span>`;
            }
        } else {
            // Senão, aplica o valor em todas as células da linha
            celulasAssinatura.forEach(cel => {
                cel.innerHTML = `<span title="${valor}"><b>${valor}</b></span>`;
            });
        }

        // Se for "limpar", apaga todas as células
        if (valor === "-------||LIMPAR||-------") {
            if (tdClicada) {
                celulasAssinatura.forEach(cel => {
                    cel.innerHTML = `<span title=""><b></b></span>`;
                })
            }
        }
    }

    // Atualiza os horários de acordo com o valor selecionado
    function atualizarHorarios(tr, valor, colunas) {
        colunas.forEach(i => {
            const tdHorario = tr.children[i];
            if (!tdHorario) return;

            switch (valor) {
                case "-------||LIMPAR||-------":
                    // Restaura o horário original salvo em data-horario
                    const valorOriginal = tdHorario.getAttribute("data-horario") || "";
                    tdHorario.innerHTML = `<b>${valorOriginal}</b>`;
                    break;
                case (valor === "ATESTADO - COMPARECIMENTO" || valor === "TREINAMENTO/CURSO" || valor === "TREINAMENTO/CURSO"):
                    // Para casos especiais, mostra traço
                    tdHorario.innerHTML = "<b>-----</b>";
                    break;
                default:
                    // Para qualquer outro, também mostra traço
                    tdHorario.innerHTML = "<b>-----</b>";
                    break;
            }
        });
    }

    // Aplica as regras de alteração de assinaturas e horários
    function aplicarValorSelecionado(tr, valorSelecionado, tdClicada = null) {
        atualizarAssinaturas(tr, valorSelecionado, tdClicada);

        // Se for final de semana, não altera horários
        if (["DOMINGO", "SÁBADO"].includes(valorSelecionado)) return;

        const isEspecial = valorSelecionado === "ATESTADO - COMPARECIMENTO" || valorSelecionado === "TREINAMENTO/CURSO" || valorSelecionado === "QUARTA FEIRA DE CINZAS";

        if (tdClicada) {
            // Descobre a posição da célula clicada dentro da linha
            const sigCol = Array.prototype.indexOf.call(tr.children, tdClicada);

            switch (valorSelecionado) {
                case "LIMPAR":
                    // Se for "LIMPAR", restaura os horários padrão das colunas fixas
                    atualizarHorarios(tr, valorSelecionado, [2, 3, 5, 6]);
                    break;
                default:
                    if (isEspecial) {
                        // Para valores especiais, usa o mapeamento de colunas (turnoMap)
                        const indicesTurno = turnoMap[sigCol] || [];
                        atualizarHorarios(tr, valorSelecionado, indicesTurno);
                    } else {
                        // Para qualquer outro valor, atualiza sempre as colunas fixas
                        atualizarHorarios(tr, valorSelecionado, [2, 3, 5, 6]);
                    }
                    break;
            }
        } else {
            // Se nenhuma célula foi clicada diretamente, aplica nos horários padrão
            atualizarHorarios(tr, valorSelecionado, [2, 3, 5, 6]);
        }

    }

    // Adiciona evento nos cabeçalhos da tabela para mostrar/ocultar horários
    document.querySelectorAll("#folha_pontos thead tr:nth-child(2) th").forEach((th, index) => {
        th.addEventListener("click", () => {
            const linhas = document.querySelectorAll("#folha_pontos tbody tr");

            linhas.forEach(tr => {
                const td = tr.children[index];
                if (!td || !td.classList.contains('horario') || td.textContent === "-----") return;

                // Alterna entre mostrar o horário original ou esconder
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
    document.addEventListener('click', function (ev) {
        const td = ev.target.closest && ev.target.closest('td[data-assinatura]');
        if (!td) return;

        if (td.querySelector('select')) return;
        if (td.classList.contains('bloqueado')) return;

        mostrarSelect(td);
    });


</script>