<?php
session_start();
if (empty($_POST) || (empty($_POST["usuario"]) || (empty($_POST["senha"])))) {
    print "<script>alert('Por favor, preencha usuário e senha!')</script>";
    print "<script>location.href= '?page=login';</script>";
}

include('src/db/config.php');

$usuario = $_POST["usuario"];
$senha = $_POST["senha"];

// Preparar a consulta SQL com placeholders
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha");

// Vincular as variáveis aos placeholders
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':senha', $senha);

// Executar a consulta SQL
$stmt->execute();

// Obter o número de linhas afetadas pela consulta SQL
$qtd = $stmt->rowCount();

if ($qtd > 0) {
    // Obter os dados do usuário
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    // Definir as variáveis de sessão
    $_SESSION["usuario"] = $usuario;
    $_SESSION["nome"] = $row->nome;
    $_SESSION["tipo"] = $row->tipo;

    print "<script>location.href='?page=dashboard'</script>";
} else {
    print "<script>alert('Usuário ou Senha Inccoreta!')</script>";
    print "<script>location.href='?page=login'</script>";
}