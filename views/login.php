<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Ingresar</h2>
				
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Ingresar</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Contact
================================================== -->

<!-- Container -->
<div class="container">

	<div class="row">
	<div class="col-md-4 col-md-offset-4">

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40">

	<?php
		show_message($form_success, $form_error, $form_info);
	?>

		<div class="tabs-container alt">
			<!-- Login -->
				<form method="post" name="login" class="login">

					<p class="form-row form-row-wide">
						<label for="username">Email:
							<input type="email" class="input-text" name="email" id="username" value="" />
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="password">Contraseña:
							<input class="input-text" type="password" name="password" id="password" />
						</label>
					</p>

					<p class="form-row">
						<input type="submit" class="button border margin-top-10" name="submit" value="Login" />
					</p>

					<p class="lost_password">
						<a href="/register">Crear una cuenta</a>
					</p>

					<br />
					
					<p class="lost_password">
						<a href="/reset-password">¿Olvidó la contraseña?</a>
					</p>
					
				</form>

		</div>
	</div>



	</div>
	</div>

</div>
<!-- Container / End -->