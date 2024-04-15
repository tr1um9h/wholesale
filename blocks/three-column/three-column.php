<?php
	/**
	 * Block Name: Three Column
	 */

	$block_class = 'three-column';
	$anchor = '';
	if (!empty($block['anchor'])) {
		$anchor = $block['anchor'];
	}
	if (!empty($block['className'])) {
		$block_class = $block_class . ' ' . $block['className'];
	}
	$spotlight = get_field('spotlight');
	$testimonials = get_field('testimonials');
	$signup = get_field('signup');
?>
<section <?php if ($anchor) : ?>id="<?php echo $anchor ?>"<?php endif; ?> class="<?php echo $block_class; ?>">
  <div class="container">
    <div class="row">
			<?php if ($spotlight) { ?>
        <div class="col-md-4">
          <div class="spotlight">
            <div class="title-holder">
							<?php echo wp_get_attachment_image($spotlight['icon'], 'full'); ?>
              <h3><?php echo $spotlight['card_title'] ?></h3>
            </div>
            <div class="content-holder">
              <h3><?php echo $spotlight['title'] ?></h3>
              <p class="subtitle"><?php echo $spotlight['sub_title'] ?></p>
              <div class="content"><?php echo $spotlight['content'] ?></div>
            </div>
          </div>
        </div>
			<?php } ?>
			<?php if ($testimonials) { ?>
        <div class="col-md-4">
          <div class="testimonial">
            <div id="testimonialsSlider" class="carousel slide" data-bs-ride="carousel">
							<?php if ($testimonials['testimonials']) {
								$count = 0; ?>
                <div class="carousel-inner">
									<?php foreach ($testimonials['testimonials'] as $testimonial) { ?>
                    <div class="carousel-item<?php if (!$count) {
											echo ' active';
										} ?>">
                      <div class="title-holder">
												<?php echo wp_get_attachment_image($testimonials['icon'], 'full'); ?>
                        <div class="name">
                          <h3><?php echo $testimonial['name'] ?></h3>
                          <p class="title"><?php echo $testimonial['title'] ?></p>
                        </div>
                      </div>
                      <div class="content-holder">
                        <p class="testimonial-content"><?php echo $testimonial['testimonial'] ?></p>
                        <div class="stars"><?php echo LS::starRating($testimonial['star_count']) ?></div>
                      </div>
                    </div>
										<?php
										$count++;
									} ?>
                </div>
							<?php } ?>
							<?php if ($testimonials['testimonials']) {
								$count = 0; ?>
                <div class="carousel-indicators">
									<?php foreach ($testimonials['testimonials'] as $testimonial) { ?>
                    <button type="button" data-bs-target="#testimonialsSlider"
                            data-bs-slide-to="<?php echo $count; ?>" <?php if (!$count) {
											echo 'class="active"';
										} ?> aria-current="true" aria-label="Slide <?php echo $count ?>"></button>
										<?php
										$count++;
									} ?>
                </div>
							<?php } ?>
            </div>
          </div>
        </div>
			<?php } ?>
			<?php if ($signup) { ?>
      <div class="col-md-4">
        <div class="signup">
          <div class="title-holder">
						<?php echo wp_get_attachment_image($signup['icon'], 'full'); ?>
            <h3><?php echo $signup['card_title'] ?></h3>
          </div>
          <div class="content-holder">
						<?php echo do_shortcode($signup['form_shortcode']) ?>
          </div>
        </div>
				<?php } ?>
      </div>
</section>
