var GFPGFU_AdminMenuBar;

/**
 * Extend the String prototype to add a format function
 */
if ( ! String.prototype.format ) {

	String.prototype.format = function () {

		var args = arguments;

		return this.replace( /{(\d+)}/g, function ( match, number ) {

			return typeof args[number] != 'undefined' ? args[number] : match;

		} );

	};

}

(function ( $ ) {

	GFPGFU_AdminMenuBar = {
		// Used to init the form adapter
		init: false,

		// The target selector where to attach the menu
		target: '#wp-admin-bar-root-default',

		// counter to iterate through each form in case the form titles fail
		counter: 0,

		// The Gravity Forms schema
		schema: false,

		// The current form
		form: false,

		/**
		 * Creates a menu for a form
		 * @param {object} form Form object containing form_id and schema, and optionally title
		 */
		add_menu: function ( form ) {

			if ( ! this.schema ) {

				this.schema = JSON.parse( gfpgfu_adminmenubar_vars.schema );

			}

			this.form = form;
			this.counter++;
			this.build_form_menu();

		}, // add_menu

		/**
		 * Build the form menu based on the schema
		 * @return {void}
		 */
		build_form_menu: function () {

			var $parent = this.create_top_menu(),
				context = 'gfpgfu-adminmenubar-' + this.form.schema + '-form-' + this.form.form_id,
				edit_url = this.get_edit_url(),
				title = this.get_title( context );

			if ( Object.keys( this.schema ).length > 1 ) {

				var $submenu = this.create_sub_menu( context, edit_url, title );

				$parent.append( $submenu );

				for ( var property in this.schema ) {

					var url = ( this.schema[property].url.indexOf( '{0}' ) <= -1 ) ? this.schema[property].url : this.schema[property].url.format( this.form.form_id ),
						item_title = this.schema[property].label;

					$submenu.find( 'ul' ).append( this.create_menu_item( context + property, url, item_title ) );

				}

			} else {

				$parent.append( this.create_menu_item( context, edit_url, title ) );

			}

		}, // build_form_menu

		/**
		 * Get the Title of the form
		 * @param  {string} context Identifier to add IDs to menu elements
		 * @return {void}
		 */
		get_title: function ( context ) {

			if ( this.form.title ) {

				return this.form.title;

			}

			$.ajax( {
						url: gfpgfu_adminmenubar_vars.ajax_url,
						data: {action: 'gfpgfu_adminmenubar_get_title', form_id: this.form.form_id},
						type: 'get',
						dataType: 'json',
						success: function ( response ) {

							if ( response.form_title ) {

								$( '#wp-admin-bar-' + context ).find( 'a:first' ).text( response.form_title );

							}

						}
					}
			);

			return 'Edit Form ' + this.counter;

		}, // get_title

		/**
		 * Get the URL to edit the form
		 * @return {void}
		 */
		get_edit_url: function () {

			if ( !this.schema.edit || !this.schema.edit.url ) {

				return '#';

			}

			if ( this.schema.edit.url.indexOf( '{0}' ) <= -1 ) {

				return this.schema.edit.url;

			}

			return this.schema.edit.url.format( this.form.form_id );

		}, // get_edit_url

		/**
		 * Setup the main Edit Forms menu to hold submenu items
		 * @return {jQuery Object}        jQuery parent menu object
		 */
		create_top_menu: function () {

			var context = 'gfpgfu-adminmenubar',
				$top = $( '#wp-admin-bar-' + context + '-default' );

			if ( $top.length ) {

				return $top;

			}

			$( this.target ).append( this.create_sub_menu( context, '#', 'Edit Forms' ) );

			// return the new object, not the original
			return $( '#wp-admin-bar-' + context + '-default' );

		}, // create_top_menu

		/**
		 * Creates a new submenu object, used to append to the main parent menu
		 * @param  {string} context Unique identifier
		 * @param  {string} url     URL of the menu item
		 * @param  {string} label   Lable for the menu item
		 * @return {jQuery Object}  jQuery submenu object
		 */
		create_sub_menu: function ( context, url, label ) {

			var $li = $( '<li id="wp-admin-bar-' + context + '" class="menupop" />' ),
				$a = $( '<a class="ab-item" aria-haspopup="true" href="' + url + '" />' ).html( label ),
				$div = $( '<div class="ab-sub-wrapper" />' ),
				$ul = $( '<ul id="wp-admin-bar-' + context + '-default" class="ab-submenu" />' );

			$div.append( $ul );
			$li.append( $a );
			$li.append( $div );

			return $li;

		}, // create_sub_menu

		/**
		 * Creates an individual menu item
		 * @param  {string} context Unique Identifier
		 * @param  {string} url     URL for the menu item
		 * @param  {string} label   Label for the menu item
		 * @return {jQuery Object}  jQuery object of the menu item
		 */
		create_menu_item: function ( context, url, label ) {

			var $li = $( '<li id="wp-admin-bar-' + context + '" />' ),
				$a = $( '<a class="ab-item" href="' + url + '" />' ).text( label );

			$li.append( $a );

			return $li;

		}

	};

	if ( ! GFPGFU_AdminMenuBar.init ) {

		GFPGFU_AdminMenuBar.init = function () {

			$( document ).bind( 'gform_post_render', function ( e, form_id ) {

				GFPGFU_AdminMenuBar.add_menu( {form_id: form_id} );

			} );

		};

		GFPGFU_AdminMenuBar.init();

	}

})( jQuery );
