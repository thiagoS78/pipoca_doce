<?php
session_start();
require 'classes/Usuario.php';
require 'classes/UsuarioDAO.php';
$usuarioDAO = new UsuarioDAO();

$email = $_POST['email'];
$senha = md5($_POST['senha']);

$usuario = $usuarioDAO->getLogin($email, $senha);


if(empty($usuario)) {
    session_destroy();
    $msg = 'Falha no login, tente novamente!';
    header("Location: index.php?msg=$msg");
} else {
    $_SESSION['nome'] = $usuario->getNome();
    $_SESSION['email'] = $usuario->getEmail();
    $_SESSION['imagem'] = $usuario->getImagem();
    $_SESSION['id_usuario'] = $usuario->getId();
    $_SESSION['tipo'] = $usuario->getTipo();

    $msg = 'Usuário logado com sucesso!';
    header("Location: home.php?msg=$msg");
}
?> 