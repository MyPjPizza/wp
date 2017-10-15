<?php

class GP_Unique_ID_Field extends GWField {

    function __construct($args = array()) {

        $args = array_merge( $args, array(
            'type'           => 'uid',
            'name'           => __( 'Unique ID', 'gp-unique-id' ),
            'button'         => array( 'group' => 'advanced_fields' ),
            'field_settings' => array( 'label_setting', 'uid_setting', 'conditional_logic_field_setting' ),
            'field_class'    => 'gf_hidden'
        ) );

        parent::__construct( $args );

        $this->add_tooltips();

        // temporary fix to resolve issue where UID values are overwritten when editing entry in Gravity View
        remove_filter( 'gform_field_input', array( $this, 'filter_input_html' ), 10, 5 );
        add_filter( 'gform_field_input', array( $this, 'filter_input_html' ), 11, 5 );
        add_filter( 'gform_pre_render', array( $this, 'enable_dynamic_population' ) );

        add_action( 'gform_field_standard_settings_25', array( $this, 'field_settings_ui' ) );
        add_action( 'gform_field_advanced_settings_50', array( $this, 'advanced_field_settings_ui' ) );

        add_action( 'wp_ajax_gpui_reset_starting_number', array( $this, 'ajax_reset_starting_number' ) );

        add_filter( 'gform_entry_post_save', array( $this, 'populate_field_value' ), 9, 2 ); // priority 9 so it fires before Addon framwork process feeds

    }

    function add_tooltips() {

        $this->perk->add_tooltip(
            $this->perk->key( 'type' ),
            sprintf( '<h6>%s</h6> %s', __( 'Unique ID Type', 'gp-unique-id' ), $this->get_unique_id_type_tooltip_content() )
        );

        $this->perk->add_tooltip(
            $this->perk->key( 'prefix' ),
            sprintf( '<h6>%s</h6> %s',
                __( 'Unique ID Prefix', 'gp-unique-id' ),
                sprintf( __( 'Prepend a short string to the beginning of the generated ID (i.e. %1$s%3$sabc%4$s123890678%2$s).', 'gp-unique-id' ), '<code>', '</code>', '<strong style="background-color:#fffbcc;">', '</strong>' )
            )
        );

        $this->perk->add_tooltip(
            $this->perk->key( 'suffix' ),
            sprintf( '<h6>%s</h6> %s',
                __( 'Unique ID Suffix', 'gp-unique-id' ),
                sprintf( __( 'Append a short string to the end of the generated ID (i.e. %1$s123890678%3$sxyz%4$s%2$s).', 'gp-unique-id' ), '<code>', '</code>', '<strong style="background-color:#fffbcc;">', '</strong>' )
            )
        );

        $this->perk->add_tooltip(
            $this->perk->key( 'length' ),
            sprintf( '<h6>%s</h6> %s',
                __( 'Unique ID Length', 'gp-unique-id' ),
                $this->get_unique_id_length_tooltip_content()
            )
        );

        $this->perk->add_tooltip(
            $this->perk->key( 'starting_number' ),
            sprintf( '<h6>%s</h6> %s', __( 'Unique ID Starting Number', 'gp-unique-id' ), __( 'Set the starting number for sequential IDs; only available when "Sequential" type is selected.', 'gp-unique-id' ) )
        );

        $this->perk->add_tooltip(
            $this->perk->key( 'reset' ),
            sprintf( '<h6>%s</h6> %s',
                __( 'Reset Starting Number', 'gp-unique-id' ),
                __( 'Reset the sequence to the specified starting number when it is a lower number than the current sequence.<br /><br />By default, the starting number will only apply when the current sequence is lower than the specified starting number (i.e. if the current sequence is \'1\' and the starting number is \'99\', the sequence would be updated to \'99\').<br /><br />This option is useful after you have submitted a number of test entries and would like to reset the current sequence (i.e. if the current sequence is \'12\' and you would like to reset it to \'1\').', 'gp-unique-id' )
            )
        );

    }

    function get_unique_id_type_tooltip_content() {

        $intro = __( 'Select the type of unique ID you would like to generate.', 'gp-unique-id' );
        $type_descriptions = array();

        foreach( $this->perk->get_unique_id_types() as $type ) {
            $type_descriptions[] = sprintf( '<strong>%s</strong><br />%s', $type['label'], $type['description'] );
        }

        return $intro . '<ul style=\'margin-top:10px;\'><li>' . implode( '</li><li>', $type_descriptions ) . '</li></ul>';
    }

