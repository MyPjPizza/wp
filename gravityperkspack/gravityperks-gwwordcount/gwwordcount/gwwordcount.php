<?php

/**
* Plugin Name: GP Word Count
* Description: Limit the number of words that can be submitted in a Single Line Text, Paragraph Text and Post Body fields.
* Plugin URI: http://gravitywiz.com/
* Version: 1.4.1
* Author: David Smith
* Author URI: http://gravitywiz.com/
* License: GPL2
* Perk: True
*/

/**
* Saftey net for individual perks that are active when core Gravity Perks plugin is inactive.
*/
$gw_perk_file = __FILE__;
if(!require_once(dirname($gw_perk_file) . '/safetynet.php'))
    return;

class GWWordCount extends GWPerk {

    public $version = '1.4.1';

    private static $supported_field_types = array( 'text', 'textarea', 'post_content', 'post_title' );
    
    function init() {
        
        $this->enqueue_field_settings();
        
        $this->add_tooltip("{$this->slug}_min_word_count", '<h6>' . __( 'Minimum Word Count', 'gravityperks' ) . '</h6>' . __( 'The minimum number of words that must be entered in this field. Leave empty if there is no minimum.', 'gravityperks' ) );
        $this->add_tooltip("{$this->slug}_max_word_count", '<h6>' . __( 'Maximum Word Count', 'gravityperks' ) . '</h6>' . __( 'The maximum number of words that must be entered in this field. Leave empty if there is no maximum.', 'gravityperks' ) );
        
        add_action('gform_enqueue_scripts', array(&$this, 'enqueue_form_scripts'));
        add_action('gform_register_init_scripts', array(&$this, 'register_init_scripts'));
        add_filter('gform_validation', array(&$this, 'validate'));
        
    }
    
    function field_settings_ui() {
        ?>
        
        <li class="<?php echo $this->slug; ?>_setting gwp_field_setting field_setting" style="display:none;">
                
            <div class="gwp-option half">
                <label for="<?php echo $this->slug; ?>_min_word_count">
                    <?php _e("Min Word Count", "gravityperks"); ?>
                    <?php gform_tooltip("{$this->slug}_min_word_count") ?>
                </label>
                <input type="text" id="<?php echo $this->slug; ?>_min_word_count" onblur="SetFieldProperty('<?php echo $this->slug; ?>_min_word_count', this.value);" />
            </div>
            
            <div class="gwp-option half">
                <label for="<?php echo $this->slug; ?>_max_word_count">
                    <?php _e("Max Word Count", "gravityperks"); ?>
                    <?php gform_tooltip("{$this->slug}_max_word_count") ?>
                </label>
                <input type="text" id="<?php echo $this->slug; ?>_max_word_count" onblur="SetFieldProperty('<?php echo $this->slug; ?>_max_word_count', this.value);" />
            </div>
            
            <div class="clear"></div>
            
        </li>
        
        <?php
    }
    
    function field_settings_js() {
        ?>
        
        <script type="text/javascript">
        
        jQuery(function($){
            
            <?php foreach(self::$supported_field_types as $field_type): ?>
                fieldSettings['<?php echo $field_type; ?>'] += ", .<?php echo $this->slug; ?>_setting";
            <?php endforeach; ?>
            
            $(document).bind('gform_load_field_settings', function(event, field) {
                
                jQuery('#<?php echo $this->slug; ?>_min_word_count').val(field['<?php echo $this->slug; ?>_min_word_count']);
                jQuery('#<?php echo $this->slug; ?>_max_word_count').val(field['<?php echo $this->slug; ?>_max_word_count']);
                
            });
            
        });
        
        </script>
        
        <?php
    }
    
    public function enqueue_form_scripts($form) {
        
        foreach($form['fields'] as $field) {
            if($this->field_prop($field, 'min_word_count') || $this->field_prop($field, 'max_word_count')) {
                wp_enqueue_script( 'textareaCounter', $this->get_base_url() . '/scripts/jquery.textareaCounter.js', array( 'jquery', 'gform_gravityforms' ) );
                return;
            }
        }
        
    }
    
