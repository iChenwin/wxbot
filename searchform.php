<?php
/**
 * @package TA Magazine
 *
 * Search Form Template
 */
?>

<div class="row">
	<div class="col-md-12">
		<form method="get" class="navbar-search pull-left input-group" action="<?php echo home_url( '/' ); ?>">
			<input type="text" class="form-control search-query" name="s" placeholder="<?php _e('Type and hit enter', 'ta-magazine'); ?>" />
			<div class="input-group-btn">
				<button class="btn btn-defaul" type="submit"><i class="fa fa-search"></i></button> 
			</div>
		</form>
	</div>
</div>