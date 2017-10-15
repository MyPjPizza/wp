=== Popup Maker - Age Verification Modals ===
Contributors: danieliser, wppopupmaker
Author URI: https://wppopupmaker.com/
Plugin URI: https://wppopupmaker.com/extensions/age-verification-modals/
Tags: 
Requires at least: 3.4
Tested up to: 4.5
Stable tag: 1.2.2
Protect content from young eyes and comply with local law by verifying your users age.

== Description ==
Protect content from young eyes and comply with local law by verifying your users age.

== Changelog ==

= v1.2.2 - 4/30/16 =
* Fix: Replaced usage of <% with {{ in JS templates.

= v1.2.1 - 4/30/16 =
* Fix: Incorrect JS selector.

= v1.2 - 4/20/16 =
* Feature: Added new shortcode [pum_age_form], which replaces the older deprecated [age_verification] shortcode.
* Feature: Added shortcode to the Popup Maker (v1.4) shortcode button.
* Feature: Added (v1.4) trigger **Force Age Verification**.
* Feature: Added (v1.4) trigger **Failed Age Redirect** with customizable redirect URL.
* Feature: Added (v1.4) cookie event **Age Verified** when users age is successfully verified.
* Feature: Added (v1.4) cookie event **Age Verification Failed** when user enters an invalid age.
* Feature: Added (v1.4) cookie event **Age Verification Lockout** when user reaches lockout limit.
* Feature: Enable a lockout with a customizable number of tries, redirect users permanantly/temporarily once locked out.
* Feature: Added 4 new selectable layouts for displaying age verification forms: standard, stacked, inline, vertical.
* Feature: Visual placeholder of shortcode in the editor.
* Improvement: Added option to disable labels, as well as customize their text easily.
* Improvement: Added support for the HTML5 date input when browsers support it.
* Improvement: Added optional form alignments: left, right, center.
* Improvement: Migrated code to new PUM boilerplate v2.
* Improvement: Removed Age Verification settings metabox.
* Developer: Added automated build routines to eliminate build time errors making it to releases.
* Developer: Added new replaceable templates `form-age-birthdate.php` & `form-age-enterexit.php`.
* Developer: Included raw SASS files for easy customization.

= v1.1.0 - 7/26/15
* Rewritten to use the PM Boilerplate.
* Added POT file for translations.
* Added better responsive styling for default age verification forms.
* Added in functionality to be able to force age verification before clicking buttons or links such as add-to-cart buttons. Requires Popup Maker v1.3+
* Added option to force age verification on page load.
* When enabling age verification, auto open will be disabled and hidden to prevent conflicts.
* Added new templates:
  * age-verification-birthdate.php
  * age-verification-enterexit.php
* Added age-verification class to Age Verification popups.
* Disable loading of popup if cookie is already detected.
* Added better I10n support in the JS functions.
* Added upgrade routine for versions previous to v1.1.0
* Added cookie key so admins can reset user cookies.
* Fixed bug where : was stripped from exit urls that had https:// in them.
* Added better error handling in the forms when users are not old enough.
* Migrated cookie JS functions to no longer use jQuery cookie, but rather the built in Popup Maker cookie functions.

= v1.0.3 =
* Version bump due to corrupted zip.

= v1.0.2 =
* Updated the_content filters to now use the_popup_content instead to be compliant with Popup Maker v1.1.9

= v1.0.1 =
* Version Change for Launch

= v1.0 =
* Initial Release