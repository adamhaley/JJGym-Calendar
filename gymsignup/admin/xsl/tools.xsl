<?xml version='1.0' encoding='UTF-8' ?> 
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	
<!--VARIABLE TEMPLATES-->
<!--PAGE ACTION MAP
	THIS TEMPLATE RETURNS THE VALUE OF THE ACTION VARIABLE 
	THAT IS USED TO PERSIST THE PAGE ACTION TO THINGS LIKE PAGINATION AND COLUMN SORT.
	SOMETIMES WE WANT THIS TO BE THE SAME, OTHER TIMES WE WANT IT TO MAP TO A NEW ACTION.
	-->
<xsl:template name="pageaction">
	<xsl:choose>
		<xsl:when test="/page/request/c/. = 'delete' or /page/request/c/. = 'login_authenticate' or /page/request/c/. = 'save'">browse</xsl:when>
		<xsl:otherwise><xsl:value-of select="/page/request/c" /></xsl:otherwise>
	</xsl:choose>
</xsl:template>
<!--END VARIABLE TEMPLATES-->

<!--NAVIGATION TEMPLATES-->
<xsl:template match="navgroup">
	<xsl:variable name="id"><xsl:value-of select="@id" /></xsl:variable>      
	<div>
		
		<xsl:attribute name="id">navgroup<xsl:value-of select="$id" /></xsl:attribute>
			<span class="navtext">
			<xsl:apply-templates select="/page/navigation/navgroup[@id=$id]/link">
				<xsl:with-param name="divider"> 
					<xsl:choose>
						<xsl:when test="$id = 1">
							::
						</xsl:when>
						<xsl:otherwise>
							&#9674; 
						</xsl:otherwise>
					</xsl:choose>
				</xsl:with-param>
			</xsl:apply-templates>
			
			<xsl:if test="$id = 1">
				<xsl:if test="/page/session/uid != ''">
					:: <a href="index.php?c=logout">logout</a>
				</xsl:if>
			</xsl:if>
			</span>
	</div>
</xsl:template>

<!--NAV3-->

<xsl:template match="navgroup[@id=3]">
	<xsl:variable name="res"><xsl:value-of select="/page/content/resources/resource[1]/@class" /></xsl:variable>
	<div id="navgroup3">
		<span class="navtext">
				<xsl:for-each select="link">

				<a>
					<xsl:attribute name="href">?<xsl:for-each select="queryparam">
							<xsl:value-of select="name" />=<xsl:value-of select="value" /><xsl:if test="position() &lt; count(../queryparam)">&amp;</xsl:if>
												</xsl:for-each>&amp;res=<xsl:value-of select="$res" /></xsl:attribute>
					<xsl:value-of select="title" />
				</a>
				<xsl:if test="position() &lt; count(../link)">
					<xsl:text>   </xsl:text>&#9674;<xsl:text>   </xsl:text>
				</xsl:if>
				</xsl:for-each>
	
		</span>
	</div>

</xsl:template>
	
<!--END NAV3-->

