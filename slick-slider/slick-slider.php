<?php

/**
 * @class FLExampleModule
 */
class ErstellbarSlickSlider extends FLBuilderModule {


    public static $sliderPrefix = 'slider_';
    /** 
     * Constructor function for the module. You must pass the
     * name, help, dir and url in an array to the parent class.
     *
     * @method __construct
     */  
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Slick Slider', 'fl-builder'),
            'description'   => __('Slick Slider', 'fl-builder'),
            'category'		=> __('Erstellbar Modules', 'fl-builder'),
            'dir'           => ERSTELLBAR_MODULES_DIR . 'slick-slider/',
            'url'           => ERSTELLBAR_MODULES_URL . 'slick-slider/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
        
        /** 
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
        $this->add_js('jquery');
        
        // Register and enqueue your own
        $this->add_css('slick', ERSTELLBAR_MODULES_URL . 'assets/css/slick.css');
        $this->add_css('slick-theme', ERSTELLBAR_MODULES_URL . 'assets/css/slick-theme.css');
        $this->add_js('slick', ERSTELLBAR_MODULES_URL . 'assets/js/slick.min.js', array(), '', true);
    }


    /**
     * Get Slider Options
     *
     * Filter Slider Options and retrun them as json object
     *
     * @method getSliderOptions
     */   
    public function getSliderOptions()
    {
        $sliderOptions = array();
        foreach($this->settings as $key =>$setting) {
            if(strpos($key, self::$sliderPrefix) !== false) {
                $key = str_replace(self::$sliderPrefix, '', $key);
                $sliderOptions[$key] = $setting;
            }
        }

        return json_encode($sliderOptions);
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('ErstellbarSlickSlider', array(
    'general'       => array( // Tab
        'title'         => __('Content', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'content' => array(
                'title' => __('Content Settings', 'fl-builder'),
                'fields' => array(
                    'slide_content_type' => array(
                        'label' => __('Slider Type', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'default' => 'images',
                        'options' => array(
                            'posts' => __('Posts', ERSTELLBAR_SLUG),
                            'images' => __('Images', ERSTELLBAR_SLUG),
                            'custom' => __('Custom', ERSTELLBAR_SLUG)
                        ),
                        'toggle' => array(
                            'posts' => array(
                                'sections' => array('posts'),
                                'fields' => array()
                            ),
                            'images' => array(
                                'sections' => array(),
                                'fields' => array('images')
                            ),
                            'custom' => array(
                                'sections' => array('custom_slides'),
                                'fields' => array()
                            ),
                        )
                    ),
                    'images' => array(
                        'label' => __('Slider Gallery', ERSTELLBAR_SLUG),
                        'type' => 'multiple-photos'
                    )
                )
            ),
            'posts' => array(
                'label' => __('Post Settings', ERSTELLBAR_SLUG),
                'file' => FL_BUILDER_DIR . 'includes/loop-settings.php'
            ),
            'custom_slides' => array(
                'title' => __('Custom Slider', ERSTELLBAR_SLUG),
                'fields' => array(
                    'custom' => array(
                        'label' => __('Slide', ERSTELLBAR_SLUG),
                        'type' => 'textarea',
                        'multiple' => true
                    )
                )
            )
        )
    ),
    ErstellbarSlickSlider::$sliderPrefix.'settings' => array(
        'title' => __('Slider Settings', ERSTELLBAR_SLUG),
        'sections' => array(
            'general'       => array( // Section
                'title'         => __('Settings', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
                    ErstellbarSlickSlider::$sliderPrefix.'accessibility' => array(
                        'label' => __('Accessibility', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Enables tabbing and arrow key navigation', ERSTELLBAR_SLUG),

                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'adaptiveHeight' => array(
                        'label' => __('Adaptive Height', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Adapts slider height to the current slide', ERSTELLBAR_SLUG),

                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'autoplay' => array(
                        'label' => __('Autoplay', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Enables auto play of slides', ERSTELLBAR_SLUG),
                        'toggle' => array(
                            true => array('fields' => array('autoplaySpeed')),
                            false => array()
                        )
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'autoplaySpeed' => array(
                        'label' => __('Autoplay Speed', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 3000,
                        'help' => __('Auto play change interval', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'centerMode' => array(
                        'label' => __('Center Mode', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'toggle' => array(
                            true => array('fields' => array('centerPadding')),
                            false => array()
                        ),
                        'help' => __('Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'centerPadding' => array(
                        'label' => __('Center Padding', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => '50px',
                        'help' => __('Side padding when in center mode. (px or %)', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'cssEase' => array(
                        'label' => __('CSS Ease', ERSTELLBAR_SLUG),
                        'type' => 'text',
                        'default' => 'ease',
                        'help' => __('CSS3 easing', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'dots' => array(
                        'label' => 'Dots',
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Current slide indicator dots', ERSTELLBAR_SLUG),
                        'toggle' => array(
                            true => array('fields' => array('dotsClass')),
                            false => array()
                        ),
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'dotsClass' => array(
                        'label' => __('Dots Class', ERSTELLBAR_SLUG),
                        'type' => 'text',
                        'default' => 'slick-dots',
                        'help' => 'Class for slide indicator dots container'
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'draggable' => array(
                        'label' => __('Draggable', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Enables desktop dragging', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'easing' => array(
                        'label' => 'Easing',
                        'type' => 'text',
                        'default' => 'linear',
                        'help' => __('animate() fallback easing', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'edgeFriction' => array(
                        'label' => __('Edge Friction', ERSTELLBAR_SLUG),
                        'type' => 'text',
                        'default' => '0.15',
                        'help' => __('Resistance when swiping edges of non-infinite carousels', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'fade' => array(
                        'label' => 'Fade',
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => 'Enables fade',
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'arrows' => array(
                        'label' => __('Arrows', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Enable Next/Prev arrows', ERSTELLBAR_SLUG),
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'mobileFirst' => array(
                        'label' => __('Mobile First', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Responsive settings use mobile first calculation', ERSTELLBAR_SLUG),
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'infinite' => array(
                        'label' => __('Infinite', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Infinite looping', ERSTELLBAR_SLUG),
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'lazyLoad' => array(
                        'label' => __('Lazy Load', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            'ondemand' => 'ondemand',
                            'progressive' => 'progressive',
                        ),
                        'default' => 'ondemand',
                        'help' => __('Accepts \'ondemand\' or \'progressive\' for lazy load technique. \'ondemand\' will load the image as soon as you slide to it, \'progressive\' loads one image after the other when the page loads.', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'pauseOnFocus' => array(
                        'label' => __('Pause on focus', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Pauses autoplay when slider is focussed', ERSTELLBAR_SLUG),
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'pauseOnHover' => array(
                        'label' => __('Pause on hover', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Pauses autoplay on hover', ERSTELLBAR_SLUG),
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'pauseOnDotsHover' => array(
                        'label' => __('Pause on dots hover', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => 'Pauses autoplay when a dot is hovered',
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'respondTo' => array(
                        'label' => __('Respond to', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            'window' => 'window',
                            'slider' => 'slider',
                            'min' => 'min'
                        ),
                        'default' => 'window',
                        'help' => __('Width that responsive object responds to. Can be \'window\', \'slider\' or \'min\' (the smaller of the two).', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'rows' =>array(
                        'label' => __('Rows', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 1,
                        'help' => __('Setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'slidesPerRow' => array(
                        'label' => __('Slides per row' ,ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 1,
                        'help' => __('With grid mode intialized via the rows option, this sets how many slides are in each grid row.', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'slidesToShow' => array(
                        'label' => __('Slides to show', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 1,
                        'help' => __('# of slides to show at a time', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'slidesToScroll' => array(
                        'label' => __('Slides to scroll', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 1,
                        'help' => __('# of slides to scroll at a time', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'speed' => array(
                        'label' => __('Speed', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 300,
                        'help' => __('Transition speed', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'swipe' => array(
                        'label' => __('Swipe', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Enables touch swipe', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'swipeToSlide' => array(
                        'label' => __('Swipe to swipe', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => 'Swipe to slide irrespective of slidesToScroll'
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'touchMove' => array(
                        'label' => __('Touch Move', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Enables slide moving with touch', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'touchThreshold' => array(
                        'label' => __('Touch threshold', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 5,
                        'help' => __('To advance slides, the user must swipe a length of (1/touchThreshold) * the width of the slider.', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'useCSS' => array(
                        'label' => __('Use CSS', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Enable/Disable CSS Transitions', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'useTransform' => array(
                        'label' => 'Use transform',
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => true,
                        'help' => __('Enable/Disable CSS Transforms', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'variableWidth' => array(
                        'label' => __('Variable width', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Disables automatic slide width calculation', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'vertical' => array(
                        'label' => __('Vertical', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Vertical slide direction', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'verticalSwiping' => array(
                        'label' => __('Vertical swiping', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Changes swipe direction to vertical', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'rtl' => array(
                        'label' => __('RTL', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Change the slider\'s direction to become right-to-left', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'waitForAnimate' => array(
                        'label' => __('Wait for animate', ERSTELLBAR_SLUG),
                        'type' => 'select',
                        'options' => array(
                            true => __('Yes', ERSTELLBAR_SLUG),
                            false => __('No', ERSTELLBAR_SLUG),
                        ),
                        'default' => false,
                        'help' => __('Ignores requests to advance the slide while animating', ERSTELLBAR_SLUG)
                    ),
                    ErstellbarSlickSlider::$sliderPrefix.'zIndex' => array(
                        'label' => __('Z Index', ERSTELLBAR_SLUG),
                        'type' => 'erstellbar-number',
                        'default' => 1,
                        'help' => __('Set the zIndex values for slides, useful for IE9 and lower', ERSTELLBAR_SLUG)
                    )

                )
            )
        )
    )
));
