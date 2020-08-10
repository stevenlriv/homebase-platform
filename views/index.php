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