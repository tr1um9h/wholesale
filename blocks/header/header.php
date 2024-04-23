<?php
	/**
	 * Block Name: Header
	 */

	$block_class = 'header';
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
      <div class="col-10">
        <div class="row justify-content-center align-items-center">
          <div class="col-md-3">
	          <?php echo wp_get_attachment_image(get_field('image'), 'full'); ?>
          </div>
          <div class="col-md-8">
            <h1 class="display-3"><?php the_field('title'); ?></h1>
            <p><?php the_field('content'); ?></p>
          </div>
        </div>
      </div>
		</div>
	</div>
</section>
