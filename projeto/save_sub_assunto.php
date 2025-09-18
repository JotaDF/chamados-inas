<?php

require_once('./actions/ManterSubAssunto.php');
require_once('./dto/SubAssunto.php');

$db_sub_assunto = new ManterSubAssunto();
$s = new SubAssunto();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$sub_assunto = $_POST['sub_assunto'];

$s->id = $id;
$s->sub_assunto = $sub_assunto;

$db_sub_assunto->salvar($s);
header('Location: sub_assuntos.php');

