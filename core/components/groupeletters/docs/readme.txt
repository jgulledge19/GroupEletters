-------------------
Component: GroupEletters
-------------------
Version: 1.0 alpha3
Date: May, 1, 2012
Author: Joshua Gulledge (jgulledge19@hotmail.com) some code is basied on the Ditsnews Extra
License: GNU GPLv2 (or later at your option)

Description:

GroupEletters is a Addon for MODX Revolution that allows you to create & send beautiful 
email campaigns within MODX!  You can now take advantage of MODX advanced templating 
features to create custom eletter templates.  Easily manage lists & subscribers and 
allow subscribers to manage their own preferances.  Personalize your emails with some 
default placeholders.

Features

    Easy group and subscriber management
    Allow users to subscribe through a contact form (FormIt)
    Users must confirm subscription (link in email message)
    User get an unsubscribe link in newsletters ([[+unsubscribeUrl]])
    Select what groups users can subscribe to, one or many.
    Message queue, via the the System Settings chose your batch size and the time in between each email sent
    Basic Statistics - Set the URL Tracking (groupeletters.useUrlTracking) to Yes
        - Messages Sent, Messages Delivered, 
        - Messages Opened. This is the number of recipients who open your email to read it. Due to the way open rates are 
            tracked and the rise of image-blocking software, this number will never be accurate, but can still be useful.
            Use [[+trackingImage]] for an image, you can also put a custom image/banner doing this: [[+trackingImage]]image=test.jpg then put the image in assets/components/groupeletters/images/
            Example useage: <img src="[[+trackingImage]]" alt="" />
        - Click-Throughs. This is the number of times any recipient clicks on any trackable link within the email. 
            Ideally, each link should be counted only once, even if it is clicked on multiple times.


Requirements

    MODX Revolution 2.2+
    FormIt - for subscribe page
    CronManager - for automated queue

Website: http://www.joshua19media.com
Docs: 
==========================================
 Installation
==========================================
First you will need to install through Package Management and then do the following set up steps:
* Create a signup page look at the example in the GroupEletterSignup Chunk
* Optional - Create a "Thank you" page (and set it as 'redirectTo' in your signup page FormIt snippet call)
* Create a confirm / opt-in page just add in the  [[!GroupEletterConfirm]] Snippet and set this pages id in 
    the signup page FormIt snippet call
* Create a unsubscribe page, just add in the [[!GroupEletterUnsubscribe]] Snippet.  Make sure you add a link 
    to this page in your newsletter template [[+unsubscribeUrl]]
* Go to System->System Setting and select GroupEletters and change the settings to match what you want and the 
    pages you just created.
* Go to Components -> GroupEletters and add some groups and if you want add some subscribers
* Install CronManager Now add the GroupEletterQueue to CronManager.  If you are unable to set up CronManager 
    you could put the [[!GroupEletterQueue]] Snippet in a document and call it manual, but that page will take 
    a couple of minutes to load!  

==========================================
 How to send your first newsletter 
==========================================
* Create a Resource/Document and select the GroupEletterSample template.  Click on the Template Variables tab and fill out the information
* Send a Test - this is a requried step and if you make a change in the content area you will need to send another test.
* If you have CronManager set up then it will send out on the Publish Date or if it is published the next time it runs.
    If you don't have CronManager Set up put  [[!GroupEletterQueue?]] in a page and load the page.  
    Note you will make the page load might take several minutes this way! 
* Test the newsletter in many different email clients

==========================================
 Available placeholders
==========================================
[[+trackingImage]]
[[+first_name]]
[[+m_name]]
[[+last_name]]
[[+fullname]]
[[+company]]
[[+address]]
[[+city]]]
[[+state]]
[[+zip]]
[[+country]]
[[+email]]
[[+phone]]
[[+cell]]
[[+crm_id]]
[[+date_created]]

======================
Installation creates the following elements:
====================
Chunks -
    * GroupElettersGroupCheckbox
    * GroupEletterSignup
    * GroupEletterSignupMail
Plugins -
    * GroupEletterCreator
Snippets -
    * GroupEletterConfirm
    * GroupEletterFormListGroups
    * GroupEletterListGroups
    * GroupEletterQueue
    * GroupEletterSignup
    * GroupEletterUnsubscribe
    * GroupEletterUpdateTables - you may need to run this after updating to latest version
    
Templates - 
    * GroupEletterSample
TVs - 
    eletterMakeELetter
    eletterSubject
    eletterFromEmail
    eletterFromName
    eletterReplyEmail
    eletterToGroups
    eletterSendTest
    eletterTestTo