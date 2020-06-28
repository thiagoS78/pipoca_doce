<?php
session_start();
require 'classes/Usuario.php';
require 'classes/UsuarioDAO.php';

$usuario = new Usuario();
$usuarioDAO = new UsuarioDAO();

$acao = $_GET['acao'];
$id = '';
if(isset($_GET['id']) && $_GET['id'] != '') {
	$id = $_GET['id'];
}

/**Configurações de upload de imagens*/

$upload['pasta_usuario'] = 'assets/img/usuario/';
$upload['extensoes'] = ['jpg', 'png', 'gif'];

$upload['erros'][0] = 'Não houve erro';
$upload['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$upload['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$upload['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$upload['erros'][4] = 'Não foi feito o upload do arquivo';



if($acao == 'deletar') {

	$usuarioDAO->deletar($id);
	$msg = 'Usuário excluído com sucesso';

	header("Location: usuario.php?msg=$msg");

} else if($acao == 'cadastrar') {

	if($_FILES['imagem']['name'] != '') {

		if ($_FILES['imagem']['error'] != 0) {
		  $msg = "Não foi possível fazer o upload, erro:" . $upload['erros'][$_FILES['imagem']['error']];
		  header("Location: form_usuario.php?msg=$msg");
		  exit;
		}

		$imagem = explode('.', $_FILES['imagem']['name']);
		$extensao = strtolower(end($imagem));
		if(array_search($extensao, $upload['extensoes']) === false) {
		  $msg = "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  header("Location: form_usuario.php?msg=$msg");
		  exit;
		}
		$nome_final = $imagem[0] . '-' . date('YmdHmi') . '.' . $extensao;
		// Depois verifica se é possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['pasta_usuario'] . $nome_final)) {
			$usuario->setImagem($nome_final);
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
		  $msg = "Não foi possível enviar o arquivo, tente novamente";
		  header("Location: form_usuario.php?msg=$msg");
		  exit;
		}
	}

	$usuario->setNome($_POST['nome']);
	$usuario->setDataNascimento($_POST['dataNascimento']);
	$usuario->setEmail($_POST['email']);
	$usuario->setSenha($_POST['senha']);

	try {
		$id_usuario = $usuarioDAO->insereUsuario($usuario);
		$msg = 'Usuário cadastrado com sucesso';
	} catch (Exception $e) {
		$msg = 'Email cadastrado já existe!'/*. $e->getMessage()*/ ;  
	}

	header("Location: form_usuario.php?id=$id_usuario&msg=$msg");

} else if(($acao == 'editar') 
			|| ($_SESSION['id_usuario'] == $_POST['id'])) {

	if($_POST['senha'] != ''){
		$usuario->setSenha($_POST['senha']);
	}
	$id_usuario = $_POST['id'];


	if($_FILES['imagem']['name'] != '') {

		if ($_FILES['imagem']['error'] != 0) {
		  $msg = "Não foi possível fazer o upload, erro:" . $upload['erros'][$_FILES['imagem']['error']];
		  header("Location: form_usuario.php?id=$id_usuario&msg=$msg");
		  exit;
		}

		$imagem = explode('.', $_FILES['imagem']['name']);
		$extensao = strtolower(end($imagem));
		if(array_search($extensao, $upload['extensoes']) === false) {
		  $msg = "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  header("Location: form_usuario.php?id=$id_usuario&msg=$msg");
		  exit;
		}
		$nome_final = $imagem[0] . '-' . date('YmdHmi') . '.' . $extensao;

		

		// Depois verifica se é possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['pasta_usuario'] . $nome_final)) {

			//incluindo a imagem nova no registro do usuário
			$usuario->setImagem($nome_final);

			//alimentando um usuário temporário
			$usuarioTemp = $usuarioDAO->get($id_usuario);
			//montando link da imagem atual do usuario, representado pelo usuario temporario
			$imagem_a_remover = $upload['pasta_usuario'] . $usuarioTemp->getImagem();
			//removendo a imagem antiga
			if( file_exists($imagem_a_remover) ) {
				unlink($imagem_a_remover);
			}

			if($id_usuario == $_SESSION['id_usuario']) {
				$_SESSION['imagem'] = $usuario->getImagem();
			}
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
		  $msg = "Não foi possível enviar o arquivo, tente novamente";
		  header("Location: form_usuario.php?id=$id_usuario&msg=$msg");
		  exit;
		}
	}

	$usuario->setId($_POST['id']);
	$usuario->setNome($_POST['nome']);
	$usuario->setDataNascimento($_POST['dataNascimento']);
	$usuario->setEmail($_POST['email']);

	$usuarioDAO->alteraUsuario($usuario);
	$msg = 'Usuário alterado com sucesso';
	
	header("Location: form_usuario.php?id=$id_usuario&msg=$msg");

} else if($acao == 'removeImagem') {
	$usuario = $usuarioDAO->get($id);

	$imagem_a_remover = $upload['pasta_usuario'] . $usuario->getImagem();
	//removendo a imagem antiga
	if( file_exists($imagem_a_remover) ) {
		unlink($imagem_a_remover);
	}
	$usuario->setImagem('--');
	$usuarioDAO->alteraUsuario($usuario);

	$msg = 'Imagem removida com sucesso';
	
	header("Location: usuario.php?msg=$msg");

}