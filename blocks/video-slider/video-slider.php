<?php
	/**
	 * Block Name: Video Slider
	 */

	$block_class = 'video-slider';
	$anchor = '';
	if (!empty($block['anchor'])) {
		$anchor = $block['anchor'];
	}
	if (!empty($block['className'])) {
		$block_class = $block_class . ' ' . $block['className'];
	}
?>
<section <?php if ($anchor) : ?>id="<?php echo $anchor ?>"<?php endif; ?> class="<?php echo $block_class; ?>">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <h1><?php the_field('title') ?></h1>
        <p><?php the_field('content') ?></p>
      </div>
    </div>
    <div class="row align-items-center">
			<?php
				if (have_rows('videos')):
					$count = 0;
					while (have_rows('videos')) : the_row(); ?>

            <div class="<?php if (!$count) {
							echo 'video current col-md-6';
						} else {
							echo 'video col-md-2';
						} ?>">
              <button data-bs-toggle="modal" data-bs-target="#video-<?php echo get_row_index() ?>-modal">
								<?php echo wp_get_attachment_image(get_sub_field('placeholder_image'), 'full'); ?>
              </button>
            </div>
            <div class="modal fade" id="video-<?php echo get_row_index() ?>-modal" tabindex="-1"
                 role="dialog" aria-labelledby="video-<?php echo get_row_index() ?>-modal" aria-hidden="true">
							<?php $video_embed = get_sub_field('video');
								if (!empty($video_embed)) {
									preg_match('/src="(.+?)"/', $video_embed, $matches);
									$src = $matches[1];
									$new_src = '';
									$class = '';
									$vimeo_url = '';
									if (strpos($src, 'youtube') !== false) {
										$params = [
											'controls' => 1,
											'hd'       => 1,
											'autohide' => 1,
											'autoplay' => 1
										];
										$new_src = 'data-src="' . add_query_arg($params, $src) . '"';
										$class = 'youtube';
									} elseif (strpos($src, 'vimeo') !== false) {
										$new_src = $src;
										$class = 'vimeo';
										$new_src = 'data-vimeo-url="' . $new_src . '"';
									}
								} ?>
              <div
                class="modal-dialog modal-dialog-centered modal-dialog-media modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close <?php echo ucfirst('video ' . get_row_index()) ?> Modal"></button>
                  </div>
                  <div class="modal-body">
                    <div id="video-<?php echo get_row_index() ?>-<?php echo $class ?>-holder"
                         class="ratio ratio-16x9 <?php if ($class): echo ' ' . $class; endif; ?>"
											<?php echo $new_src; ?>>
                      <div id="video-<?php echo get_row_index() ?>-modal-<?php echo $class ?>-player"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
						<?php
						$count++;
					endwhile;
				endif;
			?>
    </div>
  </div>
</section>
