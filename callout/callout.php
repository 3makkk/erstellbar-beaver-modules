<?php

/**
 * @class ErstellbarModule
 */
class ErstellbarCallout extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Callout', 'erstellbar'),
			'description'   => __('A heading and snippet of text with an optional link, icon and image.', 'erstellbar'),
			'category'      => __('Erstellbar Modules', 'erstellbar'),
            'dir'           => ERSTELLBAR_MODULES_DIR .'callout/',
            'url'           => ERSTELLBAR_MODULES_URL .'callout/',
		));
	}

	/**
	 * @method update
	 * @param $settings {object}
	 */
	public function update($settings)
	{
		// Cache the photo data.
		if(!empty($settings->photo)) {

			$data = FLBuilderPhoto::get_attachment_data($settings->photo);

			if($data) {
				$settings->photo_data = $data;
			}
		}

		return $settings;
	}

	/**
	 * @method delete
	 */
	public function delete()
	{
		// Delete photo module cache.
		if($this->settings->image_type == 'photo' && !empty($this->settings->photo_src)) {
			$module_class = get_class(FLBuilderModel::$modules['photo']);
			$photo_module = new $module_class();
			$photo_module->settings = new stdClass();
			$photo_module->settings->photo_source = 'library';
			$photo_module->settings->photo_src = $this->settings->photo_src;
			$photo_module->settings->crop = $this->settings->photo_crop;
			$photo_module->delete();
		}
	}

	/**
	 * @method get_classname
	 */
	public function get_classname()
	{
		$classname = 'fl-callout fl-callout-' . $this->settings->align;

		if($this->settings->image_type == 'photo') {
			$classname .= ' fl-callout-has-photo fl-callout-photo-' . $this->settings->photo_position;
		}
		else if($this->settings->image_type == 'icon') {
			$classname .= ' fl-callout-has-icon fl-callout-icon-' . $this->settings->icon_position;
		}

		return $classname;
	}

	/**
	 * @method render_title
	 */
	public function render_title()
	{
		echo '<' . $this->settings->title_tag . ' class="fl-callout-title">';

		$this->render_image('left-title');

		echo '<span>';

		if(!empty($this->settings->link)) {
			echo '<a href="' . $this->settings->link . '" target="' . $this->settings->link_target . '" class="fl-callout-title-link">';
		}

		echo $this->settings->title;

		if(!empty($this->settings->link)) {
			echo '</a>';
		}

		echo '</span>';

		$this->render_image('right-title');

		echo '</' . $this->settings->title_tag . '>';
	}

	/**
	 * @method render_text
	 */
	public function render_text()
	{
		echo '<div class="fl-callout-text">' . $this->settings->text . '</div>';
	}

	/**
	 * @method render_link
	 */
	public function render_link()
	{
		if($this->settings->cta_type == 'link') {
			echo '<a href="' . $this->settings->link . '" target="' . $this->settings->link_target . '" class="fl-callout-cta-link">' . $this->settings->cta_text . '</a>';
		}
	}

	/**
	 * @method render_button
	 */
	public function render_button()
	{
		if($this->settings->cta_type == 'button') {

			$btn_settings = array(
				'align'             => '',
				'bg_color'          => $this->settings->btn_bg_color,
				'bg_hover_color'    => $this->settings->btn_bg_hover_color,
				'bg_opacity'        => $this->settings->btn_bg_opacity,
				'border_radius'     => $this->settings->btn_border_radius,
				'border_size'       => $this->settings->btn_border_size,
				'font_size'         => $this->settings->btn_font_size,
				'icon'              => $this->settings->btn_icon,
				'icon_position'     => $this->settings->btn_icon_position,
				'link'              => $this->settings->link,
				'link_target'       => $this->settings->link_target,
				'padding'           => $this->settings->btn_padding,
				'style'             => $this->settings->btn_style,
				'text'              => $this->settings->cta_text,
				'text_color'        => $this->settings->btn_text_color,
				'text_hover_color'  => $this->settings->btn_text_hover_color,
				'width'             => $this->settings->btn_width
			);

			echo '<div class="fl-callout-button">';
			FLBuilder::render_module_html('button', $btn_settings);
			echo '</div>';
		}
	}

	/**
	 * @method render_image
	 */
	public function render_image($position)
	{
		if($this->settings->image_type == 'photo' && $this->settings->photo_position == $position) {

			if(empty($this->settings->photo)) {
				return;
			}

			$photo_data = FLBuilderPhoto::get_attachment_data($this->settings->photo);

			if(!$photo_data) {
				$photo_data = $this->settings->photo_data;
			}

			$photo_settings = array(
				'align'         => 'center',
				'crop'          => $this->settings->photo_crop,
				'link_target'   => $this->settings->link_target,
				'link_type'     => 'url',
				'link_url'      => $this->settings->link,
				'photo'         => $photo_data,
				'photo_src'     => $this->settings->photo_src,
				'photo_source'  => 'library'
			);

			echo '<div class="fl-callout-photo">';
			FLBuilder::render_module_html('photo', $photo_settings);
			echo '</div>';
		}
		else if($this->settings->image_type == 'icon' && $this->settings->icon_position == $position) {

			$icon_settings = array(
				'bg_color'       => $this->settings->icon_bg_color,
				'bg_hover_color' => $this->settings->icon_bg_hover_color,
				'color'          => $this->settings->icon_color,
				'exclude_wrapper'=> true,
				'hover_color'    => $this->settings->icon_hover_color,
				'icon'           => $this->settings->icon,
				'link'           => $this->settings->link,
				'link_target'    => $this->settings->link_target,
				'size'           => $this->settings->icon_size,
				'text'           => '',
				'three_d'        => $this->settings->icon_3d
			);

			FLBuilder::render_module_html('icon', $icon_settings);
		}
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('ErstellbarCallout', array(
	'general'       => array(
		'title'         => __('General', 'erstellbar'),
		'sections'      => array(
			'title'         => array(
				'title'         => '',
				'fields'        => array(
					'title'         => array(
						'type'          => 'text',
						'label'         => __('Heading', 'erstellbar'),
						'preview'       => array(
							'type'          => 'text',
							'selector'      => '.fl-callout-title'
						)
					)
				)
			),
			'text'          => array(
				'title'         => __('Text', 'erstellbar'),
				'fields'        => array(
					'text'          => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'preview'       => array(
							'type'          => 'text',
							'selector'      => '.fl-callout-text'
						)
					)
				)
			)
		)
	),
	'style'         => array(
		'title'         => __('Style', 'erstellbar'),
		'sections'      => array(
			'overall_structure' => array(
				'title'         => __('Structure', 'erstellbar'),
				'fields'        => array(
					'align'         => array(
						'type'          => 'select',
						'label'         => __('Overall Alignment', 'erstellbar'),
						'default'       => 'left',
						'options'       => array(
							'center'        => __('Center', 'erstellbar'),
							'left'          => __('Left', 'erstellbar'),
							'right'         => __('Right', 'erstellbar')
						),
						'help'          => __('The alignment that will apply to all elements within the callout.', 'erstellbar'),
						'preview'       => array(
							'type'          => 'none'
						)
					)
				)
			),
			'title_structure' => array(
				'title'         => __( 'Heading Structure', 'erstellbar' ),
				'fields'        => array(
					'title_tag'     => array(
						'type'          => 'select',
						'label'         => __('Heading Tag', 'erstellbar'),
						'default'       => 'h3',
						'options'       => array(
							'h1'            => 'h1',
							'h2'            => 'h2',
							'h3'            => 'h3',
							'h4'            => 'h4',
							'h5'            => 'h5',
							'h6'            => 'h6'
						)
					),
					'title_size'    => array(
						'type'          => 'select',
						'label'         => __('Heading Size', 'erstellbar'),
						'default'       => 'default',
						'options'       => array(
							'default'       =>  __('Default', 'erstellbar'),
							'custom'        =>  __('Custom', 'erstellbar')
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array('title_custom_size')
							)
						)
					),
					'title_custom_size' => array(
						'type'              => 'text',
						'label'             => __('Heading Custom Size', 'erstellbar'),
						'default'           => '24',
						'maxlength'         => '3',
						'size'              => '4',
						'description'       => 'px'
					)
				)
			)
		)
	),
	'image'         => array(
		'title'         => __('Image', 'erstellbar'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'image_type'    => array(
						'type'          => 'select',
						'label'         => __('Image Type', 'erstellbar'),
						'default'       => 'photo',
						'options'       => array(
							'none'          => _x( 'None', 'Image type.', 'erstellbar' ),
							'photo'         => __('Photo', 'erstellbar'),
							'icon'          => __('Icon', 'erstellbar')
						),
						'toggle'        => array(
							'none'          => array(),
							'photo'         => array(
								'sections'      => array('photo')
							),
							'icon'          => array(
								'sections'      => array('icon', 'icon_colors', 'icon_structure')
							)
						)
					)
				)
			),
			'photo'         => array(
				'title'         => __('Photo', 'erstellbar'),
				'fields'        => array(
					'photo'         => array(
						'type'          => 'photo',
						'label'         => __('Photo', 'erstellbar')
					),
					'photo_crop'    => array(
						'type'          => 'select',
						'label'         => __('Crop', 'erstellbar'),
						'default'       => '',
						'options'       => array(
							''              => _x( 'None', 'Photo Crop.', 'erstellbar' ),
							'landscape'     => __('Landscape', 'erstellbar'),
							'panorama'      => __('Panorama', 'erstellbar'),
							'portrait'      => __('Portrait', 'erstellbar'),
							'square'        => __('Square', 'erstellbar'),
							'circle'        => __('Circle', 'erstellbar')
						)
					),
					'photo_position' => array(
						'type'          => 'select',
						'label'         => __('Position', 'erstellbar'),
						'default'       => 'above-title',
						'options'       => array(
							'above-title'   => __('Above Heading', 'erstellbar'),
							'below-title'   => __('Below Heading', 'erstellbar'),
							'left'          => __('Left of Text and Heading', 'erstellbar'),
							'right'         => __('Right of Text and Heading', 'erstellbar')
						)
					)
				)
			),
			'icon'          => array(
				'title'         => __('Icon', 'erstellbar'),
				'fields'        => array(
					'icon'          => array(
						'type'          => 'icon',
						'label'         => __('Icon', 'erstellbar')
					),
					'icon_position' => array(
						'type'          => 'select',
						'label'         => __('Position', 'erstellbar'),
						'default'       => 'left-title',
						'options'       => array(
							'above-title'   => __('Above Heading', 'erstellbar'),
							'below-title'   => __('Below Heading', 'erstellbar'),
							'left-title'    => __( 'Left of Heading', 'erstellbar' ),
							'right-title'   => __( 'Right of Heading', 'erstellbar' ),
							'left'          => __('Left of Text and Heading', 'erstellbar'),
							'right'         => __('Right of Text and Heading', 'erstellbar')
						)
					)
				)
			),
			'icon_colors'   => array(
				'title'         => __('Icon Colors', 'erstellbar'),
				'fields'        => array(
					'icon_color'    => array(
						'type'          => 'color',
						'label'         => __('Color', 'erstellbar'),
						'show_reset'    => true
					),
					'icon_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Hover Color', 'erstellbar'),
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'icon_bg_color' => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'erstellbar'),
						'show_reset'    => true
					),
					'icon_bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Background Hover Color', 'erstellbar'),
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'icon_3d'       => array(
						'type'          => 'select',
						'label'         => __('Gradient', 'erstellbar'),
						'default'       => '0',
						'options'       => array(
							'0'             => __('No', 'erstellbar'),
							'1'             => __('Yes', 'erstellbar')
						)
					)
				)
			),
			'icon_structure' => array(
				'title'         => __('Icon Structure', 'erstellbar'),
				'fields'        => array(
					'icon_size'     => array(
						'type'          => 'text',
						'label'         => __('Size', 'erstellbar'),
						'default'       => '30',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px'
					)
				)
			)
		)
	),
	'cta'           => array(
		'title'         => __('Call To Action', 'erstellbar'),
		'sections'      => array(
			'link'          => array(
				'title'         => __('Link', 'erstellbar'),
				'fields'        => array(
					'link'          => array(
						'type'          => 'link',
						'label'         => __('Link', 'erstellbar'),
						'help'          => __('The link applies to the entire module. If choosing a call to action type below, this link will also be used for the text or button.', 'erstellbar'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'link_target'   => array(
						'type'          => 'select',
						'label'         => __('Link Target', 'erstellbar'),
						'default'       => '_self',
						'options'       => array(
							'_self'         => __('Same Window', 'erstellbar'),
							'_blank'        => __('New Window', 'erstellbar')
						),
						'preview'       => array(
							'type'          => 'none'
						)
					)
				)
			),
			'cta'           => array(
				'title'         => __('Call to Action', 'erstellbar'),
				'fields'        => array(
					'cta_type'      => array(
						'type'          => 'select',
						'label'         => __('Type', 'erstellbar'),
						'default'       => 'none',
						'options'       => array(
							'none'          => _x( 'None', 'Call to action.', 'erstellbar' ),
							'link'          => __('Text', 'erstellbar'),
							'button'        => __('Button', 'erstellbar')
						),
						'toggle'        => array(
							'none'          => array(),
							'link'          => array(
								'fields'        => array('cta_text')
							),
							'button'        => array(
								'fields'        => array('cta_text', 'btn_icon', 'btn_icon_position'),
								'sections'      => array('btn_style', 'btn_colors', 'btn_structure')
							)
						)
					),
					'cta_text'      => array(
						'type'          => 'text',
						'label'         => __('Text', 'erstellbar'),
						'default'		=> __('Read More', 'erstellbar'),
					),
					'btn_icon'      => array(
						'type'          => 'icon',
						'label'         => __('Button Icon', 'erstellbar'),
						'show_remove'   => true
					),
					'btn_icon_position' => array(
						'type'          => 'select',
						'label'         => __('Button Icon Position', 'erstellbar'),
						'default'       => 'before',
						'options'       => array(
							'before'        => __('Before Text', 'erstellbar'),
							'after'         => __('After Text', 'erstellbar')
						)
					)
				)
			),
			'btn_colors'     => array(
				'title'         => __('Button Colors', 'erstellbar'),
				'fields'        => array(
					'btn_bg_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'erstellbar'),
						'default'       => '',
						'show_reset'    => true
					),
					'btn_bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Background Hover Color', 'erstellbar'),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'btn_text_color' => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'erstellbar'),
						'default'       => '',
						'show_reset'    => true
					),
					'btn_text_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Text Hover Color', 'erstellbar'),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					)
				)
			),
			'btn_style'     => array(
				'title'         => __('Button Style', 'erstellbar'),
				'fields'        => array(
					'btn_style'     => array(
						'type'          => 'select',
						'label'         => __('Style', 'erstellbar'),
						'default'       => 'flat',
						'options'       => array(
							'flat'          => __('Flat', 'erstellbar'),
							'gradient'      => __('Gradient', 'erstellbar'),
							'transparent'   => __('Transparent', 'erstellbar')
						),
						'toggle'        => array(
							'transparent'   => array(
								'fields'        => array('btn_bg_opacity', 'btn_border_size')
							)
						)
					),
					'btn_border_size' => array(
						'type'          => 'text',
						'label'         => __('Border Size', 'erstellbar'),
						'default'       => '2',
						'description'   => 'px',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0'
					),
					'btn_bg_opacity' => array(
						'type'          => 'text',
						'label'         => __('Background Opacity', 'erstellbar'),
						'default'       => '0',
						'description'   => '%',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0'
					)
				)  
			),
			'btn_structure' => array(
				'title'         => __('Button Structure', 'erstellbar'),
				'fields'        => array(
					'btn_width'     => array(
						'type'          => 'select',
						'label'         => __('Button Width', 'erstellbar'),
						'default'       => 'auto',
						'options'       => array(
							'auto'          => _x( 'Auto', 'Width.', 'erstellbar' ),
							'full'          => __('Full Width', 'erstellbar')
						)
					),
					'btn_font_size' => array(
						'type'          => 'text',
						'label'         => __('Font Size', 'erstellbar'),
						'default'       => '14',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px'
					),
					'btn_padding'   => array(
						'type'          => 'text',
						'label'         => __('Padding', 'erstellbar'),
						'default'       => '10',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px'
					),
					'btn_border_radius' => array(
						'type'          => 'text',
						'label'         => __('Round Corners', 'erstellbar'),
						'default'       => '4',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px'
					)
				)
			)
		)
	)
));