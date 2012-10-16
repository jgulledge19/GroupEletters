<?php
/**
 * Default English Lexicon Entries for GroupELetters
 *
 * @package GroupELetters
 * @subpackage lexicon
 */

//general
$_lang['groupeletters'] = 'GroupELetters';
$_lang['groupeletters.desc'] = 'Newsletter manager for MODX';
$_lang['groupeletters.menu'] = 'Menu';
$_lang['groupeletters.search...'] = 'Search...';

//newsletters
$_lang['groupeletters.newsletters'] = 'Newsletters';
$_lang['groupeletters.newsletters.subject'] = 'Subject';
$_lang['groupeletters.newsletters.date'] = 'Date';
$_lang['groupeletters.newsletters.document'] = 'Document';
$_lang['groupeletters.newsletters.sent'] = 'Sent';
$_lang['groupeletters.newsletters.delivered'] = 'Delivered';
$_lang['groupeletters.newsletters.bounced'] = 'Bounced';
$_lang['groupeletters.newsletters.opened'] = 'Opened/Read';
$_lang['groupeletters.newsletters.clicks'] = 'Clicks';

$_lang['groupeletters.newsletters.new'] = 'New newsletter';
$_lang['groupeletters.newsletters.groups'] = 'Groups';
$_lang['groupeletters.newsletters.remove'] = 'Remove newsletter';
$_lang['groupeletters.newsletters.remove.title'] = 'Remove newsletter?';
$_lang['groupeletters.newsletters.remove.confirm'] = 'Are you sure you want to remove this newsletter and all it\'s data?';
$_lang['groupeletters.newsletters.saved'] = 'Newsletter saved (scheduled)';
$_lang['groupeletters.newsletters.err.save'] = 'Could not save/schedule newsletter';
$_lang['groupeletters.newsletters.err.nf'] = 'Could not open/find document';
$_lang['groupeletters.newsletters.err.remove'] = 'Could not remove newsletter';
// Queue
$_lang['groupeletters.queue.ran'] = 'Newsletters Queue ran successfully';
$_lang['groupeletters.queue.ran.err'] = 'Newsletters Queue could not send emails';

//groups
$_lang['groupeletters.groups'] = 'Groups';
$_lang['groupeletters.groups.name'] = 'Name';
$_lang['groupeletters.groups.public'] = 'Public';
$_lang['groupeletters.groups.public.desc'] = 'Public (allow subscription through form)';
$_lang['groupeletters.groups.active'] = 'Active';
$_lang['groupeletters.groups.description'] = 'Description';
$_lang['groupeletters.groups.department'] = 'Department';
$_lang['groupeletters.groups.allow_signup'] = 'Allow Signup';

$_lang['groupeletters.groups.members'] = 'Members';
$_lang['groupeletters.groups.new'] = 'New group';
$_lang['groupeletters.groups.edit'] = 'Edit group';
$_lang['groupeletters.groups.remove'] = 'Remove group';
$_lang['groupeletters.groups.remove.title'] = 'Remove group?';
$_lang['groupeletters.groups.remove.confirm'] = 'Are you sure you want to remove this group? Subscribers won\'t be deleted';
$_lang['groupeletters.groups.update'] = 'Update group';
$_lang['groupeletters.groups.saved'] = 'Group saved';
$_lang['groupeletters.groups.err.nf'] = 'Group not found';
$_lang['groupeletters.groups.err.save'] = 'Could not save group';

//subscribers
$_lang['groupeletters.subscribers.basic_info'] = 'Basic';
$_lang['groupeletters.subscribers.groups_info'] = 'Groups';
$_lang['groupeletters.subscribers.address_info'] = 'Phone &amp; Address';
$_lang['groupeletters.subscribers'] = 'Subscribers';
$_lang['groupeletters.subscribers.first_name'] = 'First name';
$_lang['groupeletters.subscribers.m_name'] = 'Middle name';
$_lang['groupeletters.subscribers.last_name'] = 'Last name';
$_lang['groupeletters.subscribers.company'] = 'Company';
$_lang['groupeletters.subscribers.email'] = 'Email';
$_lang['groupeletters.subscribers.crm_id'] = 'CRM ID';
$_lang['groupeletters.subscribers.address'] = 'Street Address';
$_lang['groupeletters.subscribers.city'] = 'City';
$_lang['groupeletters.subscribers.state'] = 'State';
$_lang['groupeletters.subscribers.zip'] = 'Zip';
$_lang['groupeletters.subscribers.country'] = 'Country';
$_lang['groupeletters.subscribers.phone'] = 'Phone';
$_lang['groupeletters.subscribers.cell'] = 'Cell Phone';
$_lang['groupeletters.subscribers.active'] = 'Active';
$_lang['groupeletters.subscribers.date_created'] = 'Date Created';
$_lang['groupeletters.subscribers.code'] = 'Generated Code';


