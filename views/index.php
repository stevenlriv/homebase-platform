<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Banner
================================================== -->
<div class="parallax" data-background="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/home-background-2.jpg" data-color="#36383e" data-color-opacity="0.45" data-img-width="3000" data-img-height="2000">
	<div class="parallax-content">

		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<!-- Main Search Container -->
					<div class="main-search-container">
						<h2>Alquile su próxima casa en minutos.</h2>
						
						<!-- Main Search -->
						<form class="main-search-form" action="/find-a-homebase" type="GET">
							
							<!-- Type -->
							<div class="search-type">
								<label class="active"><input class="first-tab" checked="checked" type="radio">Renta</label>
								<div class="search-type-arrow"></div>
							</div>

							
							<!-- Box -->
							<div class="main-search-box">
								
								<!-- Main Search Input -->
								<div class="main-search-input larger-input">
									<input name="location" type="text" class="ico-01" id="autocomplete-input" placeholder="Ingrese la dirección e.g. calle, ciudad or estado" required />
									<button class="button">Buscar</button>
								</div>

								<!-- Row -->
								<div class="row with-forms">

									<!-- Moving Date -->
									<div class="col-md-4">
                                        <input type="text" value="Fecha de Mudanza" readonly="readonly" style="border: none !important; background: none !important;">
									</div>

									<div class="col-md-4">
                                        <input name="date" type="text" id="date-picker" placeholder="Date" readonly="readonly">
									</div>

									<!-- Property Type -->
									<div class="col-md-4">
										<select name="type" data-placeholder="Type" class="chosen-select-no-single">
											<option value="">Tipo (Cualquiera)</option>
                                            <option value="house">Casa</option>
											<option value="apartment">Apartamento</option>
										</select>
									</div>
                                    
								</div>
								<!-- Row / End -->


							</div>
							<!-- Box / End -->

						</form>
						<!-- Main Search -->

					</div>
					<!-- Main Search Container / End -->

				</div>
			</div>
		</div>

	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
	
		<div class="col-md-12">
			<h3 class="headline margin-bottom-25 margin-top-65">Recién añadido</h3>
		</div>
		
		<!-- Carousel -->
		<div class="col-md-12">
			<div class="carousel">
				
			<?php
				$index_query = array(
					0 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active")
				);

				foreach ( get_listings('all', $index_query, 'ORDER BY id_listing DESC LIMIT 5') as $id => $value ) {
			?>

				<!-- Listing Item -->
				<div class="carousel-item">
					<div class="listing-item">

						<a href="/<?php echo $value['uri']; ?>" class="listing-img-container">

							<div class="listing-badges">
                            	<?php
							    	if($value['featured']) {
							        	echo '<span class="featured">Featured</span>';
									}
									
									print_available_message('label', $value['available']);
								?>
							</div>

							<div class="listing-img-content">
								<span class="listing-price">$<?php echo $value['monthly_house']; ?> <i>mensual</i></span>
							</div>

							<div class="listing-carousel">
								<div style="height: 280px;"><img src="<?php echo get_json($value['listing_images'], 0); ?>" alt="<?php echo $value['physical_address']; ?>" /></div>
							</div>

						</a>
						
						<div class="listing-content">

							<div class="listing-title">
								<h4><a href="/<?php echo $value['uri']; ?>"><?php echo $value['listing_title']; ?></a></h4>
								<a href="/find-a-homebase?location=<?php echo $value['city']; ?>" class="listing-address">
									<i class="fa fa-map-marker"></i>
									<?php echo $value['city']; ?>
								</a>
							</div>

							<ul class="listing-features">
								<li>Area <span><?php echo $value['square_feet']; ?> sq ft</span></li>
								<li>Cuartos <span><?php echo $value['number_rooms']; ?></span></li>
								<li>Baños <span><?php echo $value['number_bathroom']; ?></span></li>
							</ul>

							<div class="listing-footer">
								<a href="#" style="visibility: hidden;"><i class="fa fa-user"></i> Chester Miller</a>
								<span style="visibility: hidden;"><i class="fa fa-calendar-o"></i> <?php print_available_message('status', $value['available']); ?></span>
							</div>

						</div>
						<!-- Listing Item / End -->

					</div>
				</div>
				<!-- Listing Item / End -->

			<?php
				}
			?>

			</div>
		</div>
		<!-- Carousel / End -->

	</div>
</div>

