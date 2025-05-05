<?php
 $meses = array('Janeiro',
                'Fevereiro',
                'Março', 
                'Abril', 
                'Maio',
                'Junho',
                'Julho',
                'Agosto',
                'Setembro',
                'Outubro',
                'Novembro',
                'Dezembro');
        
        for($i = 0; $i < count($meses);$i++) {
            $txt_mes = "";
            if($i < 9){
                $txt_mes = "0" . ($i+1);
            } else {
                $txt_mes = "" . ($i+1);
            }
            $txt_matricula = "0" . strtoupper(str_replace("-", "", $usuario_logado->matricula));
            $arquivo = "ponto/".date('Y')."/".$txt_mes."/".$txt_matricula.".pdf";
            //echo "Arquivo: " . $arquivo;
            //echo "<hr/> " . is_file($arquivo);

            echo "<tr>";
            echo "  <td>".date('Y')."</td>";
            echo "  <td>".$meses[$i]."</td>";
            if(is_file($arquivo)){
                echo "  <td align='center'><a class='btn btn-danger btn-sm' target='_blank' href='./ponto/".date('Y')."/".$txt_mes."/".$txt_matricula.".pdf'><i class='fa fa-file-pdf text-white'></i></a></td>";
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }

