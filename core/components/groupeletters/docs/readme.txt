-------------------
Component: GroupEletters
-------------------
Version: 1.0 alpha
Date: April, 27th, 2012
Author: Joshua Gulledge (jgulledge19@hotmail.com) some code is basied on the Ditsnews Extra
License: GNU GPLv2 (or later at your option)

create TVs - 
    eletterFromEmail
    eletterFromName
    eletterReplyEmail
    eletterSubject
    eletterSendTest
    eletterMakeELetter
    eletterTestTo
    eletterToGroups
    eletterAllowComments
    
==========================================
 Installation
==========================================
* Install through Package Management
* Add the  CronManager 
* Create the newsletter template (just a normal template; CSS must be in the template itself with full URL paths to images. No external CSS!)
* Create a signup page example: GroupEletterSignup chunk
* Create a "Thank you" page (and set it as 'redirectTo' in your signup page FormIt snippet call)
* Create a confirm / opt-in page (add GroupEletterConfirm snippet) and set it's id in the signup page FormIt snippet call
* Create a unsubscribe page (add GroupEletterUnsubscribe snippet) and add a link to this page in your newsletter template [[+unsubscribeUrl]]
* Go to Components -> GroupEletters and add some groups and if you want some subscribers
* Go to System->System Setting and select GroupEletters and change the settings to match what you want.

==========================================
 How to send your first newsletter 
==========================================
* Create a Resource/Document and select the GroupEletterSample template.  Click on the Template Variables tab and fill out the information
* Send a Test - this is a requried step and if you make a change in the content area you will need to send another test.
* If you have CronManager set up then it will send out on the Publish Date or if it is published the next time it runs.
    If you don't have CronManager Set up put  [[!GroupEletterQueue?]] in a page and load the page.  
    Note you will make the page load might take several minutes this way! 
    
* Test the newsletter in many differtent email clients (Apple Mail, Outlook, Gmail, etc.)
* For every webmail client: check the newsletter in different browsers!

==========================================
 Available placeholders
==========================================
[[+first_name]]
[[+last_name]]
[[+fullname]]
[[+company]]
[[+email]]
[[+phone]]
[[+cell]]

