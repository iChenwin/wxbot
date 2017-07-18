<?php
/**
 * Post formats template for this theme.
 *
 * @package TA Magazine
 */
 ?>

<?php $meta = get_post_custom($post->ID); ?>

<?php if ( has_post_format('audio') ): // Audio ?>
	
	<div class="post-format">
		<?php if ( isset($meta['_cmb_audio_link'][0]) && !empty($meta['_cmb_audio_link'][0]) ) { ?>
			<div class="wp-caption">
				<?php if ( has_post_thumbnail() ) { ?>
				<?php
					the_post_thumbnail( 'full', array('class' => "img-responsive") );
					$caption = get_post(get_post_thumbnail_id())->post_excerpt;
					if ( isset($caption) && $caption ) {
						echo '<div class="wp-caption-text">'.$caption.'</div>';
					}
				}
				?>
			</div>
			 <?php echo wp_audio_shortcode( array('src' => $meta['_cmb_audio_link'][0]) ); ?>
		<?php } elseif ( isset($meta['_cmb_audio_code'][0]) && !empty($meta['_cmb_audio_code'][0]) ) {
			echo '<div class="audio-container">';
			echo $meta['_cmb_audio_code'][0];
			echo '</div>';
		} ?>
	</div>
	
<?php endif; ?>

<?php if ( has_post_format('gallery') ): // Gallery ?>

	<div class="post-format">
		<?php $images = ta_post_images(); if ( !empty($images) ): ?>
		<div class="gallery">
			<!-- Main items begin -->
			<div id="sync1" class="owl-carousel owi-theme">
				<?php foreach ( $images as $image ): ?>
					<?php
					$imagelg = wp_get_attachment_image_src($image->ID, 'gallery-lg');
					$imagefull = wp_get_attachment_image_src($image->ID, 'full');
					?>
					<div class="item wp-caption">
						<a href="<?php echo $imagefull[0]; ?>" rel="lightbox">
							<img class="img-responsive" src="<?php echo $imagelg[0]; ?>" alt="<?php echo $image->post_title; ?>" />
						</a>
						<?php if ($image->post_excerpt): ?>
							<div class="wp-caption-text"><?php echo $image->post_excerpt; ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<!-- Main items end -->

			<!-- Thumbnails begin -->
			<div id="sync2" class="owl-carousel owi-theme">
				<?php foreach ( $images as $image ): ?>
					<?php $imagelg = wp_get_attachment_image_src($image->ID, 'gallery-sm'); ?>
					<div class="item">
						<img class="img-responsive" src="<?php echo $imagelg[0]; ?>" alt="<?php echo $image->post_title; ?>" />
					</div>
				<?php endforeach; ?>
			</div>
			<!-- Thumbnails end -->
		</div>
		<?php endif; ?>
	</div>
	
<?php endif; ?>

<?php if ( has_post_format('video') ): // Video ?>

	<div class="post-format">
		<?php 
			if ( isset($meta['_cmb_video_link'][0]) && !empty($meta['_cmb_video_link'][0]) ) {
				$poster = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				echo wp_video_shortcode( array('src' => $meta['_cmb_video_link'][0], 'poster' => $poster[0]) );
			} elseif ( isset($meta['_cmb_video_code'][0]) && !empty($meta['_cmb_video_code'][0]) ) {
				echo '<div class="video-container">';
				echo $meta['_cmb_video_code'][0];
				echo '</div>';
			}
		?>
	</div>
	
<?php endif; ?>