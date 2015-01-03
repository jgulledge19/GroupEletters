<!--
* FormIt is required!
* Fields used: firstname, lastname, company, email
* Optional: m_name, company, address, state, zip, country, phone, cell, crm_id
* The 'EletterSignup' hook (snippet) adds the subscriber or returns an error message.
* Optionally redirect to a 'thankyou' page!
* You can also use this in a "normal" contactform.
-->

[[!FormIt? 
  &hooks=`spam,EletterSignup,redirect` 
  &redirectTo=`2073` 
  &validate=`email:required:email,first_name:required,last_name:required` 
  &confirmPage=`2071` 
  &emailSubject=`Newsletter confirmation`
  &emailReplyTo=`[[++eletters.replyEmail]]`
  &emailFromName=`[[++eletters.fromName]]`
  &emailFrom=`[[++eletters.fromEmail]]`
  &emailTpl=`EletterSignupMail`
]]
<form action="[[~[[*id]]]]" method="post">
    
<ul>
    
<!-- 
<p>Company:<br />
<input name="company" type="text" value="[[+fi.company]]" /></p>
-->
    <li>
        <label for="txt_first_name">First name</label> <span class="error">[[!+fi.error.first_name]]</span>
        <input name="first_name" type="text" value="[[+fi.first_name]]" id="txt_first_name" />
    </li>
    <li>
        <label for="txt_last_name">Last name</label> <span class="error">[[!+fi.error.last_name]]</span>
        <input name="last_name" type="text" value="[[+fi.last_name]]" />
    </li>
    
    <li>
        <label for="txt_email">E-mail Address</label> <span class="error">[[!+fi.error.email]]</span>
        <input name="email" type="text" value="[[+fi.email]]" id="txt_email" />
    </li>

    [[EletterFormListGroups?
      
    ]]
    
    <li>
        <input type="submit" value="Subscribe" />
    </li>
</ul>
</form>