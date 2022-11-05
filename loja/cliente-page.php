	<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Sua conta | Alt Solutions</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="icon" href="favicon.png">
	</head>
	<body>
		<header> 
			<div class="principal-menu-nav">
				<nav>
	      			<input type="checkbox" id="check">
	      			<label for="check" class="checkbtn">
	        			<i class="fas fa-bars"></i>
	      			</label>
	     			<label class="logo"><a href="index.php" class="logo-link"><img src="img/logo.png" alt="Logo da loja"></a></label>
	      			<ul>
			            <li>
			              <form class="search-bar" method="GET" action="pesquisar.php">
			                <input type="text" id="txtBusca" name="procurar-produto" placeholder="O que você procura?" required="yes">
			                <button class="search-btn"><img src="img/ico/lupa.png" class="index-lupa" alt="Lupa"></button>
			              </form>
			            </li>
			            <li>
			              <a href="carrinho.php" class="cart-link"><img src="img/ico/carrinho.png" class="index-cart-menu" alt="Carrinho de compras"></a>
			            </li>
			            <li><a href="index.php">Home</a></li>
			          	<li id="sua-conta-li"><a href="cliente-page.php">Sua conta</a></li>
			            <li><a href="sobre.php">Sobre</a></li>
			            <li><a href="contato.php">Contato</a></li>
			            <?php 
							
							if(!isset($_COOKIE['cliente'])){
								header ("Location: login.php");
						?>
			            	<li><a href="login.php" class="default-btn">Login</a></li>
						<?php 
							}else{
								include 'resources/autenticador.php'
						?>
							<li><a href="cliente-page.php">Sua conta</a></li>
						<?php 
							}
						?>
			        </ul>
    			</nav>
			</div>
		</header> <!-- Fim cabeçalho -->

		<main> <!-- conteudo principal -->
		<section>
				<div class="title-account">
					<h1>Sua Conta</h1>
				</div>
				<div class="account-content">
					<form action="alterar-cadastro.php" class="account-option-form">
						<button type="submit">
								<img src="img/ico/user.png" alt="usuario" class="cliente-ico">
								<span class="option-title">Acesso e segurança</span>
								<span class="option-subtitle">Alterar login, nome ou celular</span>						
						</button>
					</form>
					
					<form action="pedidos.php" class="account-option-form purchase-option">
						<button type="submit">
							<img src="img/ico/box.png" alt="pedidos" class="cliente-ico">
							<span class="option-title">Seus pedidos</span>
							<span class="option-subtitle">Rastrear, devolver ou comprar produtos novamente.</span>						
						</button>
					</form>

					<form action="resources/logout.php" class="account-option-form">
						<button type="submit">
								<img src="img/ico/exit.png" alt="usuario" class="cliente-ico">
								<span class="option-title">Sair</span>
								<span class="option-subtitle">Encerrar Sessão</span>						
						</button>
					</form>

				</div>

			</section>
		</main> <!-- Fim conteudo principal -->
		<footer> <!-- Footer -->
			<div class="footer">
			<div class="footer-links">
				<div class="footer-description">
					<h2>Sobre</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				<div class="footer-link1">
					<h2>Categorias</h2>
					<ul class="footer-cat1">
						<li><a href="pesquisar.php?procurar-produto=Eletrônicos">Eletrônicos</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Informática">Informática</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Telefone">Telefones</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Jogos">Jogos</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Vídeos">Vídeos</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Acessórios">Acessórios</a></li>
					</ul>
				</div>
				<div class="footer-link2">
					<h2>Links Rápidos</h2>
					<ul class="footer-cat2">
						<li><a href="sobre.php">Sobre nós</a></li>
						<li><a href="contato.php">Entre em contato</a></li>
						<li><a href="politica-termos.php">Política de privacidade</a></li>
					</ul>
				</div>

			</div>
			<div class="footer-copyright">
				<p>Copyright &copy; 2021 All Rights Reserved by Quinteto RTA.</p>
			</div>
		</div>
		</footer> <!-- Fim footer -->
	</body>
</html>