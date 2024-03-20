<?php
$this->layout("$theme::_layout-login");
?>

<div class="row h-100">
	<div class="col-lg-7 d-flex align-items-center justify-content-center">
		<div class="w-lg-500px p-10">
			<form class="form w-100" novalidate="novalidate" id="formLogin" data-method="post" action="<?= $router->route('auth.verifyLogin') ?>">
				<img class="img-fluid mb-3" src="<?= asset($theme, 'images/logos/logo-borelli.webp') ?>" alt="" />


				<div class="text-center my-10">
					<h1 class="fw-bolder">Acesso ao painel administrativo</h1>
				</div>
				<div class="fv-row mb-5">
					<input type="tel" placeholder="Email" name="Email" autocomplete="off" class="form-control bg-transparent" />
				</div>
				<div class="fv-row mb-5">
					<input type="password" placeholder="Senha" name="Password" autocomplete="off" class="form-control bg-transparent" />
				</div>
				<div class="d-grid">
					<button type="submit" id="btnLogin" class="btn btn-primary">Entrar</button>
				</div>
			</form>
		</div>
	</div>
	<div class="d-none d-lg-block col-lg-5 decoration-login"></div>
</div>