<!--CONTENT AREA-->
<xsl:template match="content">
	<!--
	<div class="caption">
		<span style="text-transform:capitalize;">
			TVA Talent Database: Browse <xsl:value-of select="/page/request/res" /><xsl:if test="/page/request/res">s</xsl:if>
		</span>
	</div>
	-->

			    <!--SET PAGE VARIABLE-->
        <xsl:variable name="page">
                <xsl:choose>
                        <xsl:when test="/page/request/page">
                        <xsl:value-of select="/page/request/page" />
                        </xsl:when>
                        <xsl:otherwise>
                        1
                        </xsl:otherwise>
                </xsl:choose>
        </xsl:variable>
        <!--END SET PAGE VARIABLE-->

        <!--SET ACTION VARIABLE-->
        <xsl:variable name="action">
                <xsl:call-template name="pageaction" />
        </xsl:variable>
        <!--END SET ACTION VARIABLE-->


        <!--SET NUMBER OF RECORDS TO SHOW PER PAGE-->
        <xsl:variable name="perpage" select="/page/aux/perpage" />
        <!--END SET NUMBER OF RECORDS TO SHOW PER PAGE-->

        <!--SET START AND END POSITIONS -->
        <!--
        <xsl:variable name="pageadjusted"><xsl:value-of select="$page - 1" /></xsl:variable>
        <xsl:variable name="start"><xsl:value-of select="$pageadjusted * $perpage +1" /></xsl:variable>
        <xsl:variable name="end"><xsl:value-of select="($start + $perpage) - 1" /></xsl:variable>
        -->
        <!--END SET START AND END POSITIONS-->
                                <!--PAGER NAVIGATION-->
                        <xsl:if test="/page/aux/totalcount &gt; $perpage and /page/aux/pageresults = '1'">
                                <xsl:call-template name="pagernav">
                                        <xsl:with-param name="perpage" select="$perpage" />
                                        <xsl:with-param name="page" select="$page" />
                                        <xsl:with-param name="nodeset" select="./child::*" />
                                        <xsl:with-param name="total"><xsl:value-of select="/page/aux/totalcount" /></xsl:with-param>
                                        <xsl:with-param name="baseurl">?<xsl:call-template name="querystring">
                                                                                                                <xsl:with-param name="newkey">c</xsl:with-param>
                                                                                                                <xsl:with-param name="newvalue"><xsl:value-of select="$action" /></xsl:with-param>
                                                                                                        </xsl:call-template></xsl:with-param>
                                        <!--<xsl:with-param name="start" select="$start" />
                                        <xsl:with-param name="end" select="$end" />
                                        -->
                                </xsl:call-template>
                        </xsl:if>

			<xsl:apply-templates select="resources" />
			<!--PAGER NAVIGATION-->
                        <xsl:if test="/page/aux/totalcount &gt; $perpage and /page/aux/pageresults = '1'">
                                <xsl:call-template name="pagernav">
                                        <xsl:with-param name="perpage" select="$perpage" />
                                        <xsl:with-param name="page" select="$page" />
                                        <xsl:with-param name="nodeset" select="./child::*" />
                                        <xsl:with-param name="total"><xsl:value-of select="/page/aux/totalcount" /></xsl:with-param>
                                        <xsl:with-param name="baseurl">?<xsl:call-template name="querystring">
                                                                                                                <xsl:with-param name="newkey">c</xsl:with-param>
                                                                                                                <xsl:with-param name="newvalue"><xsl:value-of select="$action" /></xsl:with-param>
                                                                                                        </xsl:call-template></xsl:with-param>
                                </xsl:call-template>
                        </xsl:if>
                        <!--END PAGER NAVIGATION-->

</xsl:template>
<!--END CONTENT AREA-->


<!--BROWSE TABLE TEMPLATE-->
<xsl:template match="resources">
			<!--END PAGER NAVIGATION-->
			<xsl:if test="/page/session/access_level = '1'"> 
				<span>
	                        [<a><xsl:attribute name="href">?c=edit&amp;res=<xsl:value-of select="/page/request/res" /></xsl:attribute>Add</a>]
	                        </span>
				<br />
			</xsl:if>
			<table border="0" cellspacing="1" align="center" class="tborder">
				<!--APPLY THE TABLE HEAD TEMPLATE-->
				<tr>
                                        <!--APPLY TEMPLATE FOR INDIVIDUAL TABLE DATA CELLS-->
                                        <xsl:call-template name="tableheadcells"/>
                                        <!--END APPLY TEMPLATE FOR INDIVIDUAL CELLS-->
                                </tr>
				<!--END APPLY TABLE HEAD TEMPLATE-->
				
				<!--START LOOP THROUGH RESOURCES-->
				
				<xsl:apply-templates select="resource" />
				<!--END LOOP THROUGH RESOURCES-->
			</table>
</xsl:template>
<!--END BROWSE TABLE-->


<xsl:template match="resource">
							 <tr>
                                                        <!--ALTERNATE ROW COLORS-->
                                                                <xsl:attribute name="class">
                                                                        <xsl:choose>
                                                                                <xsl:when test="position() mod 2 = 1">row1</xsl:when>
                                                                                <xsl:otherwise>row2</xsl:otherwise>
                                                                        </xsl:choose>

                                                                </xsl:attribute>
                                                        <!--END ALTERNATE ROW COLORS-->
                                                        <!--APPLY DATA CELL TEMPLATE FOR EACH FIELD-->
                                                                <xsl:for-each select="./child::*[@view='1']">
                                                                        <xsl:apply-templates select="." />
                                                                </xsl:for-each>
                                 
                       <!--END APPLY DATA CELL TEMPLATE-->
							<xsl:if test="/page/session/access_level = '1'">
	                                                		<td>
									[<a href="#"><xsl:attribute name="onClick">deleteConfirm('?<xsl:call-template name="querystring"><xsl:with-param name="newkey">c</xsl:with-param><xsl:with-param name="newvalue">delete</xsl:with-param></xsl:call-template>&amp;id=<xsl:value-of select="id" />','<xsl:value-of select="/page/request/res" />');</xsl:attribute>Delete</a>]
								</td>
								   <td>
                                                                        [<a><xsl:attribute name="href">?<xsl:call-template name="querystring"><xsl:with-param name="newkey">c</xsl:with-param><xsl:with-param name="newvalue">edit</xsl:with-param></xsl:call-template>&amp;id=<xsl:value-of select="id" /></xsl:attribute>Edit</a>]
                                                                </td>
							</xsl:if>
						         </tr>

