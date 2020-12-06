<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>

<!-- Parallax -->
<div class="parallax margin-bottom-70"
	data-background="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/for-listers.jpg"
	data-color="#36383e"
	data-color-opacity="0.45"
	data-img-width="800"
	data-img-height="505">

	<!-- Infobox -->
	<div class="text-content white-font">
		<div class="container">

			<div class="row">
				<div class="col-lg-6 col-sm-8">
					<h2>Nunca ha sido más fácil hacer dinero en bienes raíces.</h2>
					<p>¡Sólo comparta nuestras propiedades y reciba el pago por cada propiedad que refiera!</p>

                    <h3>Gane $<?php echo get_setting(30); ?> por cada propiedad</h3>

					<a href="/register?type=listers" class="button margin-top-25">Regístrate</a>
				</div>
			</div>

		</div>
	</div>

	<!-- Infobox / End -->

</div>
<!-- Parallax / End -->

<!-- Container -->
<div class="container">
    <div class="row">
		<div class="col-md-12">
		    <!-- Headline -->
		    <h3 class="headline with-border margin-top-45 margin-bottom-25">Es fácil trabajar con nosotros</h3>

		    <p>Cuando comparta nuestras propiedades con el mundo, le pagaremos una "finder fee" de $<?php echo get_setting(30); ?> por propiedad. Lo mejor de todo es que no hay límite en la cantidad de propiedades que puede referir.</p>

		</div>
	</div>

	<div class="row">

		<div class="col-md-12">
			<h4 class="headline margin-bottom-30 margin-top-40">¿Cómo funciona?</h4>

			<div class="numbered color filled">
				<ol>
					<li>
                        <p><b>Regístrese para obtener una cuenta.</b> Tendrá acceso a todas nuestras propiedades y le proporcionaremos un enlace único para cada propiedad.</p>
                    </li>
					<li>
                        <p><b>Comparte tu enlace único.</b> Puedes compartir el enlace en tus redes sociales, con tus amigos y en cualquier otra plataforma. Comparte todo lo que quieras.</p>
                    </li>
					<li>
                        <p><b>Recibe tu dinero.</b> Cuando alguien alquila una propiedad usando su enlace único, se le pagará un "finder fee" de $<?php echo get_setting(30); ?>.</p>
                    </li>
				</ol>
			</div>
		</div>

	</div>

	<div class="row">

		<div class="col-md-12">

            <h3 class="headline margin-bottom-30 margin-top-40">Todo lo que tienes que hacer es compartir un enlace para ganar dinero.</h3>

			<!-- Toggles Container -->
			<div class="style-2">

				<!-- Toggle 1 -->
				<div class="toggle-wrap">
					<span class="trigger "><a href="#">¿Con qué frecuencia me pagan?<i class="sl sl-icon-plus"></i></a></span>
					<div class="toggle-container">
						<p>Pagamos mensualmente antes del día 5 del mes. Todos los pagos se hacen en línea.</p>
					</div>
				</div>

				<!-- Toggle 2 -->
				<div class="toggle-wrap">
					<span class="trigger"><a href="#"> ¿Cuánto ganaré?<i class="sl sl-icon-plus"></i></a></span>
					<div class="toggle-container">
						<p>Cuando alguien alquila una propiedad usando su enlace único, se le pagará un "finder fee" de $<?php echo get_setting(30); ?>.</p>
					</div>
				</div>

				<!-- Toggle 3 -->
				<div class="toggle-wrap">
					<span class="trigger"><a href="#"> ¿Hay un límite de cuánto puedo ganar?<i class="sl sl-icon-plus"></i></a></span>
					<div class="toggle-container">
						<p>No, no hay límite. Sólo sigue compartiendo tus enlaces y refiriendo a los inquilinos. Puedes crear un ingreso recurrente para ti mismo usando nuestra plataforma.</p>
					</div>
				</div>

			</div>
			<!-- Toggles Container / End -->
		</div>
	</div>
</div>