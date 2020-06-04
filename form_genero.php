<?php include './layout/header.php';?>
<?php include './layout/menu.php';?>
<?php

require 'classes/Genero.php';
require 'classes/GeneroDAO.php';

$genero = new Genero();
	if(isset($_GET['id']) && $_GET['id'] != '') {
		$id = $_GET['id'];
		$generoDAO = new GeneroDAO();
		$genero = $generoDAO->get($id);
	}
?>

<div class="row" style="margin-top:40px">
	<div class="col-6 offset-3">
		<h2>Cadastrar gênero</h2>
	</div>
</div>

<div class="row">
	<div class="col-6 offset-3">
		<form action="controle_genero.php?acao=<?= ( $genero->getId() != '' ? 'editar' : 'cadastrar' )?>" method="post">
			
			<div class="form-group">
				<label for="id">ID</label>
				<input type="text" class="form-control" name="id" id="id" value="<?=($genero->getId() != '' ? $genero->getId() : '')?>" readonly>
			</div>

			<div class="form-group">
				<label for="nome">Nome</label>
				<input type="text" class="form-control" name="nome" required value="<?=($genero->getNome() != '' ? $genero->getNome() : '')?>">
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Salvar</button>
				<button type="reset" class="btn btn-warning">Resetar</button>
			</div>

		</form>
	</div>
</div>	


<?php include './layout/footer.php';?>
