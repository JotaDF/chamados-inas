<?php

require_once('./actions/ManterClasseJudicial.php');
require_once('./dto/ClasseJudicial.php');

$db_classe_judicial = new ManterClasseJudicial();
$cj = new ClasseJudicial();

$cjd = isset($_POST['id']) ? $_POST['id'] : 0;
$classe = $_POST['classe'];

$cj->id = $cjd;
$cj->classe = $classe;
$cj->vinculado = isset($_POST['vinculado']) ? $_POST['vinculado'] : '0';

$db_classe_judicial->salvar($cj);
header('Location: classes_judiciais.php');

