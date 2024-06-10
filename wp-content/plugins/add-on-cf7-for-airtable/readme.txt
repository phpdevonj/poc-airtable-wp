=== CF7 to Airtable ===
Author: WP connect
Author URI: https://wpconnect.co/
Contributors: wpconnectco, staurand
Tags: wpconnect, airtable, contactform7, api, forms, nocode, no-code
Requires at least: 5.7
Tested up to: 6.4.0
Requires PHP: 7.0
Stable tag: 2.1.0
License: GPLv2 or later

Connect the WordPress plugin Contact Form 7 to Airtable. This reliable add-on enables you to integrate your Contact Form 7 forms so that when users submit a form entry, the entries get directly added to Airtable. You can link any field type, including custom fields and add information to your Airtable table. Once the form is validated, the information entered will be added to the columns you have selected.


== Features ==

= Set up the connection with Airtable =
* Enter your Airtable Access Token (only once)
* A new Airtable tab shows up in your form settings

= Choose the destination where you want to send data =
* The database and table linked to your Access Token are instantly detected

= Map your Contact Form 7 fields with Airtable =
* All major field types are supported
* Select the corresponding database field for each form field

= User-friendly and helpful plugin interface =
* Smart warnings to avoid mapping errors
* Many tooltips to make things easier

[youtube https://www.youtube.com/watch?v=bLAzA5LqXX8]

== Installation ==

1. Upload plugin files to your plugins folder

2. Activate the plugin on your WordPress Back Office (Extensions)

3. Go to the Contact Form 7 settings page (under Contact > Integration > Airtable)

4. Enter the Airtable Access Token (personal key [here](https://airtable.com/create/tokens))

5. Click Save Settings

6. Create your form then go to the tab Airtable

7. Follow on-screen instructions for integrating with Airtable.


== How does it work? How to use it? ==

1. Create a form with at least an e-mail field (don’t forget the consent field)

2. Go to Airtable tab and select your database and table

3. Save your settings

4. Map the fields of your Contact Form 7 form with your Airtable's columns

5. Click on “Save settings”


== Frequently Asked Questions ==

= What is Airtable? =
Offered in SaaS mode, Airtable is a database tool that can be used to create a simple online form as well as a project management environment or even a custom CRM. Equipped with an automatic translation function, the tool manages multiple views: maps, calendars, Kanban boards, Gantt charts, etc.

= Why do I need a Airtable account? =
The Contact Form 7 Airtable add-on uses the Airtable Access Token to link columns with fields and send data. Creating an account on Airtable is free. Once connected, you can get the Access Token key [on this page](https://airtable.com/create/tokens).

= Do I have to pay to use the add-on and send emails? =
The Contact Form 7 Airtable add-on is completly free.
Airtable offers a free plan for an unlimited number of databases and for small teams of up to 5 people. You will be able to add up to 1000 entries in each database and store up to 1 GB of attachments, but you will be limited to 1,000 API calls per workspace/per month.
Depending on your needs, several paid subscriptions allow you to unlock these limitations while giving access to more advanced features ([see prices](https://www.airtable.com/pricing)).

= Why I don\'t see the Airtable configuration tab? =
Before starting the mapping with your database please make sure you have setted up your integration. To do this, go directly to the Integration tab of Contact Form 7 and enter a valid Airtable Access token.

= How are my columns and fields synchronized? =
You don\'t have to do anything, the synchronization is automatic. Make sure you have created your databases and Airtable columns names before linking them to your form fields.

= Which CF7 versions is it compatible with? =
This add-on requires at least version 5.5.3 of Contact Form 7 and has recently been tested successfully up to version 5.7.5.

= How can I get support? =
If you need some assistance, open a ticket on the [Support](https://wordpress.org/support/plugin/add-on-cf7-for-airtable/).


== Screenshots ==
1. Setting up the Airtable Integration
2. Configuration of Contact Form 7 and Airtable table
3. Map the fields of Contact Form 7 form with Airtable\'s columns


== Changelog ==

= 2.1.0 =
* WordPress 6.4.0 compatibility
* Added : Sending an email to the administrator upon an API error

= 2.0.0 =
* WordPress 6.3.1 compatibility
* Changed: Use Airtable access tokens instead of API key
* Fixed : Error when using the checkbox field type

= 1.1.2 =
* WordPress 6.2 compatibility

= 1.1.1 =
* Added: Tab color

= 1.1.0 =
* Added: 
  * Selection of the Airtable field’s type
  * New tags
* Changed: 
  * Links in the interface

= 1.0.2 =
* Added:
  * Activation switch
  * New tooltip (API key)
  * Setup page shortcut in plugin list
  * Admin notices
  * WP connect branding
* Changed:
  * Help links
  * Tooltips style
  * Warning messages color
  * Plugin name

= 1.0.1 =
* Added: compatibility with new v5.6 of Contact Form 7
* Changed: Airtable integration help link

= 1.0 =
* Initial release.



== Support ==
If you need support, open a ticket on the [Support](https://wordpress.org/support/plugin/add-on-cf7-for-airtable/).


== Troubleshooting ==
Make sure you have created your database and columns in Airtable before linking them to your form fields.
**Supported Fields : Single line text, Email, URL, Phone number, Number, Date, Multiple select, Checkbox et Attachment**