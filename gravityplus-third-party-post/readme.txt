=== Gravity Forms Post to Third-Party API ===
Contributors: gravityplus, naomicbush
Donate link: https://gravityplus.pro/gravity-forms-post-to-third-party-api
Tags: form, forms, gravity, gravity form, gravity forms, gravityforms, third-party, api
Requires at least: 4.0
Tested up to: 4.5.2
Stable tag: 1.5.0

Send Gravity Forms form submissions to a third-party API

== Description ==

Send Gravity Forms form submissions to a third-party API

== Installation ==

This section describes how to install and setup the Gravity Forms Post to Third-Party Add-On. Be sure to follow *all* of the instructions in order for the Add-On to work properly. If you're unsure on any step, there are screenshots.

Requires at least WordPress 4.0, PHP 5.3, and Gravity Forms 2.0. Works with WordPress Multisite.

1. Make sure you have your own copy of Gravity Forms. This plugin does not include Gravity Forms. It will work with any of the Gravity Forms licenses.

2. You'll also need to know the parameters and authentication requirements for the external API. For example, MailChimp requires an API key

3. Upload the plugin to your WordPress site. There are two ways to do this:

    * WordPress dashboard upload

        - Download the plugin zip file by clicking the orange download button on this page
        - In your WordPress dashboard, go to the **Plugins** menu and click the _Add New_ button
        - Click the _Upload_ link
        - Click the _Choose File_ button to upload the zip file you just downloaded

    * FTP upload

        - Download the plugin zip file by clicking the orange download button on this page
        - Unzip the file you just downloaded
        - FTP in to your site
        - Upload the `gravityplus-third-party-post` folder to the `/wp-content/plugins/` directory

4. Visit the **Plugins** menu in your WordPress dashboard, find `Gravity Forms Post to Third-Party API` in your plugin list, and click the _Activate_ link

5. Create a form with your desired fields.

6. In the **Form Settings->Send to Third-Party menu**, add a new Send to Third-Party feed for your form

== Frequently Asked Questions ==

= Do I need to have my own copy of Gravity Forms for this plugin to work? =
Yes, you need to install the [Gravity Forms plugin](https://gravityplus.pro/getgravityforms/ "visit the Gravity Forms website") for this plugin to work.

= Does this version work with the latest version of Gravity Forms? =
Yes.

== Screenshots ==

1. Activate Gravity Forms
2. Activate Gravity Forms Send to Third-Party API
3. Form Settings->Send to Third-Party menu
4. Create Send to Third-Party feed
5. Send to Third-Party feed page
6. Successful form submission added to Third-Party API

== Changelog ==

= 1.5.0 =
* Add option to delay processing feed until successful payment, for payment add-ons that require a delay

= 1.4.1 =
* Fix fatal error

= 1.4.0 =
* Add compatibility for Utility plugin's manual feed trigger

= 1.3.0 =
* Fix fatal error when using metadata fields
* Add support for JSON data formatting
* Add support for raw data
* Add access to API response
* Add 'gravityplus_third_party_post_request_body' filter

= 1.2.0 =
* Choose request methods other than just POST
* Add Basic Authentication support
* Add custom header mapping
* Add nested API parameter support, using '/' delimiter
* Allow feeds to be duplicated

= 1.1.0 =
* Use new Add-On Framework dynamic field map field type for feed mapping
* Send GravityPDF-generated PDFs
* Add pot file

= 1.0.0 =
* Initial release.

== Upgrade Notice ==
