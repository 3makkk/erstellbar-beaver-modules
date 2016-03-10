<?php

/**
 * @class FLExampleModule
 */
class ErstellbarLastPosts extends FLBuilderModule {


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
            'name'          => __('Last Posts', 'fl-builder'),
            'help'   => __('Last Posts', 'fl-builder'),
            'category'		=> __('Erstellbar Modules', 'fl-builder'),
            'dir'           => ERSTELLBAR_MODULES_DIR . 'last-posts/',
            'url'           => ERSTELLBAR_MODULES_URL . 'last-posts/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));

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
FLBuilder::register_module('ErstellbarLastPosts', array(
    'general'       => array( // Tab
        'title'         => __('Content', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general' => array(
               'label' => __('General', ERSTELLBAR_SLUG),
               'fields' => array(
                   'count' => array(
                       'type' => 'text',
                       'label' => __('Number of posts', ERSTELLBAR_SLUG)
                   )
               )
            ),
            'posts' => array(
                'label' => __('Post Settings'),
                'file' => FL_BUILDER_DIR . 'includes/loop-settings.php'
            ),
        )
    )
));
