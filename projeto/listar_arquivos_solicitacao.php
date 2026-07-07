<?php
header('Content-Type: application/json');

$base = realpath('./anexos_solicitacao');
$pasta = $_POST['pasta'] ?? '';
$caminho_real = realpath($pasta);

if (!$caminho_real || strpos($caminho_real, $base) !== 0 || !is_dir($caminho_real)) {
    echo json_encode([]);
    exit;
}

$itens = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        $caminho_real,
        RecursiveDirectoryIterator::SKIP_DOTS
    ),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    $itens[] = [
        'tipo' => $item->isDir() ? 'diretorio' : 'arquivo',
        'nome' => $item->getFilename(),
        'caminho' => str_replace($base . DIRECTORY_SEPARATOR, '', $item->getPathname())
    ];
}

echo json_encode($itens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);