<?php

class GP_Unique_ID extends GWPerk {

    public $version = '1.2.6';
    public $min_gravity_perks_version = '1.2.8.3';
    public $field_obj;

    private static $instance = null;

    public static function get_instance( $perk_file ) {
        if( null == self::$instance )
            self::$instance = new self( $perk_file );
        return self::$instance;
    }

    public function init() {

        parent::init();

	    load_plugin_textdomain( 'gp-unique-id', false, basename( dirname( __file__ ) ) . '/languages/' );

        $this->field_obj = $this->include_field( 'GP_Unique_ID_Field', $this->get_base_path() . '/includes/class-gp-unique-id-field.php' );

    }

    protected function setup() {

        $this->create_tables();

    }

    protected function create_tables() {
		global $wpdb;

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

        if( ! empty( $wpdb->charset ) ) {
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        }

        if( ! empty( $wpdb->collate ) ) {
            $charset_collate .= " COLLATE {$wpdb->collate}";
        }

        // GF magic
        add_filter( 'dbdelta_create_queries', array( 'GFForms', 'dbdelta_fix_case' ) );

        $sql = '' .
            "CREATE TABLE {$wpdb->prefix}gpui_sequence (
                form_id mediumint(8) unsigned not null,
                field_id smallint(5) unsigned not null,
                current int(10) unsigned not null,
                UNIQUE KEY form_field (form_id,field_id)
            ) $charset_collate;";

        dbDelta( $sql );

