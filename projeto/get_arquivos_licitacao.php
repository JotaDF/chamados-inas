<?php

$id = $_REQUEST['id'];
$ano = $_REQUEST['ano'];

$uploadDir = 'licitacoes/';
$uploadDir .= $id;
$uploadDir .= '_';
$uploadDir .= $ano;
$uploadDir .= '/';
                           
$files = array_diff(scandir($uploadDir), array('.', '..'));

foreach ($files as $file) { ?>
    <div id='file-<?=$file ?>' class='col-xl-3 col-md-2 mb-4' style='max-width: 280px; max-height: 100px;'>
            <a href="<?=$uploadDir . $file ?>" target="_blank"><img src="img/pdf_icon.svg" width="50" height="50" /></a> <?=str_replace(".pdf","",$file) ?> 
            <a  href="javascript:void(0);" onclick="excluir('<?=$file ?>')"><i class='far fa-trash-alt text-danger'></i></a>
    </div>
<?php
}
?>
