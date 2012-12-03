<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">
 <h1>Signup</h1><br />
<div id="signup">
<form method="post" action="index.php">
	<input type="hidden" name="c" value="signup_step_2" />
	  <div class="formrow"><span class="formkey">First Name:</span><span class="formvalue">
              <input type="text" name="first_name" value="{/page/request/first_name}" />
            </span>
          </div>
          <div class="formrow"><span class="formkey">Last Name:</span><span class="formvalue">
              <input type="text" name="last_name" value="{/page/request/last_name}" />
            </span>
          </div>
	<div class="formrow"><span class="formkey">Email Address:</span><span class="formvalue">
              <input type="text" name="email" value="{/page/request/email}" />
            </span>
          </div>
	<div class="formrow"><span class="formkey">Username:</span><span class="formvalue">
              <input type="text" name="username" value="{/page/request/username}" />
            </span>
          </div>
          <div class="formrow"><span class="formkey">Password:</span><span class="formvalue">
              <input type="password" name="password" />
            </span>
          </div>
	  <div class="formrow"><span class="formkey">Repeat Password:</span><span class="formvalue">
              <input type="password" name="password2" />
            </span>
          </div><br /><br />
          <input type="submit" value="Create Account" />
	
</form>
</div>
</xsl:template>

</xsl:stylesheet>
