<?php
	function register_wholesale_blocks($wp_customize)
	{
		$wp_customize->add_section(
			'custom_wholesale_blocks',
			[
				'title'       => __('Wholesale Blocks', 'wholesale'),
				'capability'  => 'edit_theme_options',
				'description' => __('View Wholesale Block', 'wholesale'),
				'priority'    => 20,
			]
		);

		$wp_customize->add_setting(
			'wholesale_blocks',
			[
				'default'    => '',
				'type'       => 'option', // you can also use 'theme_mod'
				'capability' => 'edit_theme_options'
			]
		);

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			'wholesale_blocks',
			[
				'label'       => __('Wholesale Blocks', 'wholesale'),
				'settings'    => 'wholesale_blocks',
				'priority'    => 10,
				'section'     => 'custom_wholesale_blocks',
				'type'        => 'text',
				'input_attrs' => [
					'readonly' => true,
				]
			]
		));

		$wp_customize->add_setting(
			'wholesale_blocks_version',
			[
				'default'    => '',
				'type'       => 'option', // you can also use 'theme_mod'
				'capability' => 'edit_theme_options'
			]
		);

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			'ls_blocks_version',
			[
				'label'       => __('Wholesale Blocks Version', 'wholesale'),
				'settings'    => 'wholesale_blocks_version',
				'priority'    => 10,
				'section'     => 'custom_wholesale_blocks',
				'type'        => 'text',
				'input_attrs' => [
					'readonly' => true,
				]
			]
		));

	}

	add_action('customize_register', 'register_wholesale_blocks');