    /**
    * Register counter on applicable fields when the form is displayed.
    * 
    * Only need to apply the script when a max word count is specified. Min word count is only handled via PHP.
    * 
    * @param mixed $form
    */
    public function register_init_scripts( $form ) {
        
        $script = '';
        $default_args = array(
	        'limit'                   => 0,
	        'min'                     => 0,
	        'truncate'                => true,
	        'defaultLabel'            => sprintf( __( 'Max: %s words', 'gravityperks' ), '{limit}' ),
	        'defaultLabelSingular'    => sprintf( __( 'Max: %s word', 'gravityperks' ), '{limit}' ),
	        'counterLabel'            => sprintf( __( '%s words left', 'gravityperks' ), '{remaining}' ),
	        'counterLabelSingular'    => sprintf( __( '%s word left', 'gravityperks' ), '{remaining}' ),
	        'limitReachedLabel'       => '<span class="gwwc-max-reached" style="font-weight:bold;">' . sprintf( __( '%s words left', 'gravityperks' ), '{remaining}' ) . '</span>',
	        'limitExceededLabel'      => '<span class="gwwc-max-exceeded" style="font-weight:bold;color:#c0392b;">' . sprintf( __( 'Limit exceeded!', 'gravityperks' ), '{remaining}' ) . '</span>',
            'minCounterLabel'         => sprintf( __( '%s more words required', 'gravityperks' ), '{remaining}' ),
            'minCounterLabelSingular' => sprintf( __( '%s more word required', 'gravityperks' ), '{remaining}' ),
            'minReachedLabel'         => '<span class="gwwc-min-reached" style="font-weight:bold;color:#27ae60">' . __( 'Minimum word count met.', 'gravityperks' ) . '</span>',
	        'minDefaultLabel'         => sprintf( __( 'Min: %s words', 'gravityperks' ), '{min}' ),
	        'minDefaultLabelSingular' => sprintf( __( 'Min: %s word', 'gravityperks' ), '{min}' ),
        );

        foreach( $form['fields'] as $field ) {

            $has_min_word_count = $this->field_prop( $field, 'min_word_count' );
            $has_max_word_count = $this->field_prop( $field, 'max_word_count' );

            if( $has_min_word_count || $has_max_word_count ) {

                $default_args['limit'] = $has_max_word_count;
                $default_args['min']   = $has_min_word_count;

	            $args    = apply_filters( 'gpwc_script_args', $default_args, $field, $form );
                $script .= sprintf( 'jQuery( \'#input_%d_%d\' ).textareaCounter( %s );', $form['id'], $field['id'], json_encode( $args ) );

            }
            
        }
        
        if( ! $script ) {
	        return;
        }

        // run on conditional logic so the label will get reset when field is hidden and then shown (gf clears all values from fields when hidden)
        GFFormDisplay::add_init_script($form['id'], $this->slug, self::has_conditional_logic($form) ? GFFormDisplay::ON_CONDITIONAL_LOGIC : GFFormDisplay::ON_PAGE_RENDER, $script);
        
    }
    
    public function validate($validation_result) {
        
        $form = $validation_result['form'];
        $is_valid = true;
        
        foreach($form['fields'] as &$field) {
            
            if( ! $this->should_field_be_validated( $form, $field ) )
                continue;
            
            $value = RGFormsModel::get_field_value($field);
            $words = preg_split( '/\s+/', trim( $value ) );
            $word_count = count($words);
            
            $min_word_count = intval($this->field_prop($field, 'min_word_count'));
            if($min_word_count && $word_count < $min_word_count) {
                $field['failed_validation'] = true;
                $field['validation_message'] = apply_filters( $this->key('_min_word_count_validation_message'), sprintf( _n('You must enter at least %s word.', 'You must enter at least %s words.', $min_word_count, 'gravityperks'), $min_word_count) );
            }
            
            $max_word_count = intval($this->field_prop($field, 'max_word_count'));
            if($max_word_count !== 0 && $min_word_count && $word_count > $max_word_count) {
                $field['failed_validation'] = true;
                $field['validation_message'] = apply_filters( $this->key('_max_word_count_validation_message'), sprintf( _n('You may only enter %s word.', 'You may only enter %s words.', $max_word_count, 'gravityperks'), $max_word_count) );
            }
            
            if($field['failed_validation'])
                $is_valid = false;
                
        }
        
        $validation_result['form'] = $form;
        $validation_result['is_valid'] = ! $validation_result['is_valid'] ? false : $is_valid;
        
        return $validation_result;
    }

    public function should_field_be_validated( $form, $field ) {

        if( $field['pageNumber'] != GFFormDisplay::get_source_page( $form['id'] ) ) {
	        return false;
        }

        if( ! in_array( GFFormsModel::get_input_type( $field ), self::$supported_field_types ) ) {
	        return false;
        }

	    if( GFFormsModel::is_field_hidden( $form, $field, array() ) ) {
			return false;
	    }

        return true;
    }

    public static function has_conditional_logic($form){
        if(empty($form))
            return false;

        if(isset($form["button"]["conditionalLogic"]))
            return true;

        foreach(rgar($form,"fields") as $field){
            if(!empty($field["conditionalLogic"])){
                return true;
            }
            else if(isset($field["nextButton"]) && !empty($field["nextButton"]["conditionalLogic"])){
                return true;
            }
        }
        return false;
    }

    public function documentation() {
        return array(
            'type' => 'url',
            'value' => 'http://gravitywiz.com/documentation/gp-word-count/'
        );
    }
    
}