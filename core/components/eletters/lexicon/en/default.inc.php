<?php
/**
 * Default English Lexicon Entries for ELetters
 *
 * @package ELetters
 * @subpackage lexicon
 */

//general
$_lang['eletters'] = 'ELetters';
$_lang['eletters.desc'] = 'Newsletter manager for MODX';
$_lang['eletters.menu'] = 'Menu';
$_lang['eletters.search...'] = 'Search...';

//newsletters
$_lang['eletters.newsletters'] = 'Newsletters';
$_lang['eletters.newsletters.subject'] = 'Subject';
$_lang['eletters.newsletters.date'] = 'Start - Finish Date';
$_lang['eletters.newsletters.document'] = 'Document';
$_lang['eletters.newsletters.sent'] = 'Sent';
$_lang['eletters.newsletters.delivered'] = 'Delivered';
$_lang['eletters.newsletters.bounced'] = 'Bounced';
$_lang['eletters.newsletters.opened'] = 'Opened/Read';
$_lang['eletters.newsletters.clicks'] = 'Clicks';

$_lang['eletters.newsletters.new'] = 'New newsletter';
$_lang['eletters.newsletters.groups'] = 'Groups';
$_lang['eletters.newsletters.remove'] = 'Remove newsletter';
$_lang['eletters.newsletters.remove.title'] = 'Remove newsletter?';
$_lang['eletters.newsletters.remove.confirm'] = 'Are you sure you want to remove this newsletter and all it\'s data?';
$_lang['eletters.newsletters.saved'] = 'Newsletter saved (scheduled)';
$_lang['eletters.newsletters.err.save'] = 'Could not save/schedule newsletter';
$_lang['eletters.newsletters.err.nf'] = 'Could not open/find document';
$_lang['eletters.newsletters.err.remove'] = 'Could not remove newsletter';
// Queue
$_lang['eletters.queue.ran'] = 'Newsletters Queue ran successfully';
$_lang['eletters.queue.ran.err'] = 'Newsletters Queue could not send emails';

//groups
$_lang['eletters.groups'] = 'Groups';
$_lang['eletters.groups.name'] = 'Name';
$_lang['eletters.groups.public'] = 'Public';
$_lang['eletters.groups.public.desc'] = 'Public (allow subscription through form)';
$_lang['eletters.groups.active'] = 'Active';
$_lang['eletters.groups.description'] = 'Description';
$_lang['eletters.groups.department'] = 'Department';
$_lang['eletters.groups.allow_signup'] = 'Allow Signup';

$_lang['eletters.groups.members'] = 'Members';
$_lang['eletters.groups.new'] = 'New group';
$_lang['eletters.groups.edit'] = 'Edit group';
$_lang['eletters.groups.remove'] = 'Remove group';
$_lang['eletters.groups.remove.title'] = 'Remove group?';
$_lang['eletters.groups.remove.confirm'] = 'Are you sure you want to remove this group? Subscribers won\'t be deleted';
$_lang['eletters.groups.update'] = 'Update group';
$_lang['eletters.groups.saved'] = 'Group saved';
$_lang['eletters.groups.err.nf'] = 'Group not found';
$_lang['eletters.groups.err.save'] = 'Could not save group';

//subscribers
$_lang['eletters.subscribers.basic_info'] = 'Basic';
$_lang['eletters.subscribers.groups_info'] = 'Groups';
$_lang['eletters.subscribers.address_info'] = 'Phone &amp; Address';
$_lang['eletters.subscribers'] = 'Subscribers';
$_lang['eletters.subscribers.first_name'] = 'First name';
$_lang['eletters.subscribers.m_name'] = 'Middle name';
$_lang['eletters.subscribers.last_name'] = 'Last name';
$_lang['eletters.subscribers.company'] = 'Company';
$_lang['eletters.subscribers.email'] = 'Email';
$_lang['eletters.subscribers.crm_id'] = 'CRM ID';
$_lang['eletters.subscribers.address'] = 'Street Address';
$_lang['eletters.subscribers.city'] = 'City';
$_lang['eletters.subscribers.state'] = 'State';
$_lang['eletters.subscribers.zip'] = 'Zip';
$_lang['eletters.subscribers.country'] = 'Country';
$_lang['eletters.subscribers.phone'] = 'Phone';
$_lang['eletters.subscribers.cell'] = 'Cell Phone';
$_lang['eletters.subscribers.active'] = 'Active';
$_lang['eletters.subscribers.date_created'] = 'Date Created';
$_lang['eletters.subscribers.code'] = 'Generated Code';