    function get_unique_id_length_tooltip_content() {

        $intro = __( 'Set a specific length for the generated ID (excluding the prefix and suffix) or leave empty to use default length. There are some differences in length requirements for each ID type.', 'gp-unique-id' );

        $uid_types = $this->perk->get_unique_id_types();
        $length_descriptions = array(
            'alphanumeric' => sprintf( '<strong>%s</strong><br />%s', $uid_types['alphanumeric']['label'], __( 'Requires a minimum length of <code>4</code>.', 'gp-unique-id' ) ),
            'numeric'      => sprintf( '<strong>%s</strong><br />%s', $uid_types['numeric']['label'], __( 'Requires a minimum length of <code>9</code> and a maximum length of <code>19</code>.', 'gp-unique-id' ) ),
            'sequential'   => sprintf( '<strong>%s</strong><br />%s', $uid_types['sequential']['label'], __( 'Length is used to pad the number with zeros (i.e. an ID of <code>1</code> with a length of <code>5</code> would be <code>00001</code>). There is no minimum length.', 'gp-unique-id' ) )
        );

        return $intro . '<ul style=\'margin-top:10px;\'><li>' . implode( '</li><li>', $length_descriptions ) . '</li></ul>';
    }

    function input_html( $field, $value, $lead_id, $form_id ) {

        $id = $field['id'];
        $input_type = $this->is_form_editor() || $this->is_entry_detail() || self::doing_ajax('rg_add_field') ? 'text' : 'hidden';
        $field_id   = $this->is_entry_detail() ? "input_$id" : "input_{$form_id}_{$id}";
        $disabled   = $this->is_form_editor() ? "disabled='disabled'" : '';

	    extract( gf_apply_filters( 'gpui_input_html_options', array( $form_id, $field->id ), compact( 'input_type', 'disabled' ) ) );

	    $input_html = sprintf( "<input name='input_%d' id='%s' type='%s' value='%s' %s />", $id, $field_id, $input_type, esc_attr( $value ), $disabled );
	    $input_html = sprintf( "<div class='ginput_container ginput_container_%s'>%s</div>", $input_type, $input_html );

        return $input_html;
    }

    function input_html_form_editor( $field, $value, $lead_id, $form_id ) {
        return '<input
            style="border:1px dashed #ccc;background-color:transparent;padding:5px;color:#bbb;letter-spacing:.05em;text-transform:lowercase;width:330px;text-align:center;font-family:\'Open Sans\', sans-serif;"
            value="hidden field, populated on submission"
            disabled="disabled" />';
    }

    function field_settings_ui() {
        ?>

        <li class="uid_setting gwp_field_setting field_setting" xmlns="http://www.w3.org/1999/html">

            <div>
                <label for="<?php echo $this->perk->key( 'type' ); ?>">
                    <?php _e( 'Type', 'gp-unique-id' ); ?>
                    <?php gform_tooltip( $this->perk->key( 'type' ) ); ?>
                </label>
                <select name="<?php echo $this->perk->key( 'type' ); ?>" id="<?php echo $this->perk->key( 'type' ); ?>"
                        onchange="SetFieldProperty( '<?php echo $this->perk->key( 'type' ); ?>', this.value ); gpui.toggleByType( this.value );">
                    <?php foreach( $this->perk->get_unique_id_types() as $value => $type ): ?>
                        <?php printf( '<option value="%s">%s</option>', $value, $type['label'] ); ?>
                    <?php endforeach; ?>
                </select>
            </div>

        </li>

        <?php
    }

