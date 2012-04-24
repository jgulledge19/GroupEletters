<!--
* FormIt is required!
* Fields used: firstname, lastname, company, email
* The 'GroupEletterSignup' hook (snippet) adds the subscriber or returns an error message.
* Optionally redirect to a 'thankyou' page!
* You can also use this in a "normal" contactform.
-->

[[!FormIt? 
  &hooks=`spam,GroupEletterSignup,redirect` 
  &redirectTo=`2073` 
  &validate=`email:required:email,first_name:required,last_name:required` 
  &confirmPage=`2071` 
  &emailSubject=`Newsletter confirmation`
]]
<form action="[[~[[*id]]]]" method="post">
    
<ul>
    
<!-- 
<p>Company:<br />
<input name="company" type="text" value="[[+fi.company]]" /></p>
-->
    <li>
        <label for="txt_first_name">First name</label>
        <input name="first_name" type="text" value="[[+fi.first_name]]" id="txt_first_name" />
    </li>
    <li>
        <label for="txt_last_name">Last name</label>
        <input name="last_name" type="text" value="[[+fi.last_name]]" />
    </li>
    
    <li>
        <label for="txt_email">E-mail Address</label> <span class="error">[[!+fi.error.email]]</span>
        <input name="email" type="text" value="[[+fi.email]]" id="txt_email" />
    </li>

    [[GroupEletterFormListGroups?
      
    ]]
    
    <li>
        <input type="submit" value="Subscribe" />
    </li>
</ul>
</form>