$_lang['groupeletters.subscribers.signupdate'] = 'Signup date';
$_lang['groupeletters.subscribers.new'] = 'New subscriber';
$_lang['groupeletters.subscribers.exportcsv'] = 'Export CSV';
$_lang['groupeletters.subscribers.importcsv'] = 'Import CSV';
$_lang['groupeletters.subscribers.importcsv.start'] = 'Start import';
$_lang['groupeletters.subscribers.importcsv.file'] = 'File';
$_lang['groupeletters.subscribers.importcsv.results'] = 'Results';
$_lang['groupeletters.subscribers.importcsv.err.uploadfile'] = 'Please, upload a file';
$_lang['groupeletters.subscribers.importcsv.err.cantopenfile'] = 'Can\'t open file';
$_lang['groupeletters.subscribers.importcsv.err.firstrow'] = 'First row must contain column names (first column must be email)';
$_lang['groupeletters.subscribers.importcsv.err.cantsaverow'] = 'Can\'t save row [[+rownum]]';
$_lang['groupeletters.subscribers.importcsv.err.skippedrow'] = 'Skipped row [[+rownum]]';
$_lang['groupeletters.subscribers.importcsv.msg.complete'] = 'Import complete. Imported [[+importCount]] records ([[+newCount]] new)';
$_lang['groupeletters.subscribers.confirm.subject'] = 'Confirm your newsletter subscription';
$_lang['groupeletters.subscribers.confirm.success'] = 'You are now subscribed to our newsletter.';
$_lang['groupeletters.subscribers.confirm.err'] = 'Subscriber / code combination incorrect.';
$_lang['groupeletters.subscribers.signup.err.emailunique'] = 'Email address already in use';
$_lang['groupeletters.subscribers.unsubscribe.success'] = 'You have been removed from our mailing list.';
$_lang['groupeletters.subscribers.unsubscribe.err'] = 'Subscriber not found.';
$_lang['groupeletters.subscribers.active'] = 'Active';
$_lang['groupeletters.subscribers.groups'] = 'Groups';
$_lang['groupeletters.subscribers.remove'] = 'Remove subscriber';
$_lang['groupeletters.subscribers.remove.title'] = 'Remove subscriber?';
$_lang['groupeletters.subscribers.remove.confirm'] = 'Are you sure you want to remove this subscriber?';
$_lang['groupeletters.subscribers.update'] = 'Update subscriber';
$_lang['groupeletters.subscribers.saved'] = 'Subscriber saved';
$_lang['groupeletters.subscribers.err.save'] = 'Error while saving subscriber';
$_lang['groupeletters.subscribers.err.ae'] = 'A subscriber with the same email address already exists';


//system settings
$_lang['setting_groupeletters.batchSize'] = 'Batch Size';
$_lang['setting_groupeletters.batchSize_desc'] = 'The number of emails send out per batch.  Default is 20.';
$_lang['setting_groupeletters.delay'] = 'Delay';
$_lang['setting_groupeletters.delay_desc'] = 'The delay in seconds between emails sent out in a batch.  Default is 10.';
$_lang['setting_groupeletters.debug'] = 'Debug';
$_lang['setting_groupeletters.debug_desc'] = 'If set to yes, then the error log will have debug messages to check for errors.';
$_lang['setting_groupeletters.confirmPageID'] = 'Confirmation page';
$_lang['setting_groupeletters.confirmPageID_desc'] = 'The ID of the Resource that is the Confirmation page';
$_lang['setting_groupeletters.manageSubscriptionsPageID'] = 'Manage Subscriptions page';
$_lang['setting_groupeletters.manageSubscriptionsPageID_desc'] = 'The ID of the Resource that is the manage subscriptions page';
$_lang['setting_groupeletters.unsubscribePageID'] = 'Unsubscribe page';
$_lang['setting_groupeletters.unsubscribePageID_desc'] = 'The ID of the Resource that is the Unsubsribe page';
$_lang['setting_groupeletters.trackingPageID'] = 'Tracking Page';
$_lang['setting_groupeletters.trackingPageID_desc'] = 'The ID of the Resource that is the Tracking Redirect page';
$_lang['setting_groupeletters.useUrlTracking'] = 'URL Tracking';
$_lang['setting_groupeletters.useUrlTracking_desc'] = 'Set to true to use URL click tracking';

// replyEmail, fromEmail, fromName
$_lang['setting_groupeletters.replyEmail'] = 'Reply Email Address';
$_lang['setting_groupeletters.replyEmail_desc'] = 'The default reply email address';
$_lang['setting_groupeletters.fromEmail'] = 'From Email Address';
$_lang['setting_groupeletters.fromEmail_desc'] = 'The default from email address';
$_lang['setting_groupeletters.fromName'] = 'From Name';
$_lang['setting_groupeletters.fromName_desc'] = 'The default from name';



/** Settings - remove these..
$_lang['groupeletters.settings'] = 'Settings';
$_lang['groupeletters.settings.name'] = 'Name';
$_lang['groupeletters.settings.email'] = 'Email';
$_lang['groupeletters.settings.bounceemail'] = 'Bounce email address';
$_lang['groupeletters.settings.template'] = 'Template';
$_lang['groupeletters.settings.saved'] = 'Settings saved';
$_lang['groupeletters.settings.error'] = 'Error while saving settings';
*/