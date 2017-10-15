<?php

/**
* Gravity Wiz Conditional Logic with Date Fields
* http://gravitywiz.com
*/

if( ! class_exists( 'GWConditionalLogicDateFields' ) ) {

    class GWConditionalLogicDateFields {

        static $script_output = false;
        static $applicable_fields = array();

        function __construct() {

	        // handles converting dates to timestamps any time form meta is retrieved (except on form editor view)
	        //add_filter( 'gform_form_post_get_meta', array( $this, 'maybe_modify_form_object' ) );

	        // handles evaluating date-based conditional logic
	        add_filter( 'gform_is_value_match',        array( $this, 'is_value_match' ), 10, 5 );

            add_filter( 'gform_admin_pre_render',      array( $this, 'allow_date_fields_in_field_select' ) );
            add_filter( 'gform_routing_field_types',   array( $this, 'set_routing_field_types' ), 10, 5 );

            add_filter( 'gform_field_content',         array( $this, 'add_logic_event_to_input' ), 10, 2 );
	        add_filter( 'gform_pre_render',            array( $this, 'enqueue_inline_script' ), 10, 2 );
	        add_filter( 'gform_pre_render',            array( $this, 'modify_frontend_form_object' ), 10 );
            add_filter( 'gform_pre_validation',        array( $this, 'modify_submitted_form_object' ), 9 );
            add_filter( 'gform_pre_submission_filter', array( $this, 'modify_submitted_form_object' ), 9 );

        }

	    /**
	     * Allow Date fields to be selected in the field select for conditional logic UI.
	     *
	     * @param mixed $form
	     */
	    function allow_date_fields_in_field_select( $form ) {
		    ?>

		    <script type="text/javascript">
			    if( window.gform ) {
				    gform.addFilter( 'gform_is_conditional_logic_field', 'gw_allow_conditional_logic_date_fields' );
				    function gw_allow_conditional_logic_date_fields( isConditionalLogicField, field ){
					    // if GF already considers this a conditional field OR if the field type is 'date'
					    return isConditionalLogicField || GetInputType( field ) == 'date';
				    }
			    }
		    </script>

		    <?php
		    return $form;
	    }

        /**
        * Add the 'onchange' event that triggers the conditional logic check when the value of the date field is changed.
        *
        * @param mixed $field_content
        * @param mixed $field
        */
        function add_logic_event_to_input( $field_content, $field ) {

	        // add to ALL date fields since there is a chance some other unkown object may be depending on it for conditional logic
            if( GFCommon::is_form_editor() || GFFormsModel::get_input_type( $field ) != 'date' || ! self::has_applicable_date_fields( $field['formId'] ) ) {
	            return $field_content;
            }

            $input_name  = "name='input_{$field['id']}'";
            $logic_event = "onchange='gf_apply_rules(" . $field["formId"] . "," . GFCommon::json_encode($field["conditionalLogicFields"]) . ");'";
	        $field_data  = sprintf( "data-date-format='%s'", $field['dateFormat'] );

	        $search  = $input_name;
	        $replace = implode( ' ', array( $input_name, $logic_event, $field_data ) );

            // include conditional logic event on original input
            $field_content = str_replace( $search, $replace, $field_content );

            return $field_content;
        }

        /**
        * Modify the front-end form object by:
        *  1 - Converting any date-based conditional logic values from date strings (ie '05/04/2013') to a timestamp (ie '1234567900')
        *  2 - Adding the 'gcldf-field' class to all date fields upon which conditional logic is dependent
        *
        * @param mixed $form
        */
        function modify_frontend_form_object( $form ) {

            $applicable_fields = self::get_applicable_date_fields( $form );
            if( empty( $applicable_fields ) )
                return $form;

            // NOTE: will be handled in via 'gform_form_post_get_meta' filter
            // don't convert date values if the form has been submitted since it will already have been converted via the "gform_pre_validation" hook
            $form = self::convert_conditional_logic_date_field_values( $form );

            // loop through fields an apply 'gcldf-field' class to applicable date fields
            foreach( $form['fields'] as &$field ) {
                $applicable_field_ids = wp_list_pluck( $applicable_fields, 'id' );
                if( in_array( $field['id'], $applicable_field_ids ) )
                    $field['cssClass'] .= ' gcldf-field';
            }

            return $form;
        }

	    function enqueue_inline_script( $form ) {

		    if( ! self::has_applicable_date_fields( $form ) || has_filter( 'wp_footer', array( $this, 'output_inline_script' ) ) ) {
			    return $form;
		    }

		    add_filter( 'wp_footer', array( $this, 'output_inline_script' ), 99 );
		    add_filter( 'gform_preview_footer', array( $this, 'output_inline_script' ) );

		    return $form;
	    }

	    function output_inline_script() {
		    ?>

		    <script type="text/javascript">

			    var gcldfIsValueMatching = false;

			    gform.addFilter( 'gform_is_value_match', 'gcldfIsValueMatch' );
			    function gcldfIsValueMatch( isMatch, formId, rule ) {

				    if( !gcldfIsValueMatching ) {
					    gcldfIsValueMatching = true;
				    } else {
					    return isMatch;
				    }

				    var sourceField = jQuery('#input_' + formId + '_' + rule.fieldId );

				    if( !sourceField.parents('li.gfield').hasClass('gcldf-field') ) {
					    gcldfIsValueMatching = false;
					    return isMatch;
				    }

				    // save the original value, will re-populate back into the field
				    var origValue = sourceField.val();

				    var formatBits = sourceField.data( 'date-format' ).split( '_' ),
					    mdy        = formatBits[0] ? formatBits[0] : 'mdy',
					    sepTypes   = { dot: '.', slash: '/', dash: '-' },
					    separator  = formatBits[1] ? sepTypes[ formatBits[1] ] : '/',
					    dateBits   = origValue.split( separator ),
					    month      = dateBits[ mdy.indexOf( 'm' ) ] - 1,
					    day        = dateBits[ mdy.indexOf( 'd' ) ],
					    year       = dateBits[ mdy.indexOf( 'y' ) ];

				    var date      = new Date( year, month, day, 0, 0, 0, 0 ),
					    tzOffset  = date.getTimezoneOffset() * 60, // convert to seconds
					    timestamp = ( date.getTime() / 1000 ) - tzOffset;

				    if( isNaN( timestamp ) ) {
					    timestamp = 0;
				    }

				    var _rule = jQuery.extend( {}, rule );

				    // modify timestamp or _rule.value so that rule always returns false until a date is selected
				    if( timestamp === 0 ) {
					    if( _rule.operator == 'isnot' ) {
						    timestamp = _rule.value;
					    } else if( _rule.operator != 'is' ) {
						    _rule.value = '';
					    }
				    }

				    var tag = rule.value.match( /{(.+?)}/ );

				    if( tag ) {

					    tag = tag[1].toLowerCase();
					    days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];

					    switch( tag ) {
						    case 'monday':
						    case 'tuesday':
						    case 'wednesday':
						    case 'thursday':
						    case 'friday':
						    case 'saturday':
						    case 'sunday':
							    timestamp   = isNaN( date.getDay() ) ? 0 : date.getDay();
							    _rule.value = String( days.indexOf( tag ) ); // generates error in GF JS if not a string
							    break;
					    }
				    }

				    sourceField.val( timestamp );

				    isMatch              = gf_is_match( formId, _rule );
				    gcldfIsValueMatching = false;

				    sourceField.val( origValue );

				    return isMatch;
			    }

		    </script>

		    <?php
	    }

        function modify_submitted_form_object( $form ) {

            if( self::has_applicable_date_fields( $form ) ) {
	            $form = self::convert_conditional_logic_date_field_values( $form );
            }

            return $form;
        }

	    function maybe_modify_form_object( $form ) {

		    if( ! in_array( GFForms::get_page(), array( 'form_editor' ) ) ) {
				$form = $this->modify_submitted_form_object( $form );
		    }

		    return $form;
	    }

        function is_value_match( $is_match, $field_value, $target_value, $operator, $source_field ) {

            if( GFFormsModel::get_input_type( $source_field ) != 'date' ) {
	            return $is_match;
            }

	        $format      = $source_field['dateFormat'] ? $source_field['dateFormat'] : 'mdy';
	        $parsed_date = GFCommon::parse_date( $field_value, $format );
	        $value       = false;

	        if( ! empty( $parsed_date ) ) {

		        $timestamp = strtotime( implode( '/', array( $parsed_date['month'], $parsed_date['day'], $parsed_date['year'] ) ) );

		        /*
		         * by default $target_value should already be converted to timestamp; some tags do not resolve to timestamps
		         * like {monday} and need to be handled here
		         */
		        preg_match_all( '/{([a-z]*)(?::(.+))?}/', $target_value, $matches, PREG_SET_ORDER );
		        if( $matches ) {
			        foreach( $matches as $match ) {

				        list( $full_value, $tag, $modifier ) = array_pad( $match, 3, '' );

				        $tag = strtolower( $tag );

				        switch( $tag ) {
					        case 'monday':
					        case 'tuesday':
					        case 'wednesday':
					        case 'thursday':
					        case 'friday':
					        case 'saturday':
					        case 'sunday':
						        $value        = date( 'N', $timestamp );
								$target_value = array_search( $tag, array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ) );
						        break;
				        }

			        }
		        } else {
			        // if no tags, assume tags have already been processed
			        $value = date( 'U', $timestamp );
		        }

	        }

	        if( $value === false ) {
		        if( $operator == 'isnot' ) {
			        $value = $target_value;
		        } else if( $operator == '>' ) {
			        $value = $target_value - 1;
		        } else if( $operator != 'is' ) {
			        $target_value = '';
		        }
	        }

            remove_filter( 'gform_is_value_match', array( $this, 'is_value_match' ) );
            $is_match = GFFormsModel::is_value_match( $value, $target_value, $operator, $source_field );
            add_filter( 'gform_is_value_match', array( $this, 'is_value_match' ), 10, 5 );

            return $is_match;
        }

	    function set_routing_field_types( $field_types ) {
		    $field_types[] = 'date';
		    return $field_types;
	    }



        // HELPERS

        /**
        * Search through each fields conditional logic and look for date fields.
        *
        * @param mixed $form
        */
        public static function get_applicable_date_fields( $form ) {

            $form_id = is_array( $form ) ? $form['id'] : $form;

            if( isset( self::$applicable_fields[$form_id] ) )
                return self::$applicable_fields[$form_id];

            if( ! is_array( $form ) )
                $form = GFFormsModel::get_form_meta( $form_id );

            self::$applicable_fields[$form_id] = self::get_applicable_fields_recursive( $form );

            return self::$applicable_fields[$form_id];
        }

        public static function get_applicable_fields_recursive( $object, $form = false, $applicable_fields = array() ) {

            // if no $form is provided, assume that the $object is the form object
            if( ! $form )
                $form = $object;

            foreach( $object as $prop => $value ) {

                if( $prop && $prop == 'conditionalLogic' && ! empty( $value ) ) {
                    foreach( $object[$prop]['rules'] as $rule ) {
                        $ruleField = RGFormsModel::get_field( $form, $rule['fieldId'] );
                        if( GFFormsModel::get_input_type( $ruleField ) == 'date' )
                            $applicable_fields[] = $ruleField;
                    }
                } else if( is_array( $value ) || is_a( $value, 'GF_Field' ) ) {
                    $applicable_fields = self::get_applicable_fields_recursive( $value, $form, $applicable_fields );
                }

            }

            return $applicable_fields;
        }

        public static function has_applicable_date_fields( $form ) {
            $applicable_fields = self::get_applicable_date_fields( $form );
            return !empty( $applicable_fields );
        }

        public static function convert_conditional_logic_date_field_values( $object, $form = false ) {

            // if no $form is provided, assume that the $object is the form object
            if( ! $form )
                $form = $object;

            foreach( $object as $prop => $value ) {

                if( $prop && $prop == 'conditionalLogic' && !empty( $value ) ) {
	                $logic = $object[$prop];
                    $logic['rules'] = self::convert_conditional_logic_rules( $value['rules'], $form );
	                $object[$prop] = $logic;
                } else if( is_array( $value ) || is_a( $value, 'GF_Field' ) ) {
                    $object[$prop] = self::convert_conditional_logic_date_field_values( $value, $form );
                }

            }

            return $object;
        }

        public static function convert_conditional_logic_rules( $rules, $form ) {

            foreach( $rules as &$rule ) {

                $rule_field = GFFormsModel::get_field( $form, $rule['fieldId'] );

                // if this rule is not based on a date field - or - if value is already a valid timestamp, don't convert
                if( GFFormsModel::get_input_type( $rule_field ) != 'date' || self::is_valid_timestamp( $rule['value'] ) ) {
	                continue;
                }

                preg_match_all( '/{([a-z]*)(?::(.+))?}/', $rule['value'], $matches, PREG_SET_ORDER );

	            $value     = $rule['value'];
	            $raw_value = false;

	            foreach( $matches as $match ) {

		            list( $full_value, $tag, $modifier ) = array_pad( $match, 3, '' );

		            $tag = strtolower( $tag );

		            switch( $tag ) {
			            case 'today':
				            // supports modifier (i.e. '+30 days'), modify time retrieved for {today} by the modifier
				            $time  = ! $modifier ? current_time( 'timestamp' ) : strtotime( $modifier, current_time( 'timestamp' ) );
				            $value = date( 'Y-m-d', $time );
				            break;
			            case 'year':
				            $time  = ! $modifier ? time() : strtotime( $modifier );
				            $year  = date( 'Y', $time );
				            $value = str_replace( $full_value, $year, $value );
				            break;
			            case 'month':
				            $time  = ! $modifier ? time() : strtotime( $modifier );
				            $month = date( 'n', $time );
				            $value = str_replace( $full_value, $month, $value );
				            break;
			            case 'day':
				            $time  = ! $modifier ? time() : strtotime( $modifier );
				            $day   = date( 'j', $time );
				            $value = str_replace( $full_value, $day, $value );
				            break;
			            case 'monday':
			            case 'tuesday':
			            case 'wednesday':
			            case 'thursday':
			            case 'friday':
			            case 'saturday':
			            case 'sunday':
							$raw_value = $value;
				            break;
			            default:
				            $value = $rule['value'];
		            }

	            }

	            // some values (like day of the week) should not be converted to dates
	            if( $raw_value ) {
		            $rule['value'] = $raw_value;
	            } else {
		            $rule['value'] = date( 'U', strtotime( $value ) );
	            }

            }

            return $rules;
        }

        /**
        * Thank you @stackoverflow:
        * http://stackoverflow.com/questions/2524680/check-whether-the-string-is-a-unix-timestamp
        *
        * @param mixed $timestamp
        */
        public static function is_valid_timestamp( $timestamp ) {
            return ( (string) (int) $timestamp === $timestamp )
                && ( $timestamp <= PHP_INT_MAX )
                && ( $timestamp >= ~PHP_INT_MAX );
        }

    }

}