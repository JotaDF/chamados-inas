<?php
require_once('./actions/ManterMedicoPerico.php');
require_once('./dto/MedicoPerico.php');

$db_medico_perico = new ManterMedicoPerico();
$m = new MedicoPerico();

$id = isset($_POST['id']) ? $_POST['id'] : 0;

$m->id = $id;

$db_medico_perico->salvar($m);
header('Location: medico_perico.php');


