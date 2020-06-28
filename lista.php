<?php 
	include 'layout/header.php';
	include 'layout/menu.php';
	include_once('admin/classes/Filme.php');
    include_once('admin/classes/FilmeDAO.php');
    include_once('admin/classes/Avaliacao.php');
	include_once('admin/classes/AvaliacaoDAO.php');

	if (isset($_GET['pagina'])) {
	  $pagina = (int)$_GET['pagina'];
	} else {
	  $pagina = 1;
	}

    $limit = 12;
	$offset = ($pagina - 1) * $limit;
	$filmeDAO = new FilmeDAO();
	$total = $filmeDAO->paginacao();
	$paginas =  (($total->total % $limit) > 0) ? (int)($total->total / $limit) + 1 : ($total->total / $limit);
	$pagina = max(min($paginas, $pagina), 1);

	$filmes = $filmeDAO->listar('', $limit, $offset);
	$avaliacaoDAO = new AvaliacaoDAO();
	
?>
	<div class="container">
		<div class="row">
			<?php 
				foreach ($filmes as $key => $filme) { 
				$avaliacao = $avaliacaoDAO->filmeAvaliacao($filme->getId());
			?>
				<div class="col" style="margin-top: 20px;">
					<div class="card" style="width: 18rem;">
  						<a href="filme.php?id=<?= $filme->getId() ?>">
							<img src="admin/assets/img/filme/<?= ($filme->getImagem()) ?>" class="lista">
						</a>
  						<div class="card-body">
    						<p class="card-text"><?= $filme->getNome(); ?></p>
    						<img class="estrela_lista" src="admin/assets/img/estrelas/<?= ($avaliacao->getAvaliacao() != '' ? $avaliacao->getAvaliacao() : 0) ?>.png">				
						</div>	
					</div>
				</div>
			<?php } ?>
	</div>
	<!-- <table class="table table-hover">
		<tr>
			<td>
				#
			</td>
			<td>
				Filme
			</td>
		</tr>
		<?php foreach ($filmes as $key => $filme) { ?>
			<tr>
			<td>
				<a href="filme.php?id=<?= $filme->getId() ?>">
					<img src="admin/assets/img/filme/<?= ($filme->getImagem()) ?>" class="lista">
				</a>
			</td>
			<td style="vertical-align: middle;">
				
			</td>
		</tr>
		<?php } ?>
	</table> -->
	<?php 
		if ($total->total > 0) {
	?>
	<nav aria-label="Navegação de página exemplo">
	  <ul class="pagination">
	   	<?php if($pagina > 1) : ?>
	    	<li class="page-item"><a class="page-link" href="lista.php?pagina=<?= $pagina - 1 ?>">Anterior</a></li> 
		<?php endif; ?>
	    <?php  
	    	for ($n = 1; $n <= $paginas; $n++) {	    
	    ?>
	    <li class="page-item <?= ($pagina == $n ? 'active' : '') ?>">
	    	<a class="page-link" href="lista.php?pagina=<?= $n ?>"><?= $n ?></a>
	    </li>
	    <?php  
	    	}
	    ?>
	    <?php if($paginas ) : ?>
	     <li class="page-item"><a class="page-link" href="lista.php?pagina=<?= $pagina + 1 ?>">Próximo</a></li>
	     <?php endif; ?> 
	  </ul>
	</nav>
</div>
<?php 
	}
?>
<?php  
	include_once('layout/footer.php');
?>