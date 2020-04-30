<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
	
	//We proccess the query details and the current search URL
	$url = '';
	$query = array();

	//We verify if the user is an admin or a regular user
	if( $user['type'] == "super_admin" || $user['type'] == "admin" ) {
		//array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"));
	}
	else {
		array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_user", "command" => "=", "value" => $user['id_user']));
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
			if($total_results == 0) {
		?>
			<div class="col-md-8">
				<h3>You currently don't have properties in our platform, add your first property today.</h3>
			</div>

		<?php
			}
			else {
		?>

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
							<h4><a href="/<?php echo $value['uri']; ?>" target="_blank"><?php echo $value['listing_title']; ?></a></h4>
							<span><?php echo $value['physical_address']; ?> </span>
							<span class="table-property-price">$<?php echo $value['monthly_house']; ?> / monthly</span>
						</div>
					</td>
					<td class="expire-date"><?php 
								
								if($value['available'] > date("m/d/Y")) {
									echo "YES UNTIL {$value['available']}";
								}
								else {
									echo "VACANT";
								}
								
								?></td>
					<td class="action">
						<a href="/edit-property?q=<?php echo $value['uri']; ?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="?hide=<?php echo $value['uri']; ?>"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="?delte=<?php echo $value['uri']; ?>" class="delete"><i class="fa fa-remove"></i> Delete</a>
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