    function advanced_field_settings_ui() {
        ?>

        <li class="uid_setting gwp_field_setting field_setting">

            <div style="padding-bottom:12px;">
                <label for="<?php echo $this->perk->key( 'starting_number' ); ?>">
                    <?php _e( 'Starting Number', 'gp-unique-id' ); ?>
                    <?php gform_tooltip( $this->perk->key( 'starting_number' ) ); ?>
                </label>
                <input type="number" name="<?php echo $this->perk->key( 'starting_number' ); ?>" id="<?php echo $this->perk->key( 'starting_number' ); ?>"
                       onkeyup="SetFieldProperty( '<?php echo $this->perk->key( 'starting_number' ); ?>', this.value );"
                       onchange="SetFieldProperty( '<?php echo $this->perk->key( 'starting_number' ); ?>', this.value );"
                       style="width:75px;" />

                <a href="#" style="margin-left:10px;" onclick="gpui.resetStartingNumber( this )"><?php _e( 'reset', 'gp-unique-id' ); ?></a>
                <?php gform_tooltip( $this->perk->key( 'reset' ) ); ?>

            </div>

            <div style="padding-bottom:12px;">
                <label for="<?php echo $this->perk->key( 'length' ); ?>">
                    <?php _e( 'Length', 'gp-unique-id' ); ?>
                    <?php gform_tooltip( $this->perk->key( 'length' ) ); ?>
                </label>
                <input type="number" name="<?php echo $this->perk->key( 'length' ); ?>" id="<?php echo $this->perk->key( 'length' ); ?>"
                       onkeyup="gpui.setLengthFieldProperty( this.value );"
                       onchange="gpui.setLengthFieldProperty( this.value );"
                       onblur="gpui.setLengthFieldProperty( this.value, true );"
                       style="width:50px;" />
            </div>

            <div style="padding-bottom:12px;">
                <label for="<?php echo $this->perk->key( 'prefix' ); ?>">
                    <?php _e( 'Prefix', 'gp-unique-id' ); ?>
                    <?php gform_tooltip( $this->perk->key( 'prefix' ) ); ?>
                </label>
                <input type="text" name="<?php echo $this->perk->key( 'prefix' ); ?>" id="<?php echo $this->perk->key( 'prefix' ); ?>"
                       onkeyup="SetFieldProperty( '<?php echo $this->perk->key( 'prefix' ); ?>', this.value );" />
            </div>

            <div>
                <label for="<?php echo $this->perk->key( 'suffix' ); ?>">
                    <?php _e( 'Suffix', 'gp-unique-id' ); ?>
                    <?php gform_tooltip( $this->perk->key( 'suffix' ) ); ?>
                </label>
                <input type="text" name="<?php echo $this->perk->key( 'suffix' ); ?>" id="<?php echo $this->perk->key( 'suffix' ); ?>"
                       onkeyup="SetFieldProperty( '<?php echo $this->perk->key( 'suffix' ); ?>', this.value );" />
            </div>

        </li>

        <?php
    }

    function editor_js() {
        ?>

        <script type='text/javascript'>

            jQuery( document ).ready(function( $ ) {

                $( document).bind( 'gform_load_field_settings', function( event, field, form ) {

                    var $type       = $( '#' + gpui.key( 'type' ) ),
                        $prefix     = $( '#' + gpui.key( 'prefix' ) ),
                        $suffix     = $( '#' + gpui.key( 'suffix' ) ),
                        $length     = $( '#' + gpui.key( 'length' ) ),
                        $start      = $( '#' + gpui.key( 'starting_number' ) ),
                        $reset = $( '#' + gpui.key( 'reset' ) ),
                        type        = field[gpui.key( 'type' )];

                    $type.val( type );
                    $prefix.val( field[gpui.key( 'prefix' )] );
                    $suffix.val( field[gpui.key( 'suffix' )] );
                    $length.val( field[gpui.key( 'length' )] );
                    $start.val( field[gpui.key( 'starting_number' )] );
                    $reset.prop( 'checked', field[gpui.key( 'reset' )] == true );

                    gpui.toggleByType( type );

                } );



            } );

            var gpui;

            ( function( $ ) {

                gpui = {

                    key: function( key ) {
                        return '<?php echo $this->perk->key( '' ); ?>' + key;
                    },

                    setLengthFieldProperty: function( length, enforce ) {

                        var type    = $( '#' + gpui.key( 'type' ) ).val(),
                            length  = parseInt( length ),
                            enforce = typeof enforce != 'undefined' && enforce === true;

                        if( isNaN( length ) ) {
                            length = '';
                        } else {
                            switch( type ) {
                                case 'alphanumeric':
                                    length = Math.max( length, 4 );
                                    break;
                                case 'numeric':
                                    length = Math.max( length, 9 );
                                    length = Math.min( length, 19 );
                                    break;
                            }
                        }

                        SetFieldProperty( gpui.key( 'length' ), length );

                        if( enforce ) {
                            $( '#' + gpui.key( 'length' ) ).val( length );
                        }

                    },

                    toggleByType: function( type ) {

                        var $start = $( '#' + gpui.key( 'starting_number' ) );

                        switch( type ) {
                            case 'sequential':
                                $start.parent().show();
                                break;
                            default:
                                $start.parent().hide();
                                $start.val( '' ).change();
                        }

                    },

                    resetStartingNumber: function( elem ) {

                        var $elem         = $( elem ),
                            field         = GetSelectedField(),
                            resettingText = '<?php _e( 'resetting', 'gp-unique-id' ); ?>',
                            $response     = $( '<span />' ).text( resettingText ).css( 'margin-left', '10px' );


                        $elem.hide();
                        $response.insertAfter( $elem );

                        var loadingInterval = setInterval( function() {
                            $response.text( $response.text() + '.' );
                        }, 500 );

                        $.post( ajaxurl, {
                            action:          'gpui_reset_starting_number',
                            starting_number: $( '#' + gpui.key( 'starting_number' ) ).val(),
                            form_id:         field.formId,
                            field_id:        field.id,
                            gpui_reset_starting_number: '<?php echo wp_create_nonce( 'gpui_reset_starting_number' ); ?>'
                        }, function( response ) {

                            clearInterval( loadingInterval );

                            if( response ) {
                                response = $.parseJSON( response );
                                $response.text( response.message );
                            }

                            setTimeout( function() {
                                $response.remove();
                                $elem.show();
                            }, 4000 );

                        } );

                    }

                }

            } )( jQuery );

        </script>

    <?php
    }

