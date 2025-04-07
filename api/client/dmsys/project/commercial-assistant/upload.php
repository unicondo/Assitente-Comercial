<?php
header('Content-Type: application/json');

// Configurações
$uploadDir = 'uploads/';
$allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

// Verificar se o arquivo foi enviado
if (!isset($_FILES['relatorio'])) {
    echo json_encode(['success' => false, 'message' => 'Nenhum arquivo enviado']);
    exit;
}

// Verificar erros de upload
if ($_FILES['relatorio']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Erro no upload: ' . $_FILES['relatorio']['error']]);
    exit;
}

// Verificar tipo de arquivo
if (!in_array($_FILES['relatorio']['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido']);
    exit;
}

// Criar diretório se não existir
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        echo json_encode(['success' => false, 'message' => 'Falha ao criar diretório de upload']);
        exit;
    }
}

// Processar nome do arquivo (manter original com tratamento de duplicados)
$originalName = basename($_FILES['relatorio']['name']);
$fileName = $originalName;
$targetPath = $uploadDir . $fileName;

$counter = 1;
while (file_exists($targetPath)) {
    $fileInfo = pathinfo($originalName);
    $fileName = $fileInfo['filename'] . "($counter)." . $fileInfo['extension'];
    $targetPath = $uploadDir . $fileName;
    $counter++;
}

// Mover arquivo para o diretório de upload
if (move_uploaded_file($_FILES['relatorio']['tmp_name'], $targetPath)) {
    echo json_encode([
        'success' => true,
        'filePath' => $targetPath,
        'fileName' => $fileName,
        'message' => 'Arquivo enviado com sucesso!'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Falha ao mover arquivo para o diretório de destino'
    ]);
}
?>