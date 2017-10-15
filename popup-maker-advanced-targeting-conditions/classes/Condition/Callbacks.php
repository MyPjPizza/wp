<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_ATC_Condition_Callbacks
 */
class PUM_ATC_Condition_Callbacks {

	/**
	 * Checks if a user has one of the selected roles.
	 *
	 * @param array $settings
	 *
	 * @return bool
	 */
	public static function user_has_role( $settings = array() ) {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		if ( ! empty( $settings['roles'] ) ) {
			$user_roles = PUM_ATC_Conditions::allowed_user_roles();
			$check      = false;
			foreach ( $user_roles as $role ) {
				if ( in_array( $role, $settings['roles'] ) ) {
					$check = true;
				}
			}

			return $check;
		}

		return true;
	}

	/**
	 * Checks if user has commented.
	 *
	 * Accepts morethan & lessthan arguments as well.
	 *
	 * @param array $settings
	 *
	 * @return bool
	 */
	public static function user_has_commented( $settings = array() ) {
		if ( ! is_user_logged_in() ) {
			return false;
		}

		$user_ID = get_current_user_id();
		$args    = array(
			'user_id' => $user_ID, // use user_id
			'count'   => true //return only the count
		);

		$comments = get_comments( $args );

		if ( $settings['morethan'] && ! $settings['lessthan'] ) {
			return $comments > $settings['morethan'];
		}

		if ( $settings['lessthan'] && ! $settings['morethan'] ) {
			return $settings['lessthan'] > $comments;
		}

		if ( $settings['lessthan'] && $settings['morethan'] ) {
			return $settings['lessthan'] > $comments && $comments > $settings['morethan'];
		}

		return $comments > 0;
	}

	/**
	 * Calls a custom function by name and returns a boolean representation.
	 *
	 * @param array $settings
	 *
	 * @return bool
	 */
	public static function php_function( $settings = array() ) {
		if ( ! empty( $options['function_name'] ) && is_callable( $options['function_name'] ) ) {
			return (bool) call_user_func( $options['function_name'] );
		}

		return false;
	}

}
