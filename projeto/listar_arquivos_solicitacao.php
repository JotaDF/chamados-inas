<?php

header('Content-Type: application/json');

$base = realpath('./anexos_solicitacao');
$pasta = isset($_POST['pasta']) ? $_POST['pasta'] : '';
$caminho_real = realpath($pasta);

if (!$caminho_real || strpos($caminho_real, $base) !== 0 || !is_dir($caminho_real)) {
    echo json_encode([]);
    exit;
}

$arquivos = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($caminho_real, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $arquivo) {
    if ($arquivo->isFile()) {
        $arquivos[] = $arquivo->getFilename();
    }
}

echo json_encode(array_values($arquivos));