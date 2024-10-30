<?php

add_filter( 'fl_builder_register_settings_form', function ( $form, $id ) {
    if ( 'row' == $id ) {
        $form['tabs']['mr-rows'] = [
            'title' => __('Row Shortcodes', 'fl-builder'),
            'sections' => [
                'row_shortcodes' => [
                    'title'  => __('Before & After Row Shortcodes', 'fl-builder'),
                    'fields' => [ 
                        'enable_shortcodes' => [
                            'type' => 'select',
                            'label' => __( 'Before and After Shortcodes', 'fl-builder' ),
                            'default' => 'no',
                            'options' => [ 
                                'yes' => __('Yes', 'fl-builder'),
                                'no' => __('No', 'fl-builder')
                            ],
                            'toggle'    => [
                                'yes'   => [
                                    'fields'    => ['before_shortcode', 'after_shortcode']
                                ],
                                'no'    => []
                            ]
                        ],
                        'before_shortcode'  => [
                            'type'  => 'text',
                            'label' => __('Before row shortcode', 'fl-builder')
                        ],
                        'after_shortcode'   => [
                            'type'  => 'text',
                            'label' => __('After row shortcode', 'fl-builder')
                        ]

                    ]
                ]
            ]
        ];        
    }

    return $form;
}, 10, 2 );


add_action( 'fl_builder_before_render_row', function( $row, $groups ) {
    if ( $row->settings->enable_shortcodes == 'yes' ) {
        echo $row->settings->before_shortcode;
    }
}, 10, 2 );

add_action( 'fl_builder_after_render_row', function( $row, $groups ) {
    if ( $row->settings->enable_shortcodes == 'yes' ) {
        echo $row->settings->after_shortcode;
    }
}, 10, 2 );