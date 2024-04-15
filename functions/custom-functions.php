<?php
	if (!class_exists('LS')) {
		class LS
		{

			/**
			 * Static property to hold our singleton instance
			 *
			 */
			static $instance = false;


			/**
			 * If an instance exists, this returns it.  If not, it creates one and
			 * returns it.
			 *
			 * @return LS
			 */
			public static function init()
			{
				if (!self::$instance) {
					self::$instance = new self;
				}
				return self::$instance;
			}


			/**
			 * This is our constructor
			 *
			 * @return void
			 */

			/**
			 * changes wordpress default search functionality from '/?s=searchterm' to '/search/searchterm'
			 */
			public function wpb_change_search_url()
			{
				if (is_search() && !empty($_GET['s'])) {
					wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
					exit();
				}
			}


			/*****************************************************************************************************************
			 * Below are custom functions, specifically for this theme, and for handling special string helper functions
			 *****************************************************************************************************************/


			/**
			 * User Friendly Format of Phone Number
			 */
			public static function formatPhonenumber($phoneString)
			{
				$from = trim($phoneString);
				if (strlen($phoneString) == 11) {
					$formatPhoneNumber = ($from != "") ? sprintf("%s-%s-%s-%s", substr($from, 0, 1), substr($from, 1, 3),
						substr($from, 4, 3), substr($from, 7, 4)) : "";
				} else {
					$formatPhoneNumber = ($from != "") ? sprintf("%s-%s-%s", substr($from, 0, 3), substr($from, 3, 3),
						substr($from, 6, 4)) : "";
				}

				return $formatPhoneNumber;
			}


			/**
			 * format phone number to click to call format
			 */
			public static function clickToCall($phoneString)
			{

				$remove = ["(", ")", " "];
				$add = ["", "", "-"];
				$formatPhoneNumber = str_replace($remove, $add, $phoneString);

				return $formatPhoneNumber;
			}


			/**
			 * Gets percentage for ratings 0 to 5, rounded to the first decimal
			 */
			public static function getRatingPercent($rating)
			{
				$percent = round((round($rating, 1) / 5), 1, PHP_ROUND_HALF_ODD) * 100;

				return $percent;
			}

			public static function encode($string)
			{
				return mb_encode_numericentity($string, [0x000000, 0x10ffff, 0, 0xffffff], 'UTF-8');
			}

			public static function apostrophe($string)
			{
				$last_char = substr($string, -1);
				$apostrophe = '';
				if ($last_char === 's') {
					$apostrophe = '\'';
				} else {
					$apostrophe = '\'s';
				}
				return $string . $apostrophe;
			}

			public static function button($button, $style)
			{
				// if the button is inside an ACF repeater it is handled differently
				if (isset($button['value'])) {
					$button = $button['value'];
				}
				$href = '';
				$size = '';
				$tag = 'a';
				$target = '';
				$data_target = '';
				$data_toggle = '';
				$disabled = '';
				$data_desktop = '';
				$data_download = '';
				$video_button_class = '';
				$separate_icon_before = '';
				$separate_icon_after = '';

				if (isset($button['icon'])) {
					if ($button['style'] == 'modal-link') {
						if ($button['icon_placement'] == 'before') {
							$separate_icon_before = $button['icon'];
						} else {
							if ($button['icon_placement'] == 'after') {
								$separate_icon_after = $button['icon'];
							}
						}
						$text = $button['text'];
					} else {
						if ($button['icon_placement'] == 'before') {
							$text = $button['icon'] . '<span>' . $button['text'] . '</span>';
						} else {
							if ($button['icon_placement'] == 'after') {
								$text = '<span>' . $button['text'] . '</span>' . $button['icon'];
							} else {
								if (isset($button['text']) && $button['icon_placement'] == '') {
									$text = $button['text'];
								} else {
									$text = $button['icon'];
								}
							}
						}
					}
				} else {
					$text = $button['text'];
				}

				// if style variable is not empty, append a space
				if ($style) {
					$style = $style . ' ';
				}
				if ($button['size'] == 'btn-sm') {
					$size = $button['size'] . ' ';
					$data_desktop = 'data-desktop="btn-sm"';
				} else {
					if ($button['size']) {
						$size = $button['size'] . ' ';
					}
				}
				if ($button['page_anchor'] == 'form-block') {
					$button_id = ' id="contact"';
				} else {
					$button_id = '';
				}


				// depending on the link type, href content is different and if not linked <a> tag is replaced with <span>
				switch ($button['link_type']) {
					case 'page_link':
						if (!empty($button['page_anchor'])) {
							$href = $button['page_link'] . '#' . $button['page_anchor'];
						} else {
							$href = $button['page_link'];
						}
						break;
					case 'file':
						$href = $button['file_url'];
						$parts = parse_url($href);
						$filename = basename($parts['path']);
						$filename = strtok($filename, '.');
						$data_download = 'download="' . $filename . '"';
						break;
					case 'external_url':
						$href = $button['external_url'];
						$target = 'target= "_blank"';
						break;
					case 'page_anchor':
						$href = '#' . $button['page_anchor'];
						break;
					case 'email':
						$href = 'mailto:' . $button['email_phone'];
						break;
					case 'phone':
						$href = 'tel:+1' . $button['email_phone'];
						$style = $style . ' phone-link ';
						break;
					case 'modal':
						$tag = 'button';
						$data_target = 'data-bs-target="#' . $button['button_target'] . '-modal"';
						$data_toggle = 'data-bs-toggle="modal"';
						$button_id = ' id="modal-link"';
						if ($button['modal_content']['content_type'] == 'video') {
							$video_button_class = ' video';
						}
						break;
					case 'none':
						$tag = 'button';
						$disabled = 'disabled="disabled"';
						break;
				}

				echo $separate_icon_before . '<' . $tag . $button_id . ' class="' . $style . $size . $button['style'] . $video_button_class . '"' . $data_toggle . $data_target . $data_desktop . $data_download . ' href="' . $href . '" role="button"' . $target . $disabled . '>' . $text . '</' . $tag . '>' . $separate_icon_after;

				if ($button['link_type'] === 'modal') { ?>
					<div class="modal fade" id="<?php echo $button['button_target'] ?>-modal" tabindex="-1"
					     role="dialog" aria-labelledby="<?php echo $button['button_target'] ?>-modal" aria-hidden="true">
						<?php if (!empty($button['modal_content'])) {
							$content_type = $button['modal_content']['content_type'];
							if ($content_type == 'form') {
								if ($button['modal_content']['form_title'] || $button['modal_content']['form_description']) {
									$display_title = false;
									$display_description = false;
								} else {
									$display_title = true;
									$display_description = true;
								} ?>
								<?php $form = $button['modal_content']['form']; ?>
								<div
									class="modal-dialog modal-dialog-<?php echo $button['modal_content']['modal_position'] ?> modal-dialog-form">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="btn-close" data-bs-dismiss="modal"
											        aria-label="Close <?php echo ucfirst($button['button_target']) ?> Modal"></button>
										</div>
										<div class="modal-body">
											<div class="row justify-content-center">
												<div class="col-12">
													<?php if ($button['modal_content']['form_title'] || $button['modal_content']['form_description']) { ?>
														<?php if ($button['modal_content']['form_title']) { ?>
															<h1><?php echo $button['modal_content']['form_title'] ?></h1>
														<?php } ?>
														<?php if ($button['modal_content']['form_description']) { ?>
															<p><?php echo $button['modal_content']['form_description'] ?></p>
														<?php } ?>
													<?php } ?>
													<?php gravity_form($form, $display_title, $display_description, false, '', true); ?>
												</div>
											</div>
											<?php if (!empty(get_option('form_disclaimer'))) { ?>
												<div class="row justify-content-center">
													<div class="col-12">
														<p class="legal"><?php echo get_option('form_disclaimer'); ?></p>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } else {
								if ($content_type == 'video') {
									$video_embed = $button['modal_content']['video'];
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
											$new_src = add_query_arg($params, $src);
											$class = 'youtube';
										} elseif (strpos($src, 'vimeo') !== false) {
											$new_src = $src;
											$class = 'vimeo';
											$vimeo_url = 'data-vimeo-url="' . $new_src . '"';
										}
									} ?>
									<div
										class="modal-dialog modal-dialog-<?php echo $button['modal_content']['modal_position'] ?> modal-dialog-media modal-xl">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="btn-close" data-bs-dismiss="modal"
												        aria-label="Close <?php echo ucfirst($button['button_target']) ?> Modal"></button>
											</div>
											<div class="modal-body">
												<div id="video-<?php echo $button['button_target'] ?>-<?php echo $class ?>-holder"
												     class="ratio ratio-16x9 <?php if ($class): echo ' ' . $class; endif; ?>"
												     data-src="<?php echo $new_src ?>" <?php echo $vimeo_url; ?>>
													<div id="<?php echo $button['button_target'] ?>-modal-<?php echo $class ?>-player"></div>
												</div>
											</div>
										</div>
									</div>
								<?php } else {
									if ($content_type == 'mixed') {
										$qualify_amount = ''; ?>
										<?php if (isset($_COOKIE['SESSvalues'])) {
											$values = stripslashes($_COOKIE['SESSvalues']);
											$values = json_decode($values, true);
										} ?>
										<div
											class="modal-dialog modal-dialog-<?php echo $button['modal_content']['modal_position'] ?> modal-lg modal-dialog-mixed">
											<div class="modal-content">
												<div class="modal-header">
													<p class="modal-title">
														<?php if ($qualify_amount !== number_format_i18n(0)) {
															echo $button['modal_content']['modal_title'];
														} else {
															echo $button['modal_content']['ineligible_modal_title'];
														} ?>
													</p>
													<button type="button" class="btn-close" data-bs-dismiss="modal"
													        aria-label="Close <?php echo ucfirst($button['button_target']) ?> Modal"></button>
												</div>
												<div class="modal-body">
													<div class="row justify-content-center">
														<div class="col-12">
															<?php if ($button['modal_content']['intro_content']) { ?>
																<p class="intro-copy">
																	<?php if ($qualify_amount !== number_format_i18n(0)) {
																		echo $button['modal_content']['intro_content'];
																	} else {
																		echo $button['modal_content']['ineligible_intro_content'];
																	} ?>
																</p>
															<?php } ?>
															<?php
																if ($button['modal_content']['show_form_values'] && isset($_COOKIE['SESSvalues'])) {
																	$state = $values['state'] ?? '';
																	$age = $values['age'] ?? '';;
																	$home_value = $values['homeValue'] ?? '0';
																	$mortgage_balance = $values['mortgageBalance'] ?? '0';
																	?>
																	<?php if ($qualify_amount !== number_format_i18n(0)) { ?>
																		<ul class="checkmark">
																			<li><?php echo $button['modal_content']['form_value_bullets']['state'] ?>
																				<span><?php echo $state; ?></span></li>
																			<li><?php echo $button['modal_content']['form_value_bullets']['age'] ?>
																				<span><?php echo $age; ?></span></li>
																			<li><?php echo $button['modal_content']['form_value_bullets']['home_value'] ?>
																				<span><?php echo '$' . number_format_i18n($home_value); ?></span></li>
																			<li><?php echo $button['modal_content']['form_value_bullets']['mortgage_balance'] ?>
																				<span><?php echo '$' . number_format_i18n($mortgage_balance); ?></span></li>
																		</ul>
																	<?php } else { ?>
																		<ol class="fa-ul">
																			<li><span class="fa-li"><i class="fa-solid fa-circle-1 text-gray-800"></i></span><?php echo $button['modal_content']['form_value_bullets']['state'] ?>
																				<span><?php echo $state; ?></span></li>
																			<li><span class="fa-li"><i class="fa-solid fa-circle-2 text-gray-800"></i></span><?php echo $button['modal_content']['form_value_bullets']['age'] ?>
																				<span><?php echo $age; ?></span></li>
																			<li><span class="fa-li"><i class="fa-solid fa-circle-3 text-gray-800"></i></span><?php echo $button['modal_content']['form_value_bullets']['home_value'] ?>
																				<span><?php echo '$' . number_format_i18n($home_value); ?></span></li>
																			<li><span class="fa-li"><i class="fa-solid fa-circle-4 text-gray-800"></i></span><?php echo $button['modal_content']['form_value_bullets']['mortgage_balance'] ?>
																				<span><?php echo '$' . number_format_i18n($mortgage_balance); ?></span></li>
																		</ol>
																	<?php } ?>
																<?php } else {
																	if (have_rows($button['modal_content']['bullets'])) { ?>
																		<ul class="checkmark">
																		<?php while (have_rows($button['modal_content']['bullets'])) {
																			the_row(); ?>
																			<li><?php echo $button['modal_content']['bullets']['bullet'] ?></li>
																		<?php }
																	} ?>
																	</ul>
																<?php }
															?>
															<?php if ($button['modal_content']['closing_content']) { ?>
																<p class="closing-copy">
																	<?php if ($qualify_amount !== number_format_i18n(0)) {
																		echo $button['modal_content']['closing_content'];
																	} else {
																		echo $button['modal_content']['ineligible_closing_content'];
																	} ?>
																</p>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
									}
								}
							}
						} ?>
					</div>
				<?php }
			}


			public
			static function parseTag(
				$content,
				$tg
			) {
				if (!empty($content)) {
					$dom = new DOMDocument;
					$dom->loadHTML($content);
					$attr = [];
					foreach ($dom->getElementsByTagName($tg) as $tag) {
						foreach ($tag->attributes as $attribName => $attribNodeVal) {
							$attr[$attribName] = $tag->getAttribute($attribName);
						}
					}
					return $attr;
				}
				return false;
			}

			public
			static function randomNumber(
				$n
			) {
				$characters = '0123456789';
				$randomString = '';
				for ($i = 0; $i < $n; $i++) {
					$index = rand(0, strlen($characters) - 1);
					$randomString .= $characters[$index];
				}
				return $randomString;
			}

			public
			static function spellNumber(
				$n
			) {
				$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				return $f->format($n);
			}

			public
			static function starRating(
				$rating
			) {
				$output = '';
				for ($x = 1; $x <= $rating; $x++) {
					$output .= '<i class="fa-solid fa-star" aria-hidden="true"></i>';
				}
				if (strpos($rating, '.')) {
					$output .= '<i class="fa-solid fa-star-half" aria-hidden="true"></i>';
				}
				return $output;
			}
		}

		// Instantiate our class
		$LS = LS::init();
	}