</xsl:template>

<!--INDIVIDUAL TABLE HEAD DATA CELLS-->
<xsl:template name="tableheadcells">
	<xsl:variable name="action">
		<xsl:call-template name="pageaction" />
	</xsl:variable>
	<xsl:for-each select="resource[1]/child::*[@view='1']">
	<th style="text-transform:capitalize;">
		<a style="color: #FFFFFF;">
			<xsl:attribute name="href">?c=<xsl:value-of select="$action" />&amp;res=<xsl:value-of select="//resources/resource[1]/@class" />&amp;order_by=<xsl:value-of select="name()" />
				<xsl:if test="/page/request/order_by = name()"> desc</xsl:if>&amp;page=<xsl:choose>																		<xsl:when test="/page/request/page &gt;= 1"><xsl:value-of select="/page/request/page" /></xsl:when>
								<xsl:otherwise>1</xsl:otherwise>		
							</xsl:choose>	
						</xsl:attribute>
								<xsl:choose>
									<xsl:when test="@label">
										<xsl:value-of select="@label" />
									</xsl:when>
									<xsl:otherwise>
										<xsl:value-of select="translate(name(),'_',' ')" />
		
									</xsl:otherwise>
								</xsl:choose>
								
							<xsl:variable name="descsortstring"><xsl:value-of select="name()" /><xsl:text> </xsl:text>desc</xsl:variable>
							<xsl:if test="/page/request/order_by = name()"> <xsl:text> </xsl:text><img src="css/images/sort_up_1.gif" border="0" /></xsl:if>	
							<xsl:if test="/page/request/order_by = $descsortstring"><xsl:text> </xsl:text><img src="css/images/sort_dn_1.gif" border="0"/></xsl:if>
							</a>
		
	</th>
						</xsl:for-each>
	<xsl:if test="/page/session/access_level = '1'">
		<th>
		Delete
		</th>
		<th>
		Edit
		</th>
	</xsl:if>
</xsl:template>
<!--END INDICIDUAL TABLE HEAD DATA CELLS-->


<!--END TABLE HEAD LOOP TEMPLATE-->

<!--ID DATA CELL-->
<xsl:template match="resource/child::*[@view='1'][name() = 'id']">
	<td>

		<a>
		<xsl:attribute name="href">
			?c=admin_view&amp;res=<xsl:value-of select="/page/content/resources/resource[1]/@class" />&amp;id=<xsl:value-of select="." />
		</xsl:attribute>
		<xsl:value-of select="." />
		</a>
	</td>
</xsl:template>
<!--END ID DATA CELL-->

<!--DATA CELL-->
<xsl:template match="resource/child::*[@view='1'][name() != 'id']">
	<td><xsl:value-of select="." /></td>
</xsl:template>
<!--END DATA CELL-->

<!--START NAVIGATION LINK TEMPLATES-->
<xsl:template match="link">
	<xsl:param name="divider" />

	
					<a>
					<xsl:attribute name="href">
						<xsl:value-of select="href" />
						<xsl:for-each select="queryparam">
							<xsl:value-of select="name" />=<xsl:value-of select="value" />
							<xsl:if test="position() != last()">&amp;</xsl:if>
						</xsl:for-each>
					</xsl:attribute>
					<xsl:value-of select="title" />
					</a>
	
			
	<xsl:if test="position() != last()"><xsl:value-of select="$divider" /></xsl:if> 
</xsl:template>
<!--END LINK TEMPLATE-->