<!-- Fullwidth Section -->
<section class="fullwidth border-bottom margin-top-100 margin-bottom-0 padding-top-50 padding-bottom-50" data-background-color="#f7f7f7">

	<!-- Content -->
	<div class="container">
		<div class="row">

            <div class="col-md-12">
			    <h3 class="headline centered margin-bottom-35 margin-top-10">¿Cómo funciona?</h3>
		    </div>

			<div class="col-md-4">
				<!-- Icon Box -->
				<div class="icon-box-1 alternative">

					<div class="icon-container">
						1
					</div>

					<h3>Cita</h3>
					<p>Programe una cita a su conveniencia. Le enviaremos un código de acceso con instrucciones para que pueda visitar la propiedad usted mismo.</p>
				</div>
			</div>

			<div class="col-md-4">
				<!-- Icon Box -->
				<div class="icon-box-1 alternative">

					<div class="icon-container">
						2
					</div>

					<h3>Aplica</h3>
					<p>¿Le gustó una propiedad? Le enviaremos un enlace con nuestra solicitud de alquiler, que puede completar al instante y desde la comodidad de su teléfono.</p>
				</div>
			</div>

			<div class="col-md-4">
				<!-- Icon Box -->
				<div class="icon-box-1 alternative">

					<div class="icon-container">
						3
					</div>

					<h3>Alquiler</h3>
					<p>El paso final es completar el acuerdo de arrendamiento digital y el pago de la renta en línea. Se le enviarán por correo electrónico los siguientes pasos a seguir para la mudanza.</p>
				</div>
			</div>

		</div>
	</div>

</section>
<!-- Fullwidth Section / End -->

<!-- Fullwidth Section -->
<section class="fullwidth margin-top-105" data-background-color="#fff">

	<!-- Box Headline -->
	<h3 class="headline-box">Puedes contar con nosotros</h3>
	
	<!-- Content -->
	<div class="container">
		<div class="row">

			<div class="col-md-3 col-sm-6">
				<!-- Icon Box -->
				<div class="icon-box-1">

					<div class="icon-container">
						<i class="im im-icon-Checked-User"></i>
					</div>

					<h3>Confianza</h3>
					<p>Le proveemos un reporte con la verificación de antecedentes y crédito del inquilino.</p>
				</div>
			</div>

			<div class="col-md-3 col-sm-6">
				<!-- Icon Box -->
				<div class="icon-box-1">

					<div class="icon-container">
						<i class="im im-icon-Over-Time"></i>
					</div>

					<h3>Ahorro de tiempo</h3>
					<p>Deje de preocuparse por mostrar su propiedad. Nos encargaremos de eso por ti.</p>
				</div>
			</div>

			<div class="col-md-3 col-sm-6">
				<!-- Icon Box -->
				<div class="icon-box-1">

					<div class="icon-container">
						<i class="im im-icon-Cloud-Email"></i>
					</div>

					<h3>Remoto</h3>
					<p>Convierte su contrato de alquiler preferido en uno digital o usa el nuestro.</p>
				</div>
			</div>

			<div class="col-md-3 col-sm-6">
				<!-- Icon Box -->
				<div class="icon-box-1">

					<div class="icon-container">
						<i class="im im-icon-Money-2"></i>
					</div>

					<h3>Fácil de usar</h3>
					<p>El pago de renta se deposita automáticamente en su cuenta cada mes y los retrasos se facturan automáticamente a su inquilino.</p>
				</div>
			</div>

		</div>
	</div>
</section>
<!-- Fullwidth Section / End -->

<!-- Fullwidth Section -->
<section class="fullwidth margin-top-105" data-background-color="#fff">

	<!-- Box Headline -->
	<div class="col-md-12">
			    <h3 class="headline centered margin-bottom-35 margin-top-10">¿Cómo funciona?</h3>
		    </div>
	
	<!-- Content -->
	<div class="container">
		<div class="row">

	<!-- Toggles Container -->
	<div class="style-2">

		<!-- Toggle 1 -->
		<div class="toggle-wrap">
			<span class="trigger "><a href="#">¿Cuánto cuesta publicar una propiedad? <i class="sl sl-icon-plus"></i></a></span>
			<div class="toggle-container">
				<p>Cobramos una cuota mensual del 5% además del alquiler, que cubre todos los gastos de transacción del alquiler, los servicios de gestión de la propiedad digital, y el acceso a Homebase Cashback.</p>
			</div>
		</div>

		<!-- Toggle 2 -->
		<div class="toggle-wrap">
			<span class="trigger"><a href="#">¿Qué es Homebase Cashback?<i class="sl sl-icon-plus"></i></a></span>
			<div class="toggle-container">
				<p>Cada mes ponemos el 1,5% de tu alquiler en una cuenta de ahorros. Cuando te mudes, te daremos acceso a esta cuenta de ahorros. Puedes hacer una de tres cosas con el dinero de la cuenta:
