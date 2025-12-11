<?php

$id = $_REQUEST['id'];

$uploadDir = 'oficios/arquivo_';
$uploadDir .= $id;
$uploadDir .= '/';
                           
$files = array_diff(scandir($uploadDir), array('.', '..'));

foreach ($files as $file) { ?>
    <div id='file-<?=$file ?>' style='width: 100%; max-height: 400px; justify-content: center;'>
            <img src="<?=$uploadDir . $file ?>" height="400" width="400"> 
            <a  href="javascript:void(0);" onclick="excluir('<?=$file ?>')"><i class='far fa-trash-alt text-danger'></i></a>
    </div>
<?php
}
?>
