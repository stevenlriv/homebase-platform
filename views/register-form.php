<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Regístrese para una cuenta de <?php echo rtrim($type, 's'); //remove last letter 's' ?> </h2>
				
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Registrarse</li>
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
		show_message($form_success, $form_error);
	?>

		<div class="tabs-container alt">
			<!-- Login -->
				<form method="post" name="register" class="login">

					<p class="form-row form-row-wide">
						<label for="fullname">Nombre Completo:
							<input class="input-text" type="text" name="fullname" id="fullname"/>
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="email">Email:
							<input type="email" class="input-text" name="email" id="email" value="" />
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="phone_number">Número de Teléfono:
							<input type="text" class="input-text" name="phone_number" id="phone_number" value="" />
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="password">Contraseña:
							<input class="input-text" type="password" name="password" id="password" />
						</label>
					</p>

					<div class="checkboxes in-row margin-bottom-20 margin-top-10">
						<input id="check-30" type="checkbox" name="check_required">
						<label for="check-30">He leído y estoy de acuerdo con los <a href="/terms" target="_blank">Términos de Servicio</a>. También certifico que he leído la <a href="/privacy" target="_blank">Política de Privacidad</a>.</label>
					</div>

					<p class="form-row">
						<input type="submit" class="button border margin-top-10" name="submit" value="Register" />
					</p>

					<p class="lost_password">
						<a href="/login">¿Tiene una cuenta? Entra.</a>
					</p>
					
				</form>

		</div>
	</div>

	</div>
	</div>

</div>
<!-- Container / End -->