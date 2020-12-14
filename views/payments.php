<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	//Pending approval query array
    $query = array();
    $url = '';

	//We only show the listing that realtor or landlord added and do not show pending properties, but get pending counts for user
	if( !is_admin() ) {
		array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_user", "command" => "=", "value" => $user['id_user']));
		array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "!=", "value" => "pending"));
	}

    //Lets get the query results
    $total_results = get_listings('count', $query);
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Pagos Recibidos</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Pagos Recibidos</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">

		<?php sidebar_component(); ?>

		<?php
			if($total_results == 0 && !isset($_GET)) {
		?>
			<div class="col-md-8">
				<h3>Actualmente no tiene propiedades en nuestra plataforma, añada su primera propiedad hoy.</h3>
			</div>

		<?php
			}
			else {
		?>

        <div class="col-md-8 margin-bottom-55">

            <h4 class="search-title">Lista de Pagos</h4>
        </div>

		<div class="col-md-8">
        
			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Propiedad</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Ocupación</th>
				</tr>

				<?php
                	$query_listings = get_listings('all', $query, "ORDER BY id_listing DESC");

					foreach ( $query_listings  as $id => $value ) {
				?>
				<tr>
					<td class="title-container">
						<img src="<?php echo get_json($value['listing_images'], 0); ?>" alt="<?php echo $value['physical_address']; ?>" />
						<div class="title">

                        <?php
                            //No url link if inactive due that the listing is hidden from search engines
                            if($value['status']=='inactive' || $value['status']=='pending') {
                                echo '<h4><a href="/draft?uri='.$value['uri'].'" target="_blank">'.$value['listing_title'].'</a></h4>';
                            }
                            else {
                                echo '<h4><a href="/'.$value['uri'].'" target="_blank">'.$value['listing_title'].'</a></h4>';
                            }
						?>
							
							<span><?php echo $value['physical_address']; ?> </span>

							<span class="table-property-price" style="background: #274abb; color: #fff;">$<?php echo $value['monthly_house']; ?> / listado en homebase</span>
							<span class="table-property-price">$<?php echo $value['monthly_house_original']; ?> / su depósito mensual</span>
							
							<!-- Space for bottom border -->
							<span style="visibility: hidden;">space; space</span>
						</div>
					</td>
					<td class="expire-date"><?php print_available_message('admin', $value['available']); ?></td>
				</tr>
				<?php
					}
				?>

			</table>

			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Cantidad</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Ocupación</th>
				</tr>

				<?php
                	$query_listings = get_listings('all', $query, "ORDER BY id_listing DESC");

					foreach ( $query_listings  as $id => $value ) {
				?>
				<tr>
					<td class="title-container">
						<img src="<?php echo get_json($value['listing_images'], 0); ?>" alt="<?php echo $value['physical_address']; ?>" />
						<div class="title">

                        <?php
                            //No url link if inactive due that the listing is hidden from search engines
                            if($value['status']=='inactive' || $value['status']=='pending') {
                                echo '<h4><a href="/draft?uri='.$value['uri'].'" target="_blank">'.$value['listing_title'].'</a></h4>';
                            }
                            else {
                                echo '<h4><a href="/'.$value['uri'].'" target="_blank">'.$value['listing_title'].'</a></h4>';
                            }
						?>
							
							<span><?php echo $value['physical_address']; ?> </span>

							<span class="table-property-price" style="background: #274abb; color: #fff;">$<?php echo $value['monthly_house']; ?> / listado en homebase</span>
							<span class="table-property-price">$<?php echo $value['monthly_house_original']; ?> / su depósito mensual</span>
							
							<!-- Space for bottom border -->
							<span style="visibility: hidden;">space; space</span>
						</div>
					</td>
					<td class="expire-date"><?php print_available_message('admin', $value['available']); ?></td>
				</tr>
				<?php
					}
				?>

			</table>
		</div>

		<?php
			}
		?>

	</div>
</div>
	 