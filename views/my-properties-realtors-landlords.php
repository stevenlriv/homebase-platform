<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	//Pending approval query array
	$query_approval = array();

	//We only show the listing that realtor or landlord added and do not show pending properties, but get pending counts for user
	if( !is_admin() ) {
		array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_user", "command" => "=", "value" => $user['id_user']));
		array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "!=", "value" => "pending"));

		array_push($query_approval, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_user", "command" => "=", "value" => $user['id_user']));
	}
    
    //Query for listing status
    if(!empty($_GET['status'])) {
        $type = sanitize_xss($_GET['status']);
        $_SESSION['search-status'] = $type;
    
        if($type == 'active' || $type == 'inactive') {
            $url = $url."type=$type&";
    
            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => $type));
		}
		
		//Online allow pending approval searchs for admins
        if(is_admin() && $type == 'pending') {
			$url = $url."type=$type&";
    
            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => $type));
		}	
    }
    else {
        $_SESSION['search-status'] = ''; //to reset for fields if left empty
    }

    //Lets get the query results
    $total_results = get_listings('count', $query);

	//Lets get the pending approval count
	array_push($query_approval, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "pending"));
	$pending_results = get_listings('count', $query_approval);

	//Pagination configuration
	$pagination = new Pagination($total_results, $url, 'col-md-8');
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Mis Propiedades</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Mis Propiedades</li>
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
			<?php
				if($pending_results>0 && are_messages_empty()) {
					$form_info = 'Hay '.$pending_results.' propiedades pendientes para ser aprobadas.';
				}

				show_message($form_success, $form_error, $form_info);
			?>

            <h4 class="search-title">Busque en sus propiedades</h4>
            <?php full_search_form('my-properties'); ?>
        </div>

		<div class="col-md-8">
        
			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Propiedad</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Ocupación</th>
					<th></th>
				</tr>

				<?php
                	$query_listings = get_listings('all', $query, "ORDER BY id_listing DESC LIMIT {$pagination->get_offset()}, {$pagination->get_records_per_page()}");

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
					<td class="action">
						<a href="/edit-property?q=<?php echo $value['uri']; ?>"><i class="fa fa-pencil"></i> Editar</a>
                        <?php

							//Urls
							$user_url = '/profile?id='.$value['id_user'];

							//Modify new url, so javascript object can get it '#' will be removed by javascript on the other end
							$delete_url = '#p='.$pagination->get_page().'&delete='.$value['uri'].'&confirm=true&'.$url;
							$approve_url = '#p='.$pagination->get_page().'&approve='.$value['uri'].'&confirm=true&'.$url;
							$show_url = '#p='.$pagination->get_page().'&show='.$value['uri'].'&confirm=true&'.$url;
							$hide_url = '#p='.$pagination->get_page().'&hide='.$value['uri'].'&confirm=true&'.$url;

							////////////////////////////////////////////////////////////////////////////////////////////////////

							$assign_listing_uri = '#'.$value['uri'];

							//Show the user profile only to admins
							if( is_admin() ) {
								echo '<a href="'.$user_url.'" target="_blank"><i class="fa fa-user"></i> Ver Usuario</a>';

								//Only allow property switch if the property is currently hold by an admin or super_admin
								if(is_admin_by_id($value['id_user'])) {
									echo '<a href="'.$assign_listing_uri.'" class="open-aa-pp"><i class="fa fa-users"></i> Asignar a Usuario</a>';
								}
							}

							if( is_admin() && $value['status']=='pending') {
								echo '<a href="'.$approve_url.'" class="open-ap-pp"><i class="fa fa-thumbs-up"></i> Aprobar</a>';
							}
							else {
                            	if($value['status']=='inactive') {
                                	echo '<a href="'.$show_url.'" class="open-sw-pp"><i class="fa fa-eye"></i> Mostrar</a>';
                            	}
                            	else {
                                	echo '<a href="'.$hide_url.'" class="open-hd-pp"><i class="fa fa-eye-slash"></i> Esconder</a>';
								}
							}
						?>
						<a href="<?php echo $delete_url; ?>" class="delete open-dl-pp"><i class="fa fa-remove"></i> Borrar</a>
					</td>
				</tr>
				<?php
					}
				?>

			</table>

			<?php
				$pagination->print();
			?>

		</div>

		<?php
			}
		?>

	</div>
</div>
	 