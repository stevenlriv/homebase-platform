<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	//We verify if the user is an admin or a regular user
	if( $user['type'] == "super_admin" || $user['type'] == "admin" ) {
		//We will show all the listing to an admin user
	}
	else {
		//We only show the listing that realtor or landlord added
		array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_user", "command" => "=", "value" => $user['id_user']));
	}
    
    //Query for listing status
    if(!empty($_GET['status'])) {
        $type = sanitize_xss($_GET['status']);
        $_SESSION['search-status'] = $type;
    
        if($type == 'active' || $type == 'inactive') {
            $url = $url."type=$type&";
    
            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => $type));
        }
    }
    else {
        $_SESSION['search-status'] = ''; //to reset for fields if left empty
    }

    //Lets get the query results
    $total_results = get_listings('count', $query);

	//Pagination configuration
	$pagination = new Pagination($total_results, $url, 'col-md-8');
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>My Properties</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>My Properties</li>
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

		<?php 
			// Side bar
			sidebar_component();
		?>

		<?php
			if($total_results == 0 && !isset($_GET)) {
		?>
			<div class="col-md-8">
				<h3>You currently don't have properties in our platform, add your first property today.</h3>
			</div>

		<?php
			}
			else {
		?>

        <div class="col-md-8 margin-bottom-55">
			<?php
				show_message($form_success, $form_error);
			?>

            <h4 class="search-title">Search Your Properties</h4>
            <?php full_search_form('my-properties'); ?>
        </div>

		<div class="col-md-8">
        
			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Occupancy</th>
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
                            if($value['status']=='inactive') {
                                echo '<h4>'.$value['listing_title'].'</h4>';
                            }
                            else {
                                echo '<h4><a href="/'.$value['uri'].'" target="_blank">'.$value['listing_title'].'</a></h4>';
                            }
						?>
							
							<span><?php echo $value['physical_address']; ?> </span>
							<span class="table-property-price">$<?php echo $value['monthly_house']; ?> / monthly</span>
						</div>
					</td>
					<td class="expire-date"><?php 
                                
                                //Link to property lease
								if($value['available'] > date("m/d/Y")) {
									echo "<a href='#'>UNTIL {$value['available']}</a>";
								}
								else {
									echo "NONE";
								}
								
								?></td>
					<td class="action">
						<a href="/edit-property?q=<?php echo $value['uri']; ?>"><i class="fa fa-pencil"></i> Edit</a>
                        <?php

							//Modify new url, so javascript object can get it '#' will be removed by javascript on the other end
							$show_url = '#p='.$pagination->get_page().'&show='.$value['uri'].'&confirm=true&'.$url;
							$hide_url = '#p='.$pagination->get_page().'&hide='.$value['uri'].'&confirm=true&'.$url;
							$delete_url = '#p='.$pagination->get_page().'&delete='.$value['uri'].'&confirm=true&'.$url;

                            if($value['status']=='inactive') {
                                echo '<a href="'.$show_url.'" class="open-sw-pp"><i class="fa fa-eye"></i> Show</a>';
                            }
                            else {
                                echo '<a href="'.$hide_url.'" class="open-hd-pp"><i class="fa fa-eye-slash"></i> Hide</a>';
                            }
						?>
						<a href="<?php echo $delete_url; ?>" class="delete open-dl-pp"><i class="fa fa-remove"></i> Delete</a>
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
	 