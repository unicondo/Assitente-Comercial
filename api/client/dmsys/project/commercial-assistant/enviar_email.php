<?php
header('Content-Type: application/json');

// Verificar se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// Dados obrigatórios
if (!isset($_POST['assunto']) || !isset($_POST['corpo_email'])) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
    exit;
}

// Configurações do e-mail
$para = 'bruno.alves@dmsys.com.br';
$de = 'o.bruno.alves@unicondo.app';
$assunto = $_POST['assunto'];
$mensagem = $_POST['corpo_email'];

// Cabeçalhos do e-mail
$headers = "From: $de\r\n";
$headers .= "Reply-To: $de\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Anexar arquivo se existir
if (!empty($_POST['caminho_relatorio']) && file_exists($_POST['caminho_relatorio'])) {
    $nome_arquivo = $_POST['nome_arquivo'] ?? 'arquivo_anexo';
    $file_content = file_get_contents($_POST['caminho_relatorio']);
    $file_encoded = chunk_split(base64_encode($file_content));
    $file_type = mime_content_type($_POST['caminho_relatorio']);
    
    $boundary = md5(uniqid(time()));
    
    $headers = "From: $de\r\n";
    $headers .= "Reply-To: $de\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    
    $mensagem = "--$boundary\r\n";
    $mensagem .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
    $mensagem .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $mensagem .= $_POST['corpo_email'] . "\r\n";
    $mensagem .= "--$boundary\r\n";
    $mensagem .= "Content-Type: $file_type; name=\"$nome_arquivo\"\r\n";
    $mensagem .= "Content-Disposition: attachment; filename=\"$nome_arquivo\"\r\n";
    $mensagem .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $mensagem .= $file_encoded . "\r\n";
    $mensagem .= "--$boundary--";
}

// Enviar e-mail
if (mail($para, $assunto, $mensagem, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Proposta enviada com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao enviar e-mail']);
}
?>