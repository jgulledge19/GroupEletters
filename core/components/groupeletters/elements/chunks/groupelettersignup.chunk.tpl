<!--
* FormIt is required!
* Fields used: firstname, lastname, company, email
* The 'ditsnewssignup' hook (snippet) adds the subscriber or returns an error message.
* Redirects to a 'thankyou' page!
* Don't forget to specify the group(s) the subscriber should be added to (see below) and set the confirmPage
* Of course, you can also use this in a "normal" contactform.
-->

[[!FormIt? &hooks=`spam,ditsnewssignup,redirect` &redirectTo=`1` &validate=`email:required:email` &confirmPage=`71` ]]
<form action="/[[~[[*id]]]]" method="post">

<p>Company:<br />
<input name="company" type="text" value="[[+fi.company]]" /></p>

<p>First name:<br />
<input name="firstname" type="text" value="[[+fi.firstname]]" /></p>

<p>Last name:<br />
<input name="lastname" type="text" value="[[+fi.lastname]]" /></p>

<p>Email:<br />
<input name="email" type="text" value="[[+fi.email]]" [[!+fi.error.email:notempty=`class="error"`]] /></p>

<input type="hidden" name="groups[]" value="1" /><!-- First group to add subscriber to. Ignored if not public! -->
<input type="hidden" name="groups[]" value="2" /><!-- Second group to add subscriber to. Ignored if not public! -->

<input type="submit" value="Subscribe" />
</form>