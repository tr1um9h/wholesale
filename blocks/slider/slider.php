<?php
	/**
	 * Block Name: Slider
	 */

	$block_class = 'slider';
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
    <div class="row align-items-center">
      <div class="col-12 col-md-6 why-loan-simple">
        <h1 class="display-5">Why <span>Loan Simple?</span></h1>
      </div>
      <div class="col-12 col-md-4">
        <div id="verticalSlider" class="vertical carousel">
		      <?php if (have_rows('slide')) {
			      $count = 0; ?>
            <div class="carousel-indicators">
				      <?php while (have_rows('slide')) {
					      the_row(); ?>
                <button type="button" data-bs-target="#verticalSlider" data-bs-slide-to="<?php echo $count; ?>" <?php if (!$count) { echo 'class="active"'; }?> aria-current="true" aria-label="Slide <?php get_row_index() ?>"></button>
					      <?php
					      $count++;
				      } ?>
            </div>
		      <?php } ?>
		      <?php if (have_rows('slide')) {
			      $count = 0; ?>
            <div class="carousel-inner">
				      <?php while (have_rows('slide')) {
					      the_row(); ?>
                <div class="carousel-item<?php if (!$count) {
						      echo ' active';
					      } ?>">
                  <div class="row align-items-center">
                    <div class="col-3 col-sm-2">
	                    <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full'); ?>
                    </div>
                    <div class="col-9 col-sm-10">
                      <p><span><?php the_sub_field('title') ?></span> <?php the_sub_field('content') ?></p>
                    </div>
                  </div>
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