<xsl:template name="adminform">
	<xsl:param name="action" />
	<xsl:param name="node" />
	<!--<xsl:param name="heading" />-->

	<form method="post" action="index.php">
	<input type="hidden" name="c"><xsl:attribute name="value"><xsl:value-of select="$action" /></xsl:attribute></input>
	<input type="hidden" name="res"><xsl:attribute name="value"><xsl:value-of select="$node/@class" /></xsl:attribute></input>
	<input type="hidden" name="id"><xsl:attribute name="value"><xsl:value-of select="/page/request/id" /></xsl:attribute></input>
		<table border="0" cellspacing="1">
			<tr>
				<td colspan="2" class="tr_2"><!--<xsl:value-of select="$heading" />--></td>
			</tr>
		
				<xsl:for-each select="$node/child::*[name() !='id'][@edit = 1]">
				<tr>
					<td style="text-transform:capitalize;" ><xsl:choose>
						<xsl:when test="@label">
							<xsl:value-of select="@label" />
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="name()" />
						</xsl:otherwise>
						</xsl:choose>
					</td>
					<td>
							<xsl:variable name="classname"><xsl:value-of select="name()" /></xsl:variable>
						<xsl:choose>
							<xsl:when test="@datatype = 'oneofmany'">
										<xsl:call-template name="dropdown">
											<xsl:with-param name="nodeset" select="/page/content/resources/resource[@class=$classname]" />
											<xsl:with-param name="namefield">name</xsl:with-param>
											<xsl:with-param name="valuefield">id</xsl:with-param>
											<xsl:with-param name="fieldname"><xsl:value-of select="name()" /></xsl:with-param>
											<xsl:with-param name="selectedvalue"><xsl:value-of select="." /></xsl:with-param>
										</xsl:call-template>
							</xsl:when>
							<xsl:when test="@datatype = 'manyofmany'">
									
										<xsl:call-template name="checkboxes">
											<xsl:with-param name="nodeset" select="/page/content/resources/resource[@class=$classname]" />
											<xsl:with-param name="value"><xsl:value-of select="." /></xsl:with-param>
										</xsl:call-template>
							</xsl:when>
							<xsl:when test="@datatype = 'date'">
								<input id="{name()}" type="text" size="40">
									<xsl:attribute name="name"><xsl:value-of select="name()" /></xsl:attribute>
									<xsl:if test=". != ''">
										<xsl:attribute name="value"><xsl:value-of select="." /></xsl:attribute>
									</xsl:if>
								</input>
								<script type="text/javascript">
								    Calendar.setup({
								        inputField     :    '<xsl:value-of select="name()" />',     // id of the input field
								        ifFormat       :    "%Y-%m-%d",      // format of the input field
								        button         :    '<xsl:value-of select="name()" />',  // trigger for the calendar (button ID)
								        align          :    "Tl",           // alignment (defaults to "Bl")
								        singleClick    :    true
								    });
								</script>
							</xsl:when>
							<xsl:otherwise>
					
								<input type="text" size="40">
									<xsl:attribute name="name"><xsl:value-of select="name()" /></xsl:attribute>
									<xsl:if test=". != ''">
										<xsl:attribute name="value"><xsl:value-of select="." /></xsl:attribute>
									</xsl:if>
								</input>
							</xsl:otherwise>
						</xsl:choose>
					</td>
				</tr>	

				</xsl:for-each>
				<tr>
					<td colspan="2">
				
						<p><input type="submit" name="submit" value="Save" /> </p>

					</td>
				</tr>


		</table>
	</form>
</xsl:template>

<xsl:template name="sortablehead">
        <xsl:param name="name" />
	<xsl:param name="label" />
                <a style="color: #FFFFFF;">
                        <xsl:attribute name="href">?<xsl:call-template name="querystring">
							<xsl:with-param name="newkey">order_by</xsl:with-param>
							<xsl:with-param name="newvalue"><xsl:value-of select="$name" /><xsl:if test="/page/request/order_by = $name"> desc</xsl:if></xsl:with-param>
						
					</xsl:call-template>
                                                </xsl:attribute>
                                                                <xsl:choose>
                                                                        <xsl:when test="$label">
                                                                                <xsl:value-of select="$label" />
                                                                        </xsl:when>
                                                                        <xsl:otherwise>
                                                                                <xsl:value-of select="translate($name,'_',' ')" />

                                                                        </xsl:otherwise>
                                                                </xsl:choose>

                                                        <xsl:variable name="descsortstring"><xsl:value-of select="$name" /><xsl:text> </xsl:text>desc</xsl:variable>
                                                        <xsl:if test="/page/request/order_by = $name"> <xsl:text> </xsl:text><img src="css/images/sort_up_1.gif" border="0" /></xsl:if>
                                                        <xsl:if test="/page/request/order_by = $descsortstring"><xsl:text> </xsl:text><img src="css/images/sort_dn_1.gif" border="0"/></xsl:if>
                       </a>
</xsl:template>


</xsl:stylesheet>
