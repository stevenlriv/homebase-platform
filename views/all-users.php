<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	//Avoid showing main admin user
	array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_user", "command" => "!=", "value" => 1));

    //Lets get the query results
    $total_results = get_users('count', $query);

	//Pagination configuration
	$pagination = new Pagination($total_results, $url, 'col-md-8');
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Todos los usuarios</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Todos los usuarios</li>	
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

        <div class="col-md-8 margin-bottom-55">

            <h4 class="search-title">Busque en los usuarios</h4>
            <?php user_search_form(); ?>
        </div>

		<div class="col-md-8">
        
            <?php
				show_message($form_success, $form_error, $form_info);
			?>

			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-user"></i> Usuario</th>
					<th class="expire-date"></th>
					<th></th>
				</tr>

				<?php
                	$query_users = get_users('all', $query, "ORDER BY id_user DESC LIMIT {$pagination->get_offset()}, {$pagination->get_records_per_page()}");

					foreach ( $query_users  as $id => $value ) {
				?>
				<tr>
					<td class="title-container">
						<img src="<?php if(!empty($value['profile_image'])) { echo $value['profile_image']; } else { echo 'https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/agent-03.jpg'; }; ?>" alt="<?php echo $value['fullname']; ?>" />
						<div class="title">

                            <h4><?php echo $value['fullname']; ?></a></h4>

							<span>Type: <b><?php echo $value['type']; ?></b></span>

							<span>User Id: <b><?php echo $value['id_user']; ?></b></span>
							
							<span>From <?php if($value['country']) echo $value['country']; else echo 'Unknown'; ?> </span>
							
							<!-- Space for bottom border -->
							<span style="visibility: hidden;">space; space</span>
						</div>
					</td>
					<td class="expire-date"></td>
					<td class="action">
						<!--<a href="#"><i class="fa fa-pencil"></i> Editar</a>-->
                        <?php

							//Urls
							$user_url = '/profile?id='.$value['id_user'];

							$edit_user_url = '/edit-user?id='.$value['id_user'];

							//Modify new url, so javascript object can get it '#' will be removed by javascript on the other end
							$show_url = '#p='.$pagination->get_page().'&show='.$value['id_user'].'&confirm=true&'.$url;
							$hide_url = '#p='.$pagination->get_page().'&hide='.$value['id_user'].'&confirm=true&'.$url;

                            // User Profile Url
							echo '<a href="'.$user_url.'" target="_blank"><i class="fa fa-user"></i> Ver Usuario</a>';

							echo '<a href="'.$edit_user_url.'" target="_blank"><i class="fa fa-pencil"></i> Editar Usuario</a>';

                            if($value['status']=='inactive') {
                                echo '<a href="'.$show_url.'" class="open-us-pp"><i class="fa fa-eye"></i> Habilitar</a>';
                            }
                            else {
                                echo '<a href="'.$hide_url.'" class="open-uh-pp"><i class="fa fa-eye-slash"></i> Suspender</a>';
							}
						?>
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

	</div>
</div>
	 