<?php

$id = $_REQUEST['id'];

$uploadDir = 'eventos/folder_';
$uploadDir .= $id;
$uploadDir .= '/';
                           
$files = array_diff(scandir($uploadDir), array('.', '..'));

foreach ($files as $file) { ?>
    <div id='file-<?=$file ?>' class='col-xl-3 col-md-2 mb-4' style='max-width: 280px; max-height: 100px;'>
            <img src="<?=$uploadDir . $file ?>" height="200" width="200"> 
            <a  href="javascript:void(0);" onclick="excluir('<?=$file ?>')"><i class='far fa-trash-alt text-danger'></i></a>
    </div>
<?php
}
?>
