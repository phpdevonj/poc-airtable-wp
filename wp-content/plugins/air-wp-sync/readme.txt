=== Air WP Sync - Airtable to WordPress ===
Author: WP connect
Author URI: https://wpconnect.co/
Contributors: wpconnectco, thomascharbit
Tags: wpconnect, airtable, wordpress, api
Requires at least: 5.7
Tested up to: 6.4
Requires PHP: 7.0
Stable tag: 2.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Swiftly sync Airtable to your WordPress website!

== Description ==

By connecting your Airtable database platform to your WordPress website, this plugin helps you manage your content better. Identify the Airtable fields you wish to link to WordPress and choose the format for your imported contents: articles, pages, products, etc. Simply define your ideal update frequency. Your plugin will automatically sync everything swiftly!
Upgrade to Pro Version ([here](https://wpconnect.co/air-wp-sync-plugin/)) to unleash advanced features.

== Features ==

= Create connections to your Airtable tables =
* Set up as many connections as you want
* Publish an unlimited number of connections (Pro Version)

= Choose the content format you want to import =
* Import your contents in your preferred format: articles, pages, etc.
* Link Airtable columns to WordPress fields

= Sync your personalized data =
* Create new custom fields (Pro Version)
* Use specific content formats "Custom Post Types" (Pro Version)

= Define synchronization setups =
* Sync your data manually or automatically
* Select update frequency (Pro Version)
* Set up synchronization method (add, update, delete)


== Installation ==

1. From your WordPress Dashboard, go to "Plugins > Add New".

2. Look for our plugin into the search bar: Air WP Sync.

3. Click on the 'Install Now' button of the plugin, and wait a few seconds.

4. Click on the "Activate" button (also available in "Plugins > Installed Plugins").

5. That's it, Air WP Sync is ready to use, find it in the sidebar!


== How to unleash your plugin's full potential? ==

1. Go to the Air WP Sync plugin page, click on “Add New” next to “Connections”.

2. Enter a name for your new connection.

3. Fill in the Airtable Settings (Airtable Access token available [here](https://airtable.com/account)).

4. Select the form in which you want to import your content from your table (article, page, etc.) and set up the additional settings.

5. Link your table fields with WordPress fields.

6. Choose the Sync Settings (Strategy and Trigger).

7. Publish the connection, and you’re done!

8. Tip: By pressing the "Sync Now" button, you can synchronize your contents for the first time (even if you didn’t choose “Manual only” trigger).


== Frequently Asked Questions ==

= What is Airtable? =
Offered in SaaS mode, Airtable is a database tool designed to create a simple online form and a project management environment or even a custom CRM. Equipped with an automatic translation function, Airtable manages multiple views: maps, calendars, Kanban boards, Gantt charts, etc.

= Why do I need an Airtable account? =
Air WP Sync plugin uses the Airtable Access token to link columns with fields and send data. Creating an account on Airtable is free. Once connected, you can get the Airtable Access token [here](https://airtable.com/account)).

= Do I have to pay to use the plugin and Airtable? =
We offer three versions of our plugin:
- Free Version: This version is available to all users at no cost [Learn more and get the Free Version here](https://wordpress.org/plugins/air-wp-sync/).
- Pro Version: This is a paid version that offers enhanced features and capabilities. [Learn more and get the Pro Version here](https://wpconnect.co/air-wp-sync-plugin/#pricing-plan).
- Pro+ Version: An even more advanced paid version with extended functionalities, designed for those who need the most from our plugin. [Learn more and get the Pro+ Version here](https://wpconnect.co/air-wp-sync-plugin/#pricing-plan).
Airtable offers a free plan for an unlimited number of databases and small teams of up to 5 people. You will be able to add up to 1000 entries in each database and store up to 1 GB of attachments, but you will be limited to 1,000 API calls per workspace/per month.
Depending on your needs, several paid subscriptions allow you to unlock these limitations while accessing more advanced features ([see prices](https://www.airtable.com/pricing)).

= How are my databases synchronized? =
Once you have defined the synchronization frequency and published your connection, relax: everything is automatic. It is also possible to manually synchronize the connection - whenever you want - using the 'Sync Now' button.

= How can I get support? =
If you need some assistance, open a ticket on the [Support](https://wordpress.org/support/plugin/air-wp-sync/).


== Screenshots ==
1. All Connections
2. Airtable and Import Settings
3. Field Mapping
4. Sync Settings


== Changelog ==

= 2.1.0 =
- Added: Mapping for post_parent

= 2.0.0 =
- Feature: Import airtable content as users
- Feature: Added Post Status and Post Author options when importing posts
- Added: Support for "Link to another record" field type
- Fix: formula field was missing from the mapping
- Fix: Added cache for table data

= 1.4.0 =
- Improve: mapping fields sorting

= 1.3.0 =
- Feature: Add Action Scheduler to handle large imports
- Improvement: show sync progress and keep state when reloading
- Improvement: add cancel sync button
- Improvement: remove use of getmypid() function
- Fix: mapping fields sorting fixed in Firefox
- Fix: Filter image urls from record hashes to avoid unnecessary updates

= 1.2.0 =
- Feature: add Meta API support for better field mapping and field type autodetection
- Feature: Refreshed UI
- Fix: Markdown to HTML conversion

= 1.1.1 =
- Release of the pro version

= 1.1.0 =
- Feature: handle pro version activation

= 1.0.1 =
- Fix: tooltips not displaying
- Fix: PHP error when Parsedown class already loaded
- Improvement: add custom notices when saving, updating connections

= 1.0.0 =
Initial release


= Support ==
If you need some assistance, open a ticket on the [Support](https://wordpress.org/support/plugin/air-wp-sync/).



== Troubleshooting ==
Make sure you have created your databases and Airtable columns names before adding a new connection. If you don't see it, wait 15 minutes. For performance reasons, your Airtable elements are cached for 15 minutes.
If needed, you can access to logs from a FTP server in this folder: /wp-content/uploads/airwpsync-logs