(a) cobrarlo para ti mismo,
(b) donarlo a la caridad de su elección, o
(c) usarlo para la próxima propiedad que alquile en Homebase

Si elige hacer lo (b) o (c) con sus ahorros, le igualaremos dólar por dólar y DOBLAREMOS la cantidad! 💰
</p>
			</div>
		</div>

		<!-- Toggle 3 -->
		<div class="toggle-wrap">
			<span class="trigger"><a href="#"> ¿Cómo funciona el Depósito Seguro?<i class="sl sl-icon-plus"></i></a></span>
			<div class="toggle-container">
				<p>Su depósito se mantiene en una cuenta de garantía de la Homebase. Esta es una cuenta separada que no se toca hasta que te mudes. Mientras no ocurra ningún daño a la propiedad durante su residencia, el depósito le será devuelto dentro de los 5 días de haberse mudado.</p>
			</div>
		</div>

		<!-- Toggle 4 -->
		<div class="toggle-wrap">
			<span class="trigger"><a href="#"> ¿Cómo puedo ver una propiedad antes de alquilarla?<i class="sl sl-icon-plus"></i></a></span>
			<div class="toggle-container">
				<p>Los inquilinos interesados en ver su propiedad pueden programar visitas durante el día sin que usted tenga que mostrarla. Ellos podrán acceder a la propiedad en cualquier momento a partir de las horas de visitas que usted haya establecido, mediante unas llaves en una caja de seguridad. Tú recibes una notificación por mensaje de texto cuando se programa la visita y Homebase se encarga de verificar la licencia e identificación de los visitantes antes de dar acceso la propiedad.</p>
			</div>
		</div>

		<!-- Toggle 5 -->
		<div class="toggle-wrap">
			<span class="trigger"><a href="#"> ¿Cómo funcionan los contratos digitales?<i class="sl sl-icon-plus"></i></a></span>
			<div class="toggle-container">
				<p>El alquiler se paga automáticamente usando el método de pago que usted estableció cuando firmó el contrato de arrendamiento. Es como una subscripción a Netflix; ¡ponla y olvídala!</p>
			</div>
		</div>

		<!-- Toggle 6 -->
		<div class="toggle-wrap">
			<span class="trigger"><a href="#"> ¿Qué es una suscripción de alquiler y cómo me pagan?<i class="sl sl-icon-plus"></i></a></span>
			<div class="toggle-container">
				<p>Estará conectado con un Homebase Agent durante el proceso de arrendamiento. Esta persona estará a su disposición para ayudarle en cualquier momento que tenga una pregunta o problema durante toda la duración del contrato de arrendamiento. 

Cualquier gasto relacionado con el mantenimiento y las reparaciones que caigan dentro de los deberes del Propietario o del Agente serán pagados por el Propietario o el Agent—no por ti. Puede encontrar la lista de mantenimiento y reparaciones que el Propietario es responsable en su Contrato de Arrendamiento. En caso de que necesite una reparación, le indicaremos la dirección correcta o le ayudaremos a encontrar el proveedor de servicios adecuado.
</p>
			</div>
		</div>

		<!-- Toggle 5 -->
		<div class="toggle-wrap">
			<span class="trigger"><a href="#"> ¿Qué pasa llegada la finalización del contrato de arrendamiento?<i class="sl sl-icon-plus"></i></a></span>
			<div class="toggle-container">
				<p>Sabemos que mudarse puede ser estresante, ¡así que estamos aquí para ayudar! Nos pondremos en contacto 30 días antes de que termine su contrato de alquiler para comenzar el proceso de mudanza. 

Recuerde, su depósito de seguridad se mantiene seguro con el Depósito Seguro, por lo que la cantidad total le será devuelta dentro de los 5 días de su salida, siempre y cuando no se produzcan daños durante su residencia. Si es necesario hacer alguna reparación, nos coordinaremos con el propietario y los proveedores de servicios en su nombre para garantizar una experiencia de salida sin problemas y agradable.</p>
			</div>
		</div>

	</div>
	<!-- Toggles Container / End -->


		</div>
	</div>
</section>
<!-- Fullwidth Section / End -->