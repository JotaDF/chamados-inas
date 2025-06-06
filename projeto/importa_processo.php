<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$dados = array(
    array('22/01/2021','0700216-59.2021.8.07.0018','04001-00000041/2021-99','HELVECIO DE MENDONCA ARAUJO','HOME CARE','3','162.683.001-06','','1','R$ 50.000,00'),
    array('26/01/2021','0703967-60.2021.8.07.0016','00020-00010642/2021-85','PAULO SERGIO BENEDITO DOS SANTOS','TERAPIA HIPERBÁRICA','3','461.250.351-15','','1','R$ 50.000,00'),
    array('26/01/2021','0700267-70.2021.8.07.0018','00020-00010642/2021-85','PAULO SERGIO BENEDITO DOS SANTOS','TERAPIA HIPERBÁRICA','3','461.250.351-15','','2','R$ 100,00'),
    array('11/02/2021','0703590-31.2021.8.07.0003','04001-00000120/2021-08','MARIA MADALENA ALVES CAMPELO LIMA','TRANSLADO','3','050.198.341-49','','1','R$ 100,00'),
    array('03/03/2021','0701208-20.2021.8.07.0018','04001-00000150/2021-14','SANTIAGO BARRETO NASCIMENTO GONTIJO e RAQUEL MARTINS BORGES CARVALHOS','MEDICAMENTO/QUIMIOTERAPIA','3','086087091-04','','1','R$ 152.058,60'),
    array('11/03/2021','0712843-04.2021.8.07.0016','00020-00014345/2021-17','BRUNO PASSOS DE SOUZA CARNEIRO','COBRANÇA','3','644.366.675-53','','1','R$ 2.605,68'),
    array('01/01/2021','0715827-58.2021.8.07.0016','','ALINE DE ABREU MEIRELES','CADASTRO/ DEPENDENTE','3','026.484.081-00','','2',''),
    array('25/03/2021',' 0721517-10.2021.8.07.0003','00020-00015942/2021-51','FLAVIANA DE MOURA FARIAS','CADASTRO/ DEPENDENTE','3','705.637.131-00','','2','R$ 1.000,00'),
    array('29/03/2021','0717126-70.2021.8.07.0016','00020-00014132/2022-68, 00401-00005141/2021-48','PRISCILLA FAVA DE SOUSA','EXAME/PCR','3','954.911.041-91','','1','R$ 20.000,00'),
    array('30/03/2021','0717420-25.2021.8.07.0016','0717420-25.2021.8.07.0016','OTACILIO CUNHA AGUIAR','CIRURGIA/FACECTOMIA/LENTE INTRA-OCULAR','3','038190351-68','','1','R$ 30.000,00'),
    array('02/04/2021','0703908-05.2021.8.07.0006','04001-00000190/2021-58','ELI BUSSINGUER','INTERNAÇÃO HOSPITALAR','3','008.142.881-20','','1','R$ 48.000,00'),
    array('07/04/2021','0718949-79.2021.8.07.0016','00020-00045510/2022-55','GIRLENE BATISTA DE BRITO','EXAME/PET-TC','3','540.117.521-34','','1','R$ 1.089,40'),
    array('14/04/2021','0705300-35.2021.8.07.0020','04001-00000229/2021-37','JAIME AUREO RAMOS','EXAME/RESSONÂNCIA E BIÓPSIA','3',' 224.357.001-72','','2','R$ 3.000,00 '),
    array('15/04/2021','0705366-15.2021.8.07.0020','00020-00016224/2021-00','JAIME AUREO RAMOS','EXAME/RESSONÂNCIA MAGNÉTICA E BIÓPSIA DE PRÓSTATA','3','224.357.001-72','','1','R$ 3.000,00'),
    array('24/04/2021','0702583-56.2021.8.07.0018','04001-00000234/2021-40','MARIA EDNA RIBEIRO','INTERNAÇÃO HOSPITALAR','3','119.433.861-53','- ','1','R$ 30.000,00'),
    array('26/04/2021','0723285-29.2021.8.07.0016','00401-00002383/2021-80','ADILSON CARDOSO SILVA','RESSARCIMENTO/ MENSALIDADE','3','223.788.041-72','','1','R$ 829,44'),
    array('30/04/2021','0714170-29.2021.8.07.0001','00020-00017328/2021-23','VANESSA CORVINO FERNANDES BARBOSA','MEDICAMENTO/INSUMOS','3','019.015.901-43','','1','R$ 39.285,36'),
    array('01/05/2021','0724332-38.2021.8.07.0016','','TEREZINHA GUEDES DE OLIVEIRA','MEDICAMENTO/Kisqali','3','281.761.381-34','','1','R$ 1.000,00'),
    array('03/05/2021','0724566-20.2021.8.07.0016','00020-00018734/2021-11','ANNE GERYMAIA OLIVEIRA DE MELO SILVA','RESSARCIMENTO/ MENSALIDADE','3','636.091.851-04','','2','R$ 1.969,27'),
    array('07/05/2021','0702914-38.2021.8.07.0018','04001-00000084/2021-74','SINDICATO DOS SERV.PUBLICOS CIVIS DA ADM.DIR AUT.FUND. E TCDF','REVISÃO SALARIAL DOS SERVIDORES AUTÁRQUICOS','3','03.657.368/0001-15','','1','R$ 100.000,00'),
    array('24/05/2021','0728395-09.2021.8.07.0016','00020-00021582/2021-26','MARIA AMELIA TAVARES MIRANDA DE OLIVEIRA','RESSARCIMENTO/ MENSALIDADE','3','097.855.401-97','','2','R$ 2.720,00'),
    array('25/05/2021','0728586-54.2021.8.07.0016','00020-00025080/2021-74','ANA CECILIA SCHLOTTFELDT FAGUNDES','RESSARCIMENTO/ MENSALIDADE','3','185.742.461-15','','2','R$ 7.713,00'),
    array('16/06/2021','0703902-59.2021.8.07.0018','04001-00000386/2021-42','SISSA DE ASSIS PASSOS SILVA','MEDICAMENTO/ QUIMIOTERAPIA','3','021.382.951-76','','1','R$ 91.030,84'),
    array('22/06/2021','0704003-96.2021.8.07.0018','00020-00019166/2023-20','ELIAS SANTANA LEITÃO','HOME CARE','3','042.863.591-15','','1','R$ 568,58'),
    array('24/06/2021','0734261-95.2021.8.07.0016','00020-00009483/2022-57','LUCIMARY VINHA DO VALLE','RESSARCIMENTO/ MENSALIDADE','3','267.339.781-72','','1','R$ 6.466,68'),
    array('24/06/2021','0709732-97.2021.8.07.0020','00020-00023840/2021-17','ERIKA DINIZ DE ALMEIDA CAMPOS OLIVEIRA','CIRURGIA/NEFRECTOMIA RADICAL UNILATERAL POR LAPAROSCOPIA','3','932.203.911-68','','1','R$ 15.000,00'),
    array('25/06/2021','0734448-06.2021.8.07.0016','00020-00009836/2022-19','JUCELIA NATIVIDADE ROCHA ECA','CIRURGIA/NEFRECTOMIA ','3','539.039.001-68','','1','R$ 10.000,00'),
    array('02/07/2021','0704315-72.2021.8.07.0018','00020-00026389/2021-81','CLAUDIO ROBERTO SILVA DA VEIGA','TRANSPLANTE/ TCO','3','552.401.941-49','','1','R$ 30.000,00'),
    array('02/07/2021','0703757-21.2021.8.07.0012','00020-00026810/2021-54','FRANCIMAR VIEIRA DE SA PASSOS','MEDICAMENTO/ QUIMIOTERAPIA','3','239.924.683-72','','1','R$ 13.020,00'),
    array('12/07/2022','0711511-59.2022.8.07.0018','00020-00032749/2022-65','MARINA DE JONGH ROCHA','TEA/ TERAPIAS','3','113.304.161-20','','','R$ 8.130,00'),
    array('15/07/2021','0737755-65.2021.8.07.0016','00020-00036038/2021-89','FRANCISCO DE ASSIS XAVIER DA SILVA','CIRURGIA/ ROBÓTICA','3','875.803.061-15','','1','R$ 2.500,00'),
    array('24/07/2021','0713030-39.2021.8.07.0007','00020-00032709/2021-32','JOSEFA RAMOS DE OLIVEIRA SILVA e FRANCISCO ADELINO DA SILVA','HOME CARE','3','376.670.921-68','','1','R$ 36.875,04'),
    array('26/07/2021','0739490-36.2021.8.07.0016','00020-00002890/2023-14','FRANCISCO ALVES COSTA FILHO','CIRURGIA/ PROSTATECTOMIA','3','365.126.721-00','','1','R$ 47.309,50'),
    array('26/07/2021','0704901-12.2021.8.07.0018','00020-00015599/2022-25','FRANCISCA ALVIDIO CAMPOS','MEDICAMENTO/XELODA/CETUXIMABE','3','002.796.751-43','','1','R$ 80.000,00'),
    array('30/07/2021','0705027-62.2021.8.07.0018','00020-00029072/2021-05','VANESSA RODRIGUES DA SILVA','MEDICAMENTO/ Doxorrubicina/
    Ciclofosfamida/Neulastin','3','000.347.571-98','','2','R$ 91.030,84'),
    array('11/08/2021','0742930-40.2021.8.07.0016','00020-00032061/2021-02','LUZIA FREITAS DA SILVA','CADASTRO/ DEPENDENTE','3','605.421.521-34','','2','R$ 4.800,00'),
    array('13/08/2021','0708962-55.2021.8.07.0004','00020-00032571/2021-71','CLEONICE DE ALMEIDA SOUSA','MEDICAMENTO/QUIMIOTERAPIA','3','296.295.191-00','','2','R$ 30.000,00'),
    array('13/08/2021','0705475-35.2021.8.07.0018','00020-00032571/2021-71','CLEONICE DE ALMEIDA SOUSA','MEDICAMENTO/QUIMIOTERAPIA','3','296.295.191-00','','1','R$ 30.000,00'),
    array('13/08/2021','0705487-49.2021.8.07.0018','00020-00031052/2021-96','MARCELO AUGUSTO SIQUEIRA TOSTA','HOME CARE','3','063.366.081-74','','1','R$ 70.000,00'),
    array('27/08/2021','0746463-07.2021.8.07.0016','00020-00033900/2021-00','MARIA MADALENA BALBINO SOUZA RODRIGUES','MEDICAMENTO/ÁCIDO ZOLEDRÓNICO','3','113.613.521-91','','1','R$ 2.000,00'),
    array('31/08/2021','0746962-88.2021.8.07.0016','00020-00055239/2023-47','MARCIO CERRI','MEDICAMENTO/ Gemzar, Taxotere, Kytril','3','747.294.038-00','','1','R$ 15.412,35'),
    array('03/09/2021','0747793-39.2021.8.07.0016','00060-00407953/2021-14','MARIA EUNICE DE PAIVA FERREIRA NOVAIS','MEDICAMENTO/Flebogamma/Azacitina/Granulokine','3','645.929.441-00','','1','R$ 3.000,00'),
    array('03/09/2021','0747956-19.2021.8.07.0016','04001-00000553/2021-55','PEDRO LETTIERI JUNIOR','CIRURGIA/HEPATECTOMIA PARCIAL E COLECISTECTOMIA POR VIDEOLAPAROSCOPIA','3','073.186.501-49','','1','R$ 1.000,00'),
    array('10/09/2021','0748693-22.2021.8.07.0016','','ALENIR GONCALVES DE MELO','MEDICAMENTO/TECENTRIQ/AVASTIN','3','183.368.761-20','','1','R$ 1.000,00'),
    array('12/09/2021','0706712-07.2021.8.07.0018','00020-00037422/2021-07','ONILTON CAMBRAIA DA FONSECA','HOME CARE','3','093.245.851-34','','1','R$ 50.000,00'),
    array('14/09/2021','0706760-63.2021.8.07.0018','04001-00000564/2021-35','ANA CAROLINA ALVES DE SOUZA','CADASTRO/ DEPENDENTE','3','747.882.481-15','','1','R$ 3.300,00'),
    array('14/09/2021','0749197-28.2021.8.07.0016','00020-00036730/2021-15','ALENIR GONCALVES DE MELO','MEDICAMENTO/TECENTRIQ/AVASTIN','3','183.368.761-20','','1','R$ 1.000,00'),
    array('14/09/2021','0710127-40.2021.8.07.0004','','CRISTIANO TORRES DANTAS','EXAME/ COVID','3','857.687.581-00','','2','R$ 10.000,00'),
    array('21/09/2021','0707038-64.2021.8.07.0018','','MARCIA MELNEK','CIRURGIA/ BUCOMAXILO','3','042.066.779-21','','2','R$ 50.000,00'),
    array('22/09/2021','0711033-24.2021.8.07.0006','00020-00039092/2021-86','GLAUCIA GISELLE DE OLIVEIRA CAMPOS DE MENEZES','CIRURGIA/MASTECTOMIA','3','789.338.389-53','','2','R$ 30.000,00'),
    array('23/09/2021','0707179-83.2021.8.07.0018','','GILDETE NUNES FIGUEIREDO','HOME CARE','3','220.441.671-15','','2','R$ 25.000,00'),
    array('23/09/2021','0751012-60.2021.8.07.0016','','ARDUINO RODRIGUES DE MATOS','HOME CARE','3','086087091-04','','2','R$ 50.000,00'),
    array('23/09/2021','0707237-86.2021.8.07.0018','04001-00000596/2021-31','ARDUINO RODRIGUES DE MATOS','HOME CARE','3','086087091-04','','1','R$ 50.000,00'),
    array('27/09/2021','0707412-80.2021.8.07.0018','00020-00040198/2021-22','JOSE DE OLIVEIRA GAMA','HOME CARE','3','033.452.111-49','','2','R$ 20.100,00'),
    array('28/09/2021','0733993-86.2021.8.07.0001','00020-00055284/2022-11','DINARTE MARIA BOMFIM DE OLIVEIRA','MEDICAMENTO/Ácido Zolendrônico','3','120.422.341-68','','1','R$ 18.000,00'),
    array('30/09/2021','0752261-46.2021.8.07.0016','04001-00000594/2021-41','VALDECI DA SILVA MONTEIRO','INTERNAÇÃO/ UTI','3','153.413.801-34','','1','R$ 1.000,00'),
    array('01/10/2021','0752588-88.2021.8.07.0016','','LUÍS FRANCISCO COSTA MENEZES','EXAME/PET-CT','3','539.318.311-91','','2','R$ 6.000,00'),
    array('01/10/2021','0752589-73.2021.8.07.0016','00020-00040799/2021-35','PRISCILLA FAVA DE SOUSA','EXAME/PCR/MEDULA','3','954.911.041-91','','1','R$ 1.100,00'),
    array('01/10/2021','0752610-49.2021.8.07.0016','00020-00040803/2021-65','LUÍS FRANCISCO COSTA MENEZES','EXAME/PET-CT','3','539.318.311-91','','1','R$ 740,62'),
    array('07/10/2021','0707758-31.2021.8.07.0018','00020-00041689/2021-91','LUCIA DE FATIMA TEIXEIRA ALVES','MEDICAMENTO/AXITINIBE','3','287.017.201-04','','1','R$ 30.000,00'),
    array('08/10/2021','0753987-55.2021.8.07.0016','00020-00043038/2021-35','MARIA AMELIA TAVARES MIRANDA DE OLIVEIRA','RESSARCIMENTO/ MENSALIDADE','3','097.855.401-97','','2','R$ 2.720,00'),
    array('16/10/2021','0755051-03.2021.8.07.0016','00020-00042869/2021-90','ROSANGELA RITA GUIMARAES DIAS VIEIRA','CIRURGIA/hemostasias de cólon','3','170.728.832-15','','1','R$ 21.682,59'),
    array('22/10/2021','0718654-69.2021.8.07.0007','04001-00000636/2021-44','MARCELO BORGES FILHO','ONCOLOGICO/CARÊNCIA','3','076.509.061-91','','1','R$ 1.000,00'),
    array('03/11/2021','0708424-32.2021.8.07.0018','00020-00046973/2021-53','ANAIR RODRIGUES DE BARROS','HOME CARE','3','042.772.871-15','','1','R$ 10.000,00'),
    array('03/11/2021','0708450-30.2021.8.07.0018','04001-00000701/2021-31','RAUL DE OLIVEIRA VILARDI BORGES*','TEA/TERAPIAS','3','103.723.271-25','','1','R$ 64.069,76'),
    array('09/11/2021','0708628-76.2021.8.07.0018','00020-00047420/2021-18','RUBENS JOSE CARNEIRO','HOME CARE','3','077.365.921-87','','1','R$ 314.678,00'),
    array('18/11/2021','0708990-78.2021.8.07.0018','00020-00047167/2021-01','ELCY GOMES WINTHER NEVES e outros (4) *','MEDICAMENTO/ TOCILUZIMABE','1','504.834.801-00','','','R$ 12.183,00'),
    array('26/11/2021','0741681-02.2021.8.07.0001','04001-00000767/2021-21, 00020-00047167/2021-01','VARILANDES GONCALVES','CIRURGIA/ Valvar Tricúspide
    por Implante de MITRACLIP','3','009.224.981-72','','1','R$ 15.000,00'),
    array('26/11/2021','0741685-39.2021.8.07.0001','00020-00048415/2021-22','WANDERLEY LEAL CHAGAS','EXAME/PET-SCAN','3','098.666.391-34','','1','R$ 11.000,00'),
    array('06/12/2021','0704003-96.2021.8.07.0018','00020-00004443/2023-08','SONIA SUELI DE JESUS DA SILVA','MEDICAMENTO/ DOCETAXEL/ CARBOPLATINA/ PERTUZUMABE/ TRASTUZUMABE e NEULASTIN','3','398.165.321-15','','1','R$ 2.250,00'),
    array('08/12/2021','0714357-22.2021.8.07.0006','00020-00012488/2022-67','SEBASTIANA TAVARES DE MIRANDA DA SILVA','RESSARCIMENTO/ MENSALIDADE','3','287.209.381-87','','2','R$ 630,96'),
    array('13/12/2021','0709829-06.2021.8.07.0018','00020-00049896/2021-93','CORDELIA DE FATIMA ALMEIDA*','MEDICAMENTO/ OLAPARIBE','1','209.763.051-00','','1','R$ 365.665,56'),
    array('15/12/2021','0765987-87.2021.8.07.0016','00020-00000937/2022-24','BERENICE FONSECA DA CUNHA MELO','MEDICAMENTO/Anti- IL6 Tocilizumabe','3','565.126.001-34','','1','R$ 1.000,00'),
    array('16/12/2021','0766427-83.2021.8.07.0016','00020-00002881/2022-42','SEBASTIAO MARIA','HOME CARE','3','059.393.721-04','','2','R$ 1.000,00')
);
    
require_once('./actions/ManterProcesso.php');
require_once('./dto/Processo.php');

require_once('./actions/ManterAssunto.php');
require_once('./dto/Assunto.php');

$db_assunto = new ManterAssunto();
$db_processo = new ManterProcesso();

foreach ($dados as $registro) {
    $filtro = " WHERE numero = '".$registro[1]."' ";
    $processos_encontrado = $db_processo->listar($filtro);
    $existe = false;
    foreach ($processos_encontrado as $processo) {
        $existe = true;
    }
    if(!$existe){
        $dados = new Processo();
        $data_auto = DateTime::createFromFormat('d/m/Y', $registro[0]);
        $dados->numero                   = $registro[1];
        $dados->sei                      = $registro[2];
        $dados->autuacao                 = $data_auto->getTimestamp();
        $dados->cpf                      = $registro[6];
        $dados->beneficiario             = $registro[3];
        $dados->guia                     = $registro[7];
        $dados->valor_causa              = $registro[9];

        $filtro = " WHERE UPPER(assunto) = UPPER('".$registro[4]."') ";
        $assuntos_encontrado = $db_assunto->listar($filtro);
        $existe = false;
        $id_assunto = 0;
        foreach ($assuntos_encontrado as $assunto) {
            $id_assunto = $assunto->id;
        }
        if( $id_assunto == 0){
            $a = new Assunto();
            $a->assunto = $registro[4];
            $a = $db_assunto->salvar($a);
            $id_assunto = $a->id;
        }
        $dados->assunto                  = $id_assunto;
        $dados->situacao_processual      = $registro[5]!='' ? $registro[5] : 1;
        $dados->liminar                  = $registro[8];
        $dados->instancia                = 1;
        $dados->usuario                  = 1;
        $dados->autor_inas               = 0;
        $db_processo->salvar($dados);
    }
}
