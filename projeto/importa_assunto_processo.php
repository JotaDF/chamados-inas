<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$dados = array('ABLAÇÃO HEPÁTICA POR RADIOFREQUENCIA E DANOS MORAIS',
'Andamento',
'ARQUIVADO',
'ARQUIVADO - SEM RESOLUÇÃO DE MÉRITO',
'BUCOMAXILO',
'BUCOMAXILO/ORTOGNÁTICA',
'BUCOMAXILOFACIAL',
'bucomaxilofacial ',
'BUXOMAXILO',
'Cadastro',
'CADASTRO/ Adesão ',
'CADASTRO/ DEPENDENTE',
'CADASTRO/ Inclusão de dependente',
'CADASTRO/ permanência',
'CARÊNCIA/ cirurgia para desobstrução intestinal',
'CARÊNCIA/ hemodiálise',
'CARÊNCIA/ quimioterapia',
'CIRURGIA',
'CIRURGIA /cirurgia no manguito no ombro esquerdo',
'CIRURGIA carcinoma verrucoso',
'CIRURGIA DA VALVA AÓRTICA POR IMPLANTE',
'Cirurgia de mastectomia',
'Cirurgia de quadrantectonia com ressecção de linfonodo sentinela/ MEDICAMENTO',
'CIRURGIA ECOCARDIOGRAMA INTRACARDÍACO',
'cirurgia OMBRO (Síndrome do Manguito Rotador – CID M725)',
'CIRURGIA ORTOPÉDICA/OPME',
'CIRURGIA TRANSGENITALIZAÇÃO',
'CIRURGIA/  lombalgia crônica',
'CIRURGIA/  Ressecção de tumor neuroendrócrino ',
'CIRURGIA/  Troca Valvar Aórtica Transcateter',
'CIRURGIA/ /BLOQUEIO DE NERVOS',
'CIRURGIA/ abaixamento por videolaparoscopia',
'CIRURGIA/ Ablação de fibrilação atrial ',
'CIRURGIA/ ABLAÇÃO DE FIBRILAÇÃO DE ATRIAL',
'CIRURGIA/ antibiótico Cubicin 500mg',
'CIRURGIA/ antiglaucoma via angular com implante de stent Inject Trabecular',
'CIRURGIA/ Bariatríca',
'CIRURGIA/ BARIÁTRICA',
'CIRURGIA/ Bloqueio Do Sistema Nervoso Autonomo',
'CIRURGIA/ bloqueio neurolítico peridural e denervação percutânea de faceta articular',
'CIRURGIA/ Bucomaxilo',
'CIRURGIA/ CATETER DE ECO INTRACARDÍACO VIEWFLEX',
'CIRURGIA/ Cateterismo',
'CIRURGIA/ cirurgia de reconstrução óssea da maxila atrófica',
'CIRURGIA/ cirurgia valvar com implante de mitraclip',
'CIRURGIA/ Ecocardiograma intracardíaco',
'CIRURGIA/ Ecocardiograma Intracardíaco ',
'CIRURGIA/ Endometriose',
'CIRURGIA/ espinhal descompressiva de coluna, via endoscópica',
'CIRURGIA/ Gasoterapia',
'CIRURGIA/ Hérnia de disco ',
'CIRURGIA/ HERNIA INGUINAL/ OPME',
'CIRURGIA/ HERNIOPLASTIA ABDOMINAL',
'CIRURGIA/ Implantação de port-à-cath',
'CIRURGIA/ Implante transcateter',
'CIRURGIA/ Laminotomia',
'CIRURGIA/ Laparoscopia',
'CIRURGIA/ Lifaderectomia pelvica laparoscópica',
'CIRURGIA/ Linfadenectomia mediastinal ',
'CIRURGIA/ Linfadenectomia Pelvica Laparoscopica',
'CIRURGIA/ Lipodistrofia',
'CIRURGIA/ LOMMBAR/ OPME',
'CIRURGIA/ Mamotomia guiada por US',
'CIRURGIA/ mastectomia',
'CIRURGIA/ MASTOPEXIA REDUTORA',
'CIRURGIA/ MATERIAIS',
'CIRURGIA/ NEUROCIRURGIA',
'CIRURGIA/ oncológica',
'CIRURGIA/ OPME',
'CIRURGIA/ ortopédica',
'CIRURGIA/ ortopédica via endoscópica',
'CIRURGIA/ Osteomelite',
'CIRURGIA/ Pleuroscopia Por Video',
'CIRURGIA/ Prostectomia',
'CIRURGIA/ Prostectomia Robótica',
'CIRURGIA/ protectomia robótica',
'CIRURGIA/ prótese mamária',
'CIRURGIA/ Reconstrução mamária',
'CIRURGIA/ Ressecção da mama',
'CIRURGIA/ ressecção de tumor cerebral',
'CIRURGIA/ Ressecção endoscópico da bexiga',
'CIRURGIA/ REVISÃO DE SISTEMA DE NEUROESTIMULAÇÃO',
'CIRURGIA/ ROBÓTICA',
'CIRURGIA/ TIREOIDECTOMIA TOTAL ',
'CIRURGIA/ Transplante',
'CIRURGIA/ Transplante Autólogo de Medula Óssea',
'CIRURGIA/ Transplante de células tronco',
'CIRURGIA/ Transplante de medula óssea',
'CIRURGIA/ Transplante Hepático',
'CIRURGIA/ TRATAMENTO ONCOLÓGICA',
'CIRURGIA/ Troca de válvula transcateter',
'CIRURGIA/ troca valvar implante de Mitraclipe',
'CIRURGIA/ tumor intracraniano',
'CIRURGIA/ ureterorrenolitotripsia flexível à laser',
'CIRURGIA/ABALAÇÃO COMPLEXA (ECOCARDIOGRAMA INTRACADÍACO)',
'CIRURGIA/ABALAÇÃO DE ARRITMIA COMPLEXA',
'CIRURGIA/ABLAÇÃO',
'CIRURGIA/Artroplastia discal de coluna vertebral e OPME',
'CIRURGIA/ARTROSE',
'CIRURGIA/BARIÁTRICA/REPARADORA',
'CIRURGIA/blefaroplastia',
'CIRURGIA/BUCOMAXILOFACIAL',
'CIRURGIA/CATETER',
'CIRURGIA/CATETER DE ECO',
'CIRURGIA/CATETER DE ECO INTRACARDIACO VIEWFLEX',
'CIRURGIA/CATETER TERAPÊUTICO 070',
'CIRURGIA/CESÁRE/UTI NEONATAL',
'CIRURGIA/COLUNA VIA ENDOSCÓPICA',
'CIRURGIA/DEBRIDAMENTO COM SUTURA',
'CIRURGIA/ENDOSCÓPIA PARA HIGIENE DE DISCO',
'CIRURGIA/Extração de cálculo salivar por via endoscópica',
'CIRURGIA/FRATURAS DOS OSSOS DA FACE',
'CIRURGIA/HEPÁTICA ABLAÇÃO POR RADIOFREQUÊNCIA PERCUTÂNEA',
'CIRURGIA/HISTERECTOMIA',
'CIRURGIA/IMPLANTE DE GERADOR DE NEUROESTIMULAÇÃO',
'CIRURGIA/KIT NAVEGAÇÃO',
'CIRURGIA/MAMA/OPME',
'CIRURGIA/OFTALMOLÓGICA IRIDEX CYCLO',
'CIRURGIA/OFTALMOLÓGICA/FACO/LIO',
'CIRURGIA/ONCOLÓGICA',
'CIRURGIA/OPME',
'CIRURGIA/OPME/CATETER ABLAÇÃO',
'CIRURGIA/OPME/CATETER SOUNDSTAR DE ECOCARDIOGRAMA INTRACARDÍACO',
'CIRURGIA/OPME/CRANIOTOMIA',
'CIRURGIA/OPME/DANOS MORAIS',
'CIRURGIA/OPME/DESCOMPRESSÃO RADICULAR',
'CIRURGIA/OPME/GLAUCOMA',
'CIRURGIA/OPME/JOELHO',
'CIRURGIA/OPME/MICRONEUROLISE MULTPLIAS',
'CIRURGIA/OPME/RESSECÇÃO ENDOSCÓPICA ',
'CIRURGIA/PÓS BARIATRICA',
'CIRURGIA/RECONSTRUÇÃO MAMÁRIA',
'CIRURGIA/ressecção do intestino grosso',
'CIRURGIA/RETIRADA DE TUMOR NA BORDA DA LÍNGUA COM RECONSTRUÇÃO',
'CIRURGIA/RETIRADA DE VESÍCULA/CARÊNCIA',
'CIRURGIA/TRANSPLANTE HEPÁTICO',
'COBRANÇA',
'COBRANÇA INDEVIDA',
'COBRANÇA INDEVIDA/ Coparticipação',
'COBRANÇA INDEVIDA/ mensalidade',
'COBRANÇA/COPARTICIPAÇÃO',
'COBRANÇA/CORREÇÃO MONETÁRIA PELO INPC',
'COPARTICIPAÇÃO',
'Cumprimento de sentença. BUCOMAXILO/ORTOGNÁTICA',
'CURATIVO A VÁCUO',
'CURATIVO A VÁCUO E DANOS MOARIS',
'Danos extrapatrimoniais',
'Danos morais',
'EM ANDAMENTO',
'EXAME',
'EXAME EXOMA COMPLETO DO GENOMA COM ANALISEDE CNVS e DNAMITOCONDRIAL ',
'EXAME PARA ANEURISMA',
'EXAME/ anatomopatológico e imunohistoquimica',
'EXAME/ ECOCARDIOGRAMA INTRACARDÍACO',
'EXAME/ medicamento Rituximabe (500mg/50ml)',
'EXAME/ PET-CT',
'EXAME/ PET-SCAN',
'EXAME/ TOMOGRAFIA DE COERÊNCIA OPTICA ',
'EXAME/ Videocolonoscopia ',
'EXAME/COVID',
'EXAME/ECOCARDIOGRAMA - EIC',
'EXAME/Embolização de Aneurisma Cerebral',
'EXAME/MAMOTOMIA DA MAMA',
'EXAME/MAPEAMENTO GENÉTICO',
'EXAME/OPME',
'EXAME/PET CT',
'EXAME/PET CT ',
'EXAME/PET-CT COM PSMA',
'EXAME/TOMOGRAFIA DE COERÊNCIA ÓPTICA',
'EXAME/VÍDEO ELETROENCEFALOGRAMA',
'EXAMES /TOMOGRAFIA DE COERÊNCIA ÓPTICA– OCT',
'EXAMES/ perfil acilcarnitinas',
'EXAMES/BIOMICROSPCOPIA/TONOMETRIA/FUNDOSCOPIA E GONIOSCOPIA SOB NARCOSE E DANOS MORAIS',
'EXECUÇÃO/ Despesas Hospitalares',
'EXECUÇÃO/ Honorário de sucumbência',
'FISIOTERAPIA',
'FORNECIMENTO DE INSUMOS',
'FORNECIMENTOS DE INSUMOS',
'HEMODIAFILTRAÇÃO',
'HOME CARE',
'HONORÁRIOS SUCUMBENCIAIS',
'INCLUSÃO DE DEPENDENTE',
'INCLUSÃO DE DEPENDENTE/IRMÃ INTERDITADA',
'INCLUSÃO DE DEPENDENTE/IRMÃO INTERDITADA',
'INCLUSÃO DE GENITORES NO PLANO DE SAÚDE',
'INCLUSÃO NO PLANO COMO DEPENDENTE',
'Indenização',
'INDENIZAÇÃO POR DANO MORAL',
'INDENIZAÇÃO/ dano material',
'INTERNAÇÃO DOMICILIAR',
'INTERNAÇÃO HOSPITALAR',
'MEDICAMENTO',
'MEDICAMENTO  (Zytiga, Meticorten, Firmazona, Zoladex)',
'MEDICAMENTO / e VENETOCL (VENCLEXTA) e DECITABINA (DACOGEN)',
'MEDICAMENTO ABEMACICLIBE',
'Medicamento Não oncológico',
'MEDICAMENTO PALBOCICLIBE',
'MEDICAMENTO PROTOCOLO DARA-VRD E DANOS MORAIS',
'MEDICAMENTO QUIMIOTERAPIA',
'MEDICAMENTO TEMOZOLAMIDA',
'MEDICAMENTO TRATAMENTO DE  CANCER',
'MEDICAMENTO VENCLEXTA VIDAZA VFEND  RESSARCIMENTO DANOS MORAIS',
'MEDICAMENTO VERZENIOS',
'Medicamento ZANUBRUTINIBE (BRUKINSA)',
'MEDICAMENTO. TRATAMENTO QUIMIOTERÁPICO',
'MEDICAMENTO/  PEMBROLIZUMABE e LENVATINIBE',
'MEDICAMENTO/ abemaciclibe',
'MEDICAMENTO/ Abemaciclibe',
'MEDICAMENTO/ Abemaciclibe e Letrozol ',
'MEDICAMENTO/ abiraterona',
'MEDICAMENTO/ antibiótico Cubicin 500mg',
'MEDICAMENTO/ apalutamida',
'MEDICAMENTO/ Cabozantinibe 60mg',
'MEDICAMENTO/ Carboplatina AUC5, Pacitaxel 175mg/m² e Bevacizumabe',
'MEDICAMENTO/ Cisplatina, Gemcitamiga e Durvalumabe',
'MEDICAMENTO/ CLADRIBINA',
'MEDICAMENTO/ esclerose multipla',
'MEDICAMENTO/ EVOLOCUMABEREPATHAl',
'MEDICAMENTO/ Ibrutinibe e acalabrutinibe',
'MEDICAMENTO/ Infliximab',
'MEDICAMENTO/ insulina',
'MEDICAMENTO/ KISQALI (succinato de ribociclibe) e letrozol',
'MEDICAMENTO/ Lenalidamida 25 mg',
'MEDICAMENTO/ Levantinibe 24mg',
'MEDICAMENTO/ Lonsurf',
'MEDICAMENTO/ Lonsurf, Avastin e Difenidrin',
'MEDICAMENTO/ medicamento Lonsurf e Avastin',
'MEDICAMENTO/ medicamento Venetoclax e Azacitidina',
'MEDICAMENTO/ MONOFER (Derisomaltose Férrica) ',
'MEDICAMENTO/ NABIX 10.000 MG E RSHO-X 6000 MG',
'MEDICAMENTO/ Noriporum 100mg',
'MEDICAMENTO/ o inibidor de aromatase',
'MEDICAMENTO/ OSIMERTINIBE',
'MEDICAMENTO/ Osimertinibe 80 mg',
'MEDICAMENTO/ quimioterapia',
'MEDICAMENTO/ quimioterapia ',
'MEDICAMENTO/ quimioterapia e radioterapia',
'MEDICAMENTO/ Rituximab Mabthera',
'MEDICAMENTO/ SOMATROPINA',
'MEDICAMENTO/ TAMENTO QUIMIOTERÁPICO',
'MEDICAMENTO/ TRATAMENTO QUIMIOTERÁPICO',
'MEDICAMENTO/ Ustequinumabe',
'MEDICAMENTO/ Verzenios',
'MEDICAMENTO/ Verzênios',
'MEDICAMENTO/ VERZENIOS (Abemaciclibe)',
'MEDICAMENTO/DEGARELIX, DOCETAXEL E DAROLUTAMIDA',
'MEDICAMENTO/ABEMACECLIBE',
'MEDICAMENTO/ABEMACICLIBE',
'MEDICAMENTO/ABEMACICLIBE ',
'MEDICAMENTO/ABEMACICLIBE/LETROZOL',
'MEDICAMENTO/ABIRATERONA',
'MEDICAMENTO/BORTEZOMIBE',
'MEDICAMENTO/CABOMETYX',
'MEDICAMENTO/CANABIDIOL',
'MEDICAMENTO/CAPECITABINA',
'MEDICAMENTO/CAPMATINIBE ',
'MEDICAMENTO/CARBOPLATINA AUC6, PACLITAXEL E PERTUZUMA',
'MEDICAMENTO/DACOGEN (DECITABINA)',
'MEDICAMENTO/DURVALUMABE',
'MEDICAMENTO/durvalumabe/gencitabina/cisplatina',
'MEDICAMENTO/EDAVARONE.',
'MEDICAMENTO/ENFORTUMABE VEDOTIN E PEMBROLIZUMABE',
'MEDICAMENTO/ENZALUTAMIDA',
'MEDICAMENTO/ERLEADA',
'MEDICAMENTO/EVEROLIMUS E TAMOXIFENO ',
'MEDICAMENTO/Infliximab',
'MEDICAMENTO/Invanz/Romiplostim/Revolade/Daptomicina',
'MEDICAMENTO/KEYTRUDA',
'MEDICAMENTO/LONSURF - TRIFLURIDINA - TIPIRACIL',
'MEDICAMENTO/LONSURF (TRIFLURIDINA/TIPIRACIL)',
'MEDICAMENTO/LOUNSURF',
'MEDICAMENTO/MABTHERA (RITUXIMABE)',
'MEDICAMENTO/NIRAPARIBE',
'MEDICAMENTO/NUCALE NEPOLIZUMABE',
'MEDICAMENTO/OCREVUS',
'MEDICAMENTO/OLAPARIBE (LYNPARZA)',
'MEDICAMENTO/OMALIZUMBE XOLAIR',
'MEDICAMENTO/OSIMERTINIBE',
'MEDICAMENTO/PALBOCICLIB/LETROZOL',
'MEDICAMENTO/PALBOCICLIBE',
'MEDICAMENTO/RADICAVA',
'MEDICAMENTO/RADIOTERAPIA',
'MEDICAMENTO/REVLIMID',
'MEDICAMENTO/REVOLADE',
'MEDICAMENTO/RITUXIMABE ',
'MEDICAMENTO/RYBREVANT (AMIVANTAMBE)',
'MEDICAMENTO/SOMATOTROPINA',
'MEDICAMENTO/SPRAVATO',
'MEDICAMENTO/Tagrisso 80mg VO',
'MEDICAMENTO/TOXINA BOTULÍNICA E BOTOX',
'MEDICAMENTO/TRATAMENTO QUIMIOTERÁPICO.',
'MEDICAMENTO/TRIFLURIDINA TIPIRACIL E BEVACIZUMAB',
'MEDICAMENTO/USTEQUINUMABE',
'MEDICAMENTO/USTEQUINUMABE(STELARA)',
'MEDICAMENTO/VENCLEXTA E VIDAZA',
'MEDICAMENTO/VENETOCLAX',
'MEDICAMENTO/VERZENIOS (ABEMACICLIBE)',
'MEDICAMENTO/XELODA',
'MULTA ',
'NULIDADE DE LICITAÇÃO/PREGÃO nº 53-2023',
'NUTRIÇÃO PARENTERAL PERIFÉRICA',
'NUTRIÇÃO PARIENTAL',
'OCOLÓGICO/EXAME/PET CT',
'ONCOLÓGIA CIRURGIA ablação via radiologia intervencionista',
'ONCOLÓGIA/ MEDICAMENTO',
'ONCOLOGIA/MEDICAMENTO LYNPARZA/OLAPARIBE E BEVACIZUMABE',
'ONCOLÓGICA/QUIMIOTERAPIA',
'ONCOLÓGICO',
'ONCOLÓGICO ADENOCARCINOMA DE PÂNCREAS METASTÁTITO PARA PERITÔNEO E PARA FÍGADO (CID10 C25)/MEDICAMENTO',
'ONCOLÓGICO/ CIRURGIA',
'ONCOLÓGICO/ MEDICAMENTO/TRANSPLANTE CÉLULAS TRONCO ',
'ONCOLÓGICO/CARÊNCIA',
'ONCOLÓGICO/CARÊNCIA/QUIMIOTERAPIA',
'ONCOLÓGICO/EXAME/PET-CT',
'ONCOLÓGICO/EXAME/PET-PSMA',
'ONCOLÓGICO/MEDICAMENTO/ AVASTIN',
'ONCOLÓGICO/MEDICAMENTO/APALUTAMIDA/DAROLUTAMIDA/ENZALUTAMIDA',
'ONCOLÓGICO/MEDICAMENTO/CARBOPLANITA AUC6 E PACLITAXEL ',
'ONCOLÓGICO/MEDICAMENTO/DEGARELIX, DOCETAXEL, DAROLUTAMIDA',
'ONCOLÓGICO/MEDICAMENTO/GEMCITABINA, CISPLATINA E DURVALUMABE',
'ONCOLOGICO/MEDICAMENTO/KEYTRUDA',
'ONCOLÓGICO/MEDICAMENTO/OLAPARIBE',
'ONCOLÓGICO/MEDICAMENTO/POLIQUIMIOTERÁPICO',
'ONCOLÓGICO/QUIMIOTERAPIA',
'ONCOLOGICO/QUIMIOTERAPIA/Keytruda/pembrolizumabe',
'ONCOLÓGICO/QUIMIOTERAPIA/RADIOTERAPIA',
'ONCOLÓGICO/RADIOCIRURGIA/QUIMIOTERAPIA',
'ONCOLÓGICO/TEMOZOLAMIDA',
'OPME',
'OPME/ TPN terapia de pressão negativa (curativo a vácuo)',
'PAGAMENTO DE HONORÁRIOS',
'PARALISIA CEREBRAL/TERAPIA/Cuevas Medek Exercises – CME',
'PLANILHA DE DEMOSTRATIVOS',
'PROCEDIMENT0 CIRURGICO/ INIBIDOR DE AROMATASE',
'PROCEDIMENTO  CIRURGIA AMBULATORIAL SONDA ENDOSCÓPICA PARA ALIMENTAÇÃO, EM CARÁTER DE URGÊNCIA , CONFORME SOLICITAÇÃO MÉDICA.',
'procedimento cirúrgico de Focoemulsificação com implante de lente intraocular',
'PROCEDIMENTO/ Troca Valvar Mitral Transcateter',
'PROCEDIMENTO/CAPTAÇÃO E CONGELAMENTO DE ÓVULOS',
'Psicologia ABA. Fonoaudiologia PROMPT. Terapia Ocupacional Sensor de Ayres. Psicopedagogia ABA. Musicoterapia. Nutrição. Centro Interativo. Danos Morais.',
'QUIMEOTERAPIA',
'QUIMIOTERAPIA',
'Quimioterapia como terapia sistêmica a base de Doxorrubicina',
'QUIMIOTERAPIA E MEDICAMENTOS',
'QUIMIOTERAPIA/ FOLFOX',
'QUIMIOTERAPIA/MEDICAMENTO/CABOZANTINIBE',
'QUIMIOTERAPIA/MEDICAMENTO/Taxotre/ciclofosfamida',
'RADIOTERAPIA',
'RECISÃO CONTRATUAL/RESTITUIÇÃO DE DESCONTOS INDEVIDOS',
'REEMBOLSO',
'Reembolso. Órtese. Fisioterapia',
'REEMBOLSO/ Despesa cirurgica',
'REEMBOLSO/ DESPESAS MÉDICAS E HOSPITALARES',
'REEMBOLSO/ Honorário médico',
'REEMBOLSO/ Mensalidade',
'REEMBOLSO/CIRURGIA',
'REEMBOLSO/DANOS MORAIS',
'REEMBOLSO/EXAME MICROARRAY CROMOSSÔMICO',
'REEMBOLSO/EXAME PET-CT',
'REEMBOLSO/PET CT',
'REESTITUIÇÃO DE VALORES PAGOS INDEVIDAMENTE',
'REINTEGRAÇÃO DE DEPENDENTE',
'REINTEGRAÇÃO DE DEPENDENTE NO PLANO DE SAÚDE.',
'REMETIDOS AOS AUTOS',
'REMETIDOS OS AUTOS PARA 2° GRAU',
'RESSARCIMENTO',
'RESSARCIMENTO E DANOS MORAIS',
'RESSARCIMENTO/ Despesas Hospitalares',
'RESSARCIMENTO/ HONORÁRIOS MÉDICOS',
'RESSARCIMENTO/ Medicamento',
'RESSARCIMENTO/ mensalidade',
'RESSARCIMENTO/ MENSALIDADES',
'RESSARCIMENTO/ procedimento cirúrgico',
'RESSARCIMENTO/EXAME adenocarcinoma prostático e termometria cutânea corporal total',
'RESSEÇÃO PULMONAR',
'RESTABELECIMENTO DO PLANO DE SAÚDE',
'RESTITUIÇÃO DE DESCONTOS INDEVIDOS',
'SINDROME DOW/TERAPIAS',
'SUCUMBENCIA',
'SUCUMBÊNCIA',
'Superindividamento',
'SUSPENSÃO DOS EFEITOS DA PORTARIA n.º 102/2023',
'TEA',
'TEA /MÉTODO ABA',
'TEA Psicoterapia Fonoaudiologia Terapia Ocupacional Psicomotricista Fisioterapia motora Musicoterapia',
'TEA TERAPIA',
'TEA Terapia Ocupacional Fonoaudiologia Fisioterapia ',
'TEA Terapias multidisciplinares',
'TEA/ Terapia Ocupacional',
'TEA/ Terapia Ocupacional. Psicopedagogia. Fonoaudiologia. Psicoterapia ABA.',
'TEA/ABA',
'TEA/MÉTODO ABA',
'TEA/MÉTODO BOBATH',
'TEA/TERAPIAS',
'TERAPIA',
'TERAPIA ',
'Terapia Nutricional Parenteral Domiciliar (TNPD',
'TERAPIA OCUPACIONAL',
'TRANSPLANTE',
'TRANSPLANTE DE CÉLULAS-TRONCO',
'TRANSPLANTE DE CÓRNEA',
'TRANSPLANTE/ CÉCULAS TRONCO',
'TRANSPLANTE/CELULAS TRONCO',
'TRANSPLANTE/CÉLULAS TRONCO',
'TRANSPLANTE/CÉLULAS TRONCO/MEDICAÇÕES QUIMIOTERÁPICAS',
'TRANSPLANTE/CELULAS TRONCO/MEDICAMENTO/GILTERITINIB E XOSPATA',
'TRANSPLANTE/FÍGADO',
'TRANSPLANTE/MEDULA ÓSSEA',
'TRANSPLANTE/TMO',
'TRANSPORTE UTI-AÉREA para transplante Hepatite Autoimune Fulminante',
'TRATAMENTO DE CARCINOMA / SE AMPLIA E DIVERSAS DEMANDAS: PSICOLOGICA , CIRURGIA REPARADORA,E ETC.',
'TRATAMENTO DE MEGAESÔFAGO ENDOSCÓPICO',
'Tratamento oncológico - Medicamento - Carboplatina/Pacitaxel/Bevacizumabe',
'TRATAMENTO PSIQUIÁTRICO',
'TRATAMENTO QUIMIOTERÁPICO',
'TRATAMENTO/ INFUSÃO INSULINA',
'VALOR DA EXECUÇÃO/ CALCULO/ATUALIZAÇÃO');

require_once('./actions/ManterAssunto.php');
require_once('./dto/Assunto.php');

$db_assunto = new ManterAssunto();

foreach ($dados as $reg) {
    $filtro = " WHERE UPPER(assunto) = UPPER('".$reg."') ";
    $assuntos_encontrado = $db_assunto->listar($filtro);
    $existe = false;
    foreach ($assuntos_encontrado as $assunto) {
        $existe = true;
    }
    if(!$existe){
        $a = new Assunto();
        $a->assunto = $reg;
	print_r($a);
        $db_assunto->salvar($a);
    }
}
