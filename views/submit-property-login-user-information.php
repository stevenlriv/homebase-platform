<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
    $cache = ''; // variable needed


?>
<!-- Titlebar
================================================== -->
<div id="titlebar" class="submit-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2><i class="fa fa-plus-circle"></i> Añadir Propiedad</h2>

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
        $form_error = 'Antes de poder añadir su primera propiedad, debe: ';
		
		if($user['driver_license']=='' || $user['fs_address']=='' || $user['city']=='' || $user['fs_state']=='' || $user['postal_code']=='' || $user['country']=='') {
			$form_error .= '<br /> - <a href="/my-profile" style="color: #274abb !important">completar su perfil</a>';
		}

		if($user['bank_name']=='' || $user['bank_sole_owner']=='' || $user['bank_routing_number']=='' || $user['bank_account_number']=='') {
			$form_error .= '<br /> - <a href="/financial-settings" style="color: #274abb !important">añadir su información bancaria</a>';
		}

		show_message($form_success, $form_error, $form_info);
	?>

	</div>



	</div>
	</div>

</div>
<!-- Container / End -->