$_lang['eletters.subscribers.signupdate'] = 'Signup date';
$_lang['eletters.subscribers.new'] = 'New subscriber';
$_lang['eletters.subscribers.exportcsv'] = 'Export CSV';
$_lang['eletters.subscribers.importcsv'] = 'Import CSV';
$_lang['eletters.subscribers.importcsv.example'] = 'Basic CSV example';
$_lang['eletters.subscribers.importcsv.completeExample'] = 'Complete CSV example';
$_lang['eletters.subscribers.importcsv.start'] = 'Start import';
$_lang['eletters.subscribers.importcsv.file'] = 'File';
$_lang['eletters.subscribers.importcsv.results'] = 'Results';
$_lang['eletters.subscribers.importcsv.err.uploadfile'] = 'Please, upload a file';
$_lang['eletters.subscribers.importcsv.err.cantopenfile'] = 'Can\'t open file';
$_lang['eletters.subscribers.importcsv.err.firstrow'] = 'First row must contain column names (first column must be email)';
$_lang['eletters.subscribers.importcsv.err.cantsaverow'] = 'Can\'t save row [[+rownum]]';
$_lang['eletters.subscribers.importcsv.err.skippedrow'] = 'Skipped row [[+rownum]]';
// Updated in 1.0RC2
$_lang['eletters.subscribers.importcsv.msg.complete'] = 'New imported records: [[+newCount]] <br>Existing untouched records: [[+existCount]] '.
        '<br>Invalid CSV records: [[+invalidCount]] <br>Total records in CSV file: [[+csvCount]]';
// 'Import complete. Imported [[+importCount]] records ([[+newCount]] new)';
$_lang['eletters.subscribers.confirm.subject'] = 'Confirm your newsletter subscription';
$_lang['eletters.subscribers.confirm.success'] = 'You are now subscribed to our newsletter.';
$_lang['eletters.subscribers.confirm.err'] = 'Subscriber / code combination incorrect.';
$_lang['eletters.subscribers.signup.err.emailunique'] = 'Email address already in use';
$_lang['eletters.subscribers.unsubscribe.success'] = 'You have been removed from our mailing list.';
$_lang['eletters.subscribers.unsubscribe.err'] = 'Subscriber not found.';
$_lang['eletters.subscribers.active'] = 'Active';
$_lang['eletters.subscribers.groups'] = 'Groups';
$_lang['eletters.subscribers.remove'] = 'Remove subscriber';
$_lang['eletters.subscribers.remove.title'] = 'Remove subscriber?';
$_lang['eletters.subscribers.remove.confirm'] = 'Are you sure you want to remove this subscriber?';
$_lang['eletters.subscribers.update'] = 'Update subscriber';
$_lang['eletters.subscribers.saved'] = 'Subscriber saved';
$_lang['eletters.subscribers.err.save'] = 'Error while saving subscriber';
$_lang['eletters.subscribers.err.ae'] = 'A subscriber with the same email address already exists';


//system settings
$_lang['setting_eletters.batchSize'] = 'Batch Size';
$_lang['setting_eletters.batchSize_desc'] = 'The number of emails send out per batch.  Default is 20.';
$_lang['setting_eletters.delay'] = 'Delay';
$_lang['setting_eletters.delay_desc'] = 'The delay in seconds between emails sent out in a batch.  Default is 10.';
$_lang['setting_eletters.debug'] = 'Debug';
$_lang['setting_eletters.debug_desc'] = 'If set to yes, then the error log will have debug messages to check for errors.';
$_lang['setting_eletters.confirmPageID'] = 'Confirmation page';
$_lang['setting_eletters.confirmPageID_desc'] = 'The ID of the Resource that is the Confirmation page';
$_lang['setting_eletters.manageSubscriptionsPageID'] = 'Manage Subscriptions page';
$_lang['setting_eletters.manageSubscriptionsPageID_desc'] = 'The ID of the Resource that is the manage subscriptions page';
$_lang['setting_eletters.unsubscribePageID'] = 'Unsubscribe page';
$_lang['setting_eletters.unsubscribePageID_desc'] = 'The ID of the Resource that is the Unsubsribe page';
$_lang['setting_eletters.trackingPageID'] = 'Tracking Page';
$_lang['setting_eletters.trackingPageID_desc'] = 'The ID of the Resource that is the Tracking Redirect page';
$_lang['setting_eletters.deniedPageID'] = 'Denied Page';
$_lang['setting_eletters.deniedPageID_desc'] = 'The ID of the Resource if you set a eletter to private and a user goes to the URL without unique code send them to this page.';
$_lang['setting_eletters.useUrlTracking'] = 'URL Tracking';
$_lang['setting_eletters.useUrlTracking_desc'] = 'Set to true to use URL click tracking';

// replyEmail, fromEmail, fromName
$_lang['setting_eletters.replyEmail'] = 'Reply Email Address';
$_lang['setting_eletters.replyEmail_desc'] = 'The default reply email address';
$_lang['setting_eletters.fromEmail'] = 'From Email Address';
$_lang['setting_eletters.fromEmail_desc'] = 'The default from email address';
$_lang['setting_eletters.fromName'] = 'From Name';
$_lang['setting_eletters.fromName_desc'] = 'The default from name';
$_lang['setting_eletters.testPrefix'] = 'Test Email Subject Prefix';
$_lang['setting_eletters.testPrefix_desc'] = 'Set a value to prefix all test email subject lines.';



/** Settings - remove these..
$_lang['eletters.settings'] = 'Settings';
$_lang['eletters.settings.name'] = 'Name';
$_lang['eletters.settings.email'] = 'Email';
$_lang['eletters.settings.bounceemail'] = 'Bounce email address';
$_lang['eletters.settings.template'] = 'Template';
$_lang['eletters.settings.saved'] = 'Settings saved';
$_lang['eletters.settings.error'] = 'Error while saving settings';
*/