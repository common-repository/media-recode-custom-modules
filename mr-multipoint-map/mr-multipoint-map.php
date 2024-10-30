<?php

class MRMultiPointMapClass extends FLBuilderModule {

    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Multi-point Map Module', 'fl-builder' ),
            'description'     => __( 'Shows multiple markers on a Google Map', 'fl-builder' ),
            'category'        => __( 'MediaRecode Modules', 'fl-builder' ),
            'dir'             => MR_MODULES_DIR . 'mr-multipoint-map/',
            'url'             => MR_MODULES_URL . 'mr-multipoint-map/',
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));

    }
}

FLBuilder::register_module( 'MRMultiPointMapClass', array(
    'content'   => array(
        'title'         => __('Content', 'fl-builder'),
        'file'          => FL_BUILDER_DIR . 'includes/loop-settings.php',
    ),
    'mr-tab-1'      => array(
        'title'         => __( 'General', 'fl-builder' ),
        'sections'      => array(
            'mr-section-1'  => array(
                'title'         => __( 'Custom Post Type Info', 'fl-builder' ),
                'fields'        => array(
                    'location_name'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Location Name', 'fl-builder' ),
                        'placeholder'   => 'Defaults to standard WP title.',
                        'help'          => __('The field name of your post that will be used for the title in the info box when a location is clicked on.')
                    ),
                    'location_field_name'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Location Field Name', 'fl-builder' ),
                        'placeholder'   => 'The field name that has the latitude and longitude.'
                    ),
                    'description_field_name'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Description Field Name', 'fl-builder' ),
                        'placeholder'   => 'Field name that has the description. Defaults to the_content()',
                        'placeholder'   => 'Defaults to the standard WordPress content area.',
                        'help'          => 'The field name of your post that contains what you would like to appear below the title in the infobox when a location is clicked on.'
                    ),
                    'zoom_level'     => array(
                        'type'          => 'text',
                        'label'         => __('Zoom Level', 'fl-builder'),
                        'size'          => 5,
                        'maxlength'     => 3,
                        'default'       => 10,
                        'placeholder'   => '10'
                    ),
                    'center_lat'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Center Latitude', 'fl-builder' ),
                        'placeholder'   => 'Required.'
                    ),
                    'center_lng'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Center Longitude', 'fl-builder' ),
                        'placeholder'   => 'Required.'
                    ),
                    'map_api_key'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Google Maps API Key', 'fl-builder' ),
                        'placeholder'   => 'Your Google Maps API key.'
                    ),
                    'post_taxonomy'    => array(
                        'type'          => 'text',
                        'label'         => __('CPT Taxonomy Name', 'fl-builder'),
                        'placeholder'   => 'Taxonomy of post type. Required if using below options.',
                        'default'       => 'Filter by category:',
                        'help'
                    ),
                    'use_category_filter' => array(
                        'type'                  => 'select',
                        'label'                 => __('Use Category Filter'),
                        'default'               => 'no',
                        'options'               => array(
                                'yes'               => __('Yes', 'fl-builder'),
                                'no'                => __('No', 'fl-builder')
                        ),
                        'toggle'    => array(
                            'yes'   => array(
                                'fields'    => array('filter_by_text')
                            ),
                            'no'    => array()
                        )
                    ),
                    'filter_by_text'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Pre-Category Filter Text', 'fl-builder' ),
                        'placeholder'   => 'Filter by category:',
                    ),
                    'use_custom_icon' => array(
                        'type'                  => 'select',
                        'label'                 => __('Use Custom Icon'),
                        'default'               => 'no',
                        'options'               => array(
                            'yes'                   => __('Yes', 'fl-builder'),
                            'no'                   => __('No', 'fl-builder')
                        ),
                        'toggle'    => array(
                            'yes'=> array(
                                'fields'    => array('icon_field_name'),
                            ),
                            'no' => array()
                        )
                    ),
                    'icon_field_name'    => array(
                        'type'          => 'text',
                        'label'         => __('Icon Field Name', 'fl-builder'),
                        'placeholder'   => 'Enter the name of the field that has the icon.',
                    ),
                    'show_marker_radius' => array(
                        'type'                  => 'select',
                        'label'                 => __('Show Marker Radius'),
                        'default'               => 'no',
                        'options'               => array(
                            'yes'                   => __('Yes', 'fl-builder'),
                            'no'                   => __('No', 'fl-builder')
                        ),
                        'toggle'    => array(
                            'yes'=> array(
                                'fields'    => array('radius_size', 'radius_field', 'fill_color', 'stroke_color', 'stroke_weight'),
                            ),
                            'no' => array()
                        )
                    ),
                    'radius_size'    => array(
                        'type'          => 'text',
                        'label'         => __('Radius in Miles', 'fl-builder'),
                    ),
                    'radius_field'    => array(
                        'type'          => 'text',
                        'label'         => __('Radius Field Name', 'fl-builder'),
                        'placeholder'   => 'The name of the field that has the radius.',
                    ),
                    'fill_color'     => array(
                        'type'  => 'color',
                        'label' => __('Fill Color', 'fl-builder'),
                        'show_reset'    => true
                    ),
                    'stroke_color'     => array(
                        'type'  => 'color',
                        'label' => __('Stroke Color', 'fl-builder'),
                        'show_reset'    => true
                    ),
                    'stroke_weight'     => array(
                        'type'  => 'text',
                        'label' => __('Stroke Weight', 'fl-builder')
                    )
                )                    
            )
        )
    ),
    'mr-tab-2'      => array(
        'title'         => __( 'Style', 'fl-builder' ),
        'sections'      => array(
            'mr-section-3'  => array(
                'title'         => __( 'Map Styling', 'fl-builder' ),
                'fields'        => array(
                    'map_height'     => array(
                        'type'          => 'text',
                        'label'         => __('Map Height', 'fl-builder'),
                        'size'          => 5,
                        'maxlength'     => 3,
                        'default'       => 500,
                        'placeholder'   => '500',
                        'description'   => 'px',
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '#mr-multi-map',
                            'property'  => 'height',
                            'unit'      => 'px'
                        )
                    )
                )
            ),
            'mr-section-4'  => array(
                'title'         => __( 'Category Filter Styling', 'fl-builder' ),
                'fields'        => array(
                    'button_margin'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Button Margin', 'fl-builder' ),
                        'size'          => 5,
                        'maxlength'     => 3,
                        'default'       => 10,
                        'placeholder'   => '10',
                        'description'   => 'px',
                        'preview'       => array(
                            'type'     => 'css',
                            'selector' => '#filter-buttons',
                            'property' => 'margin',
                            'unit'     => 'px'
                        )
                    ),
                    'button_padding'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Button Padding', 'fl-builder' ),
                        'size'          => 5,
                        'maxlength'     => 3,
                        'default'       => 10,
                        'placeholder'   => '10',
                        'description'   => 'px',
                        'preview'       => array(
                            'type'     => 'css',
                            'selector' => '#filter-buttons',
                            'property' => 'padding',
                            'unit'     => 'px'
                        )
                    ),
                    'icon_margin'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Icon Margin Right', 'fl-builder' ),
                        'size'          => 5,
                        'maxlength'     => 3,
                        'default'       => 5,
                        'placeholder'   => '5',
                        'description'   => 'px',
                        'preview'       => array(
                            'type'     => 'css',
                            'selector' => '#filter-buttons img',
                            'property' => 'margin-right',
                            'unit'     => 'px'
                        )
                    )
                )                    
            )
        )
    )
));