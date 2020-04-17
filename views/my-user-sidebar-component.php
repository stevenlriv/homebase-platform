<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
        
        <!-- Widget -->
		<div class="col-md-4">
			<div class="sidebar left">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="/my-profile" class="current"><i class="sl sl-icon-user"></i> My Profile</a></li>
						<li><a href="/change-password"><i class="sl sl-icon-lock"></i> Change Password</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li><a href="/my-properties"><i class="sl sl-icon-docs"></i> My Properties</a></li>
						<li><a href="/submit-property"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li><a href="/logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>