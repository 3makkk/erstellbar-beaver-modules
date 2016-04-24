<?php

/**
 * @class FL_Heading
 */

class ErstellbarHeadingModule extends FLBuilderModule {

    public $plugin;
	/**
	 * @method __construct
	 */
	public function __construct() {

		parent::__construct(array(
			'name'          => __( 'Heading', 'erstellbar' ),
			'description'   => __( 'Display a styled heading.', 'erstellbar' ),
			'category'		=> __( 'Erstellbar Modules', 'erstellbar' ),
			'dir'           => ERSTELLBAR_MODULES_DIR . 'heading/',
			'url'           => ERSTELLBAR_MODULES_URL . 'heading/',
		));

	}

}


/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('ErstellbarHeadingModule', array(
	'general'       => array(
		'title'         => __( 'General', 'erstellbar' ),
		'sections'      => array(
			'general'       => array(
				'title'         => __( 'Styling', 'erstellbar' ),
				'fields'        => array(
					'heading_tag'   => array(
						'type'      => 'select',
						'label'     => __( 'Heading Tag', 'erstellbar' ),
						'options'   => array(
							'h1'        => __( 'H1', 'erstellbar' ),
							'h2'		=> __( 'H2', 'erstellbar' ),
							'h3'		=> __( 'H3', 'erstellbar' ),
							'h4'		=> __( 'H4', 'erstellbar' ),
						)
					),
					'heading_align'  => array(
						'type'      => 'select',
						'label'     => __( 'Heading Alignment', 'erstellbar' ),
						'options'   => array(
							''              => __( 'None', 'erstellbar' ),
							'alignleft'     => __( 'Left', 'erstellbar' ),
							'aligncenter'   => __( 'Center', 'erstellbar' ),
							'alignright'    => __( 'Right', 'erstellbar' ),
						)
					),
					'has_ruler' => array(
						'type'      => 'select',
						'label'     => __( 'Insert Ruler?', 'erstellbar' ),
						'options'   => array(
							'no'   => __( 'No', 'erstellbar' ),
							'yes'    => __( 'Yes', 'erstellbar' ),
						),
					),
                    'color' => array(
                        'type' => 'select',
                        'label' => __('Font Color', 'erstellbar'),
                        'options' => array(
                            'primary' => 'primary',
                            'secondary' => 'secondary',
                            'white' => 'white'
                        )
                    )
				)
			),
			'content'	=> array(
				'title'		=> __( 'Title', 'erstellbar' ),
				'fields'	=> array(
					'title_text'   => array(
						'type'      => 'text',
						'label'     => __( 'Title Text', 'erstellbar' ),
					),
					'has_subtitle' => array(
						'type'      => 'select',
						'label'     => __( 'Insert Subtitle?', 'erstellbar' ),
						'options'   => array(
							'no'   => __( 'No', 'erstellbar' ),
							'yes'    => __( 'Yes', 'erstellbar' ),
						),
                        'toggle'     => array(
                            'no'     => array(
                            	'fields'	=> array()
                            ),
                            'yes'    => array(
                                'fields'	=> array( 'subtitle_text')
                            )
                        )
					),
					'subtitle_text'   => array(
						'type'      => 'text',
						'label'     => __( 'Sutitle Text', 'erstellbar' ),
					),
				)
			),
		)
	)
));