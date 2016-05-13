<?php

/**
 * @class FLHtmlModule
 */


class ErstellbarButton extends FLBuilderModule {

	/** 
	 * @method __construct
	 */  
	public function __construct() {

		parent::__construct(array(
			'name'          => __( 'Button', ERSTELLBAR_SLUG ),
			'description'   => __( 'Display a link button.', ERSTELLBAR_SLUG),
			'category'		=> __( 'Erstellbar Modules', ERSTELLBAR_SLUG ),
			'dir'           => ERSTELLBAR_MODULES_DIR .'button/',
			'url'           => ERSTELLBAR_MODULES_URL .'button/',
		));

	}

}

add_action( 'fl_builder_control_page-select', 'fl_page_select', 1, 4 );

function fl_page_select( $name, $value, $field, $settings ){
	?>

	    <select name="<?php echo $name; ?>"<?php if(isset($field['class'])) echo ' class="'. $field['class'] .'"'; ?>>
	        <option value="none" <?php selected($value, 'none'); ?>>----</option>
	        <?php foreach( get_pages() as $page ) : ?>
	        <option value="<?php echo $page->ID; ?>" <?php selected($value, $page->ID); ?>><?php echo $page->post_title; ?></option>
	        <?php endforeach; ?>
	    </select>

	<?php
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('ErstellbarButton', array(
	'general'       => array(
		'title'         => __( 'General', ERSTELLBAR_SLUG ),
		'sections'      => array(
			'styling'       => array(
				'title'         => __( 'Styling', ERSTELLBAR_SLUG ),
				'fields'        => array(
					'button_type'   => array(
						'type'      => 'select',
						'label'     => __( 'Button Type', ERSTELLBAR_SLUG ),
						'options'   => array(
							'default'   	=> __( 'Default', ERSTELLBAR_SLUG ),
							'primary'   	=> __( 'Primary', ERSTELLBAR_SLUG ),
							'ghost'			=> __( 'Ghost', ERSTELLBAR_SLUG ),
							'ghost-light'	=> __( 'Ghost (Light)', ERSTELLBAR_SLUG ),
						)
					),
					'button_size'   => array(
						'type'      => 'select',
						'label'     => __( 'Size of the Button', ERSTELLBAR_SLUG ),
						'options'   => array(
							''          => __( 'Normal', ERSTELLBAR_SLUG ),
							'small'     => __( 'Small', ERSTELLBAR_SLUG ),
							'big'       => __( 'Big', ERSTELLBAR_SLUG ),
						)
					),
					'button_align'  => array(
						'type'      => 'select',
						'label'     => __( 'Button Alignment', ERSTELLBAR_SLUG ),
						'options'   => array(
							''              => __( 'None', ERSTELLBAR_SLUG ),
							'alignleft'     => __( 'Left', ERSTELLBAR_SLUG ),
							'aligncenter'   => __( 'Center', ERSTELLBAR_SLUG ),
							'alignright'    => __( 'Right', ERSTELLBAR_SLUG ),
						)
					),
				)
			),
			'content'	=> array(
				'title'		=> __( 'Button Content', ERSTELLBAR_SLUG ),
				'fields'	=> array(
					'button_text'   => array(
						'type'      => 'text',
						'label'     => __( 'Button Text', ERSTELLBAR_SLUG ),
					),
					'has_icon' => array(
						'type'      => 'select',
						'label'     => __( 'Insert Icon?', ERSTELLBAR_SLUG ),
						'options'   => array(
							'no'   => __( 'No', ERSTELLBAR_SLUG ),
							'yes'    => __( 'Yes', ERSTELLBAR_SLUG ),
						),
                        'toggle'     => array(
                            'no'     => array(
                            	'fields'	=> array()
                            ),
                            'yes'    => array(
                                'fields'	=> array( 'icon', 'icon_position' )
                            )
                        )
					),
					'icon'          => array(
						'type'      => 'icon',
						'label'     => __( 'Class of the Icon', ERSTELLBAR_SLUG ),
					),
					'icon_position' => array(
						'type'      => 'select',
						'label'     => __( 'Position of the Icon', ERSTELLBAR_SLUG ),
						'options'   => array(
							'before'   => __( 'Before Text', ERSTELLBAR_SLUG ),
							'after'    => __( 'After Text', ERSTELLBAR_SLUG ),
						)
					),
				)
			),
			'link'	=> array(
				'title'		=> __( 'Link Section', ERSTELLBAR_SLUG ),
				'fields'	=>  array(
					'link_type'		=> array(
						'type'		=> 'select',
						'label'		=> __( 'Button Link Type', ERSTELLBAR_SLUG ),
						'options'	=> array(
							'link'	=> __( 'Custom Link', ERSTELLBAR_SLUG ),
							'page'	=> __( 'Page', ERSTELLBAR_SLUG ),
						),
						'toggle'	=> array(
							'link'		=> array(
								'fields'	=> array( 'button_link' ),		
							),
							'page'		=> array(
								'fields'	=> array( 'button_page_link' ),
							),
						),
					),
					'button_link'   => array(
						'type'      => 'text',
						'label'     => __( 'Link of the Button', ERSTELLBAR_SLUG ),
					),
					'button_page_link'  => array(
						'type'      => 'page-select',
						'label'     => __( 'Page', ERSTELLBAR_SLUG ),
						'description'     => __( 'Select a page.', ERSTELLBAR_SLUG ),
					),
				)
			),
		)
	)
));