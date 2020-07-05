<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

    // We only show active properties to the lister
	array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"));

	// Hide houses that are already rented from lister
	//$qdate = strtotime(date("m/d/Y"));
	//array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "available", "command" => "<=", "value" => $qdate));

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

				<h2>All Properties</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>All Properties</li>
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
				<h3>Currently there are no properties available to market in our platform.</h3>
			</div>

		<?php
			}
			else {
		?>

        <div class="col-md-8 margin-bottom-55">
			<?php
				show_message($form_success, $form_error, $form_info);
			?>

            <h4 class="search-title">Search Properties</h4>
            <?php full_search_form('my-properties'); ?>
        </div>

		<div class="col-md-8">
        
			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Available</th>
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
                                echo '<h4><a href="/'.$value['uri'].'?ref='.$user['id_user_referral'].'" target="_blank">'.$value['listing_title'].'</a></h4>';
                            }
						?>
							
							<span><?php echo $value['physical_address']; ?> </span>

							<?php
								// Lister Earn Formula
								// Basic Logic of Business Model as of writting Jun 2020
								// 6 month lease = 2 months commision for lister divided in 6 months equal pay
								// 12 months lease = 4 months commision for lister divided in 12 months equal pay
								// 24 month lease = 8 months for lister divided in 24 months equal pay
								$lister_commision = round_homebase_fee($value['monthly_house_original'], get_setting(25));
								$earn_from = $lister_commision*2;
								$earn_up_to = $lister_commision*8;

							?>
							<span class="table-property-price">Earn from $<?php echo $earn_from; ?> up to $<?php echo $earn_up_to; ?> **</span>
						</div>
					</td>
					<td class="expire-date"><?php print_available_message('date', $value['available']); ?></td>
					<td class="action">
                        <?php
							//Modify new url, so javascript object can get it '#' will be removed by javascript on the other end
							$unique_link = '#'.get_domain().'/'.$value['uri'].'?ref='.$user['id_user_referral'];
						?>
						<a href="<?php echo $unique_link; ?>" class="open-ul-pp"><i class="fa fa-link"></i> Get Unique Link</a>
					</td>
				</tr>
				<?php
					}
				?>

			</table>

			<br />
			<p>** You can earn up to that amount by promoting this property, but you will only be paid a commission by the link clicks that converts, meaning that a successful referral rents the property. The total amount of the commission will depend on the duration of the lease referred, and will be divided into monthly payments for up to 6, 12 or 24 months depending on the specifics of that property and the lease duration.</p>

			<?php
				$pagination->print();
			?>

		</div>

		<?php
			}
		?>

	</div>
</div>
	 