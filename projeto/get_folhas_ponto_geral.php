<?php

include_once('actions/ManterUsuario.php'); 
$manterUsuario = new ManterUsuario();

$meses = array(
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março', 
    '04' => 'Abril', 
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
);


if($usuario->id > 0){
    $ano = date('Y');
    $txt_matricula = "0" . strtoupper(str_replace("-", "", $usuario->matricula));
    $mes_atual = date('n');
    foreach ($meses as $numero_mes => $nome_mes) {
        // $arquivo = "ponto/$ano/$numeroMes/0104198.pdf";
        
        echo "<tr>";
        echo "  <td>$ano</td>";
        echo "  <td>$nome_mes</td>";
        
        if ($numero_mes <= $mes_atual) {
            echo "  <td align='center'>
                    <a class='btn btn-danger btn-sm' target='_blank' 
                        href='./folha_ponto.php?id=$usuario->id&ano=$ano&numero_mes=$numero_mes&nome_mes=$nome_mes'>
                        <i class='fa fa-clock text-white'></i>
                    </a>
                </td>";
        } else {
            echo "  <td align='center'> - </td>";                
        }
        
        echo "</tr>";
    }
}