        remove_filter( 'dbdelta_create_queries', array( 'GFForms', 'dbdelta_fix_case' ) );

    }

    public function uninstall() {
        global $wpdb;

        $this->drop_options();
        $this->drop_tables( $wpdb->prefix . 'gpui_sequence' );

    }

    public function get_unique_id_types() {

        $print_vars = array(
            '<code>',
            '</code>'
        );

        $uid_types = array(
            'alphanumeric' => array(
                'label'       => __( 'Alphanumeric', 'gp-unique-id' ),
                'description' => sprintf( __( 'Contains letters and numbers (i.e. %sa12z9%s).', 'gp-unique-id' ), $print_vars[0], $print_vars[1] )
            ),
            'numeric'      => array(
                'label'       => __( 'Numeric', 'gp-unique-id' ),
                'description' => sprintf( __( 'Contains only numbers (i.e. %s152315902%s).', 'gp-unique-id' ), $print_vars[0], $print_vars[1] )
            ),
            'sequential'   => array(
                'label'       => __( 'Sequential', 'gp-unique-id' ),
                'description' => sprintf( __( 'Contains only numbers and is sequential with previously generated IDs per field (i.e. %1$s1%2$s, %1$s2%2$s, %1$s3%2$s).', 'gp-unique-id' ), $print_vars[0], $print_vars[1] )
            )
        );

        return $uid_types;
    }

    public function get_unique( $form_id, $field, $length = 5, $atts = array() ) {

        $field_atts = array_filter( array(
            'type'            => rgar( $field, $this->key( 'type' ) ),
            'starting_number' => rgar( $field, $this->key( 'starting_number' ) ),
            'length'          => rgar( $field, $this->key( 'length' ) ),
            'prefix'          => rgar( $field, $this->key( 'prefix' ) ),
            'suffix'          => rgar( $field, $this->key( 'suffix' ) )
        ) );

        $atts = wp_parse_args( $field_atts, array(
            'type'            => 'alphanumeric', // also accepts 'numeric', 'sequential'
            'starting_number' => 1, // or any other positive integer
            'length'          => false,
            'prefix'          => '',
            'suffix'          => ''
        ) );

	    // allow $form_id and $field_id to be overridden via 'gpui_unique_id_attributes' filter
	    $field_id = $field['id'];

        /**
         * Modify the attributes that will be used to generate a unique ID.
         *
         * @since 1.0.0
         *
         * @param array $atts {
         *     An array of attributes that will be used to generate the unique ID.
         *
         *     @type string $type The type of unique ID to generate: 'alphanumeric', 'numeric', 'sequential'.
         *     @type string $starting_number The number at which to start when creating a sequential unique ID.
         *     @type string $length The length of the unique ID.
         *     @type string $prefix A string of characters to be prepended to the unique ID.
         *     @type string $suffix A string of characters to be appended to the unique ID.
         * }
         * @param integer $form_id The ID of the form for which the unique ID is being generated.
         * @param integer $field_id The ID of the field for which the unique ID is being generated.
         *
         * @see https://gist.github.com/spivurno/a40ba89899a65659f708
         */
        $atts = apply_filters( 'gpui_unique_id_attributes', $atts, $form_id, $field_id );

        extract( $atts, EXTR_OVERWRITE ); // gives us $length, $type, and $starting_number

        $length = intval( $length );

        if( $type == 'sequential' ) {

            $starting_number = max( intval( $starting_number ), 1 );
            $unique = $this->get_sequential_unique_id( $form_id, $field_id, $starting_number );

            if( $length !== false ) {
                $unique = str_pad( $unique, $length, '0', STR_PAD_LEFT );
            }

            $unique = $prefix . $unique . $suffix;
            $unique = apply_filters( 'gpui_unique_id', $unique, $form_id, $field_id );

        } else {

            for( $i = 0; $i <= 9; $i++ ) {

                switch( $type ) {
                    case 'alphanumeric':
                        $length = max( $length, 4 ); // gives us 1,413,720 possible unique IDs
                        $unique = '';
                        do {
                            $unique .= uniqid();
                        } while( strlen( $unique ) < $length );
                        $unique = substr( $unique, -$length );
                        break;
                    case 'numeric':
                        $length       = max( $length, 9 ); // gives us 3,628,800 possible unique IDs
                        $length       = min( $length, 19 ); // maximum value for a 64-bit signed integer
                        $range_bottom = intval( str_pad( '1', $length, '0' ) );
                        $range_top    = intval( str_pad( '', $length, '9' ) );
                        $unique       = rand( $range_bottom, $range_top  );
                        break;
                }

                $unique    = $prefix . $unique . $suffix;
                $unique    = apply_filters( 'gpui_unique_id', $unique, $form_id, $field_id );
                $is_unique = $this->check_unique( $unique, $form_id, $field_id );

                if( $is_unique ) {
                    break;
                } else {
                    $unique = false;
                }

            }

        }

        return $unique;
    }

    public function check_unique( $unique, $form_id, $field_id ) {
        global $wpdb;

        $query = array(
            'select' => 'SELECT ld.value',
            'from'   => "FROM {$wpdb->prefix}rg_lead_detail ld",
            'join'   => '',
            'where'  => $wpdb->prepare( '
                WHERE ld.form_id = %d
                AND CAST( ld.field_number as unsigned ) = %d
                AND ld.value = %s',
                    $form_id, $field_id, $unique
                )
        );

        $query  = apply_filters( 'gpui_check_unique_query', $query, $form_id, $field_id, $unique );
        $sql    = implode( ' ', $query );
        $result = $wpdb->get_var( $sql );

        $is_unique = empty( $result );

        return $is_unique;
    }

    public function get_sequential_unique_id( $form_id, $field_id, $starting_number = 1 ) {
        global $wpdb;

        $uid = gf_apply_filters( 'gpui_sequential_unique_id_pre_insert', array( $form_id, $field_id ), false, $form_id, $field_id, $starting_number );
        if( $uid !== false ) {
	        return $uid;
        }

        $sql = $wpdb->prepare(
            'INSERT INTO ' . $wpdb->prefix . 'gpui_sequence ( form_id, field_id, current ) VALUES ( %d, %d, ( @next := 1 ) ) ON DUPLICATE KEY UPDATE current = ( @next := current + 1 )',
            $form_id, $field_id
        );

        $wpdb->query( $sql );
        $uid = $wpdb->get_var( 'SELECT @next' );

        if( $uid >= 1 && $uid < $starting_number && $starting_number !== null ) {
            // set the starting number as one less than the actual starting number and then make a new request for the current sequence
            $this->set_sequential_starting_number( $form_id, $field_id, $starting_number - 1 );
            $uid = $this->get_sequential_unique_id( $form_id, $field_id, null );
        }

        return $uid;
    }

    public function set_sequential_starting_number( $form_id, $field_id, $starting_number ) {
        global $wpdb;

        $result = $wpdb->update( $wpdb->prefix . 'gpui_sequence', array( 'current' => $starting_number ), array( 'form_id' => $form_id, 'field_id' => $field_id ) );

        return $result;
    }

    function documentation() {
        return array(
            'type' => 'url',
            'value' => 'http://gravitywiz.com/documentation/gp-unique-id/'
        );
    }

}

function gp_unique_id() {
    return GP_Unique_ID::get_instance( null );
}

function gp_unique_id_uninstall() {

}