<?php
	/**
	 * Block Name: Banner
	 */

	$block_class = 'banner';
	$anchor = '';
	if (!empty($block['anchor'])) {
		$anchor = $block['anchor'];
	}
	if (!empty($block['className'])) {
		$block_class = $block_class . ' ' . $block['className'];
	}
?>
<section <?php if ($anchor) : ?>id="<?php echo $anchor ?>"<?php endif; ?> class="<?php echo $block_class; ?>">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="banner-holder">
				<?php the_field('text') ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div id="testimonialsSlider" class="carousel slide" data-bs-ride="carousel">
		      <?php if( have_rows('image_slider') ) {
			      $count = 0; ?>
            <div class="carousel-inner">
				      <?php while( have_rows('image_slider') ) { the_row(); ?>
                <div class="carousel-item<?php if (!$count) {
						      echo ' active';
					      } ?>">
                  <?php echo wp_get_attachment_image(get_sub_field('image'), 'full'); ?>
                </div>
					      <?php
					      $count++;
				      } ?>
            </div>
		      <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