    function populate_field_value( $entry, $form ) {

        foreach( $form['fields'] as $field ) {
            if( $this->is_this_field_type( $field ) && ! GFFormsModel::is_field_hidden( $form, $field, array(), $entry ) ) {
                $value = $this->save_value_to_entry( $entry['id'], $form['id'], $field, rgpost( sprintf( 'input_%d', $field->id ) ) );
                $entry[ $field['id'] ] = $value;
            }
        }

        return $entry;
    }

    function save_value_to_entry( $entry_id, $form_id, $field, $value = false ) {
        global $wpdb;

        if( ! $value ) {
            $value = gp_unique_id()->get_unique( $form_id, $field );
        }

        $result = $wpdb->insert(
            GFFormsModel::get_lead_details_table_name(),
            array(
                'lead_id'      => $entry_id,
                'form_id'      => $form_id,
                'field_number' => $field['id'],
                'value'        => $value
            ),
            array( '%d', '%d', '%d', '%s' )
        );

        return $result ? $value : false;
    }

    function ajax_reset_starting_number() {

        $form_id         = rgpost( 'form_id' );
        $field_id        = rgpost( 'field_id' );
        $starting_number = rgpost( 'starting_number' );

        if( ! check_admin_referer( 'gpui_reset_starting_number', 'gpui_reset_starting_number' ) || ! $form_id || ! $field_id || ! $starting_number ) {
            die( __( 'Oops! There was an error resetting the starting number.', 'gp-unique-id' ) );
        }

        $result = $this->perk->set_sequential_starting_number( $form_id, $field_id, $starting_number - 1 );

        if( $result == true ) {
            $response = array(
                'success' => true,
                'message' => __( 'Reset successfully!', 'gp-unique-id' )
            );
        } else if( $result === 0 ) {
            $response = array(
                'success' => false,
                'message' => __( 'Already reset.', 'gp-unique-id' )
            );
        } else {
            $response = array(
                'success' => false,
                'message' => __( 'Error resetting.', 'gp-unique-id' )
            );
        }

        die( json_encode( $response ) );
    }

    /**
     * Temporary solution to issue where Unique ID values are overwritten when editing an entry via Gravity View.
     *
     * @param $form
     *
     * @return mixed
     */
    function enable_dynamic_population( $form ) {
        foreach( $form['fields'] as &$field ) {
            if( $this->is_this_field_type( $field ) ) {
                $field['allowsPrepopulate'] = true;
                $field['inputName'] = $field['id'];
            }
        }
        return $form;
    }

}