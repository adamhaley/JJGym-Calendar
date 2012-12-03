<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="content">
 <h1>Login</h1><br />
<div id="login">
	<form method="post" action="index.php?c=login_authenticate">
	<div class="formrow">
		<span class="formkey">username:</span><span class="formvalue"><input type="text" name="username" /></span>
	</div><br />
	<div class="formrow">
		<span class="formkey">password:</span><span class="formvalue"><input type="password" name="password" /></span>
	</div>
	<div class="formrow">
		<span class="formkey">
		<input type="submit" value="Login" /> 
		</span>
	</div>
	</form>
	<br />
	<a href="?c=signup">Need to Create An Account?</a><br /><br />
        <a href="#">Forgot your password?</a> <br />
</div>

	</xsl:template>

	</xsl:stylesheet>
