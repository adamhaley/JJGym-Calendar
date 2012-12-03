<?
/** 
* 
*Generate Navigation as XML that will be used in the view & transformed by XSLT into HTML
*This class is meant to be subclassed on a per module basis.
*The module-specific subclass will create its nav by adding to the navgroups array
*
*@author Adam Haley <adam.haley@disney.com>
*@access public
*@package nav
*/
class nav{
	/**
	*@var array The list of "navgroups". Each navgroup corresponds to an area of the page that contains navigation lnks.Each "navgroup" in the array will hold an array of links. The array is formatted as follows:
	*<code>
	*$navgroups = array(
	*			array('Link1' => array(
	*				'param' => 'value',
	*				'anotherparam' => 'value'
	*				),
	*				'Link2' => array(
	*				'param' => 'value',
	*				'anotherparam' => 'value'
	*				)
	*			),
	*			array('Link1' => array(
        *                               'param' => 'value',
        *                               'anotherparam' => 'value'
        *                               ),
        *                               'Link2' => array(
        *                               'param' => 'value',
        *                               'anotherparam' => 'value'
        *                               )
        *                       )
	*		);
	*</code>
	*/
	var $navgroups;
	function __construct(){
		$this->navgroups = array();
	}

	/**
	*Takes navigation array and adds as a navgroup to the navgroups array
	*
	*Each navgroup array is formatted as follows(example from Production Admin:
	*<code> array(
        *                       'View Productions' => array(
        *                                'c' => 'browse_productions',
        *                                ),
        *                        'Admin Search' => array(
        *                                'c' => 'admin_search',
        *                                )
        *                )
	*</code>
	*This navarray would produce two links with the text 'View Productions' and 'Admin Search'
	*The first link would have the href value '?c=browse_productions' and the second would link to '?c=admin_search'
	*there is currently no support for static links, only querystrings
	*
	* @param        array [$navarray] navigation array
	* @return       void
	*/
	function add_navgroup($navarray){
		$this->navgroups[] = $navarray;
	}
	
	/**
	*Returns navigation as XML 
	* @param        void
        * @return       string navigation XML
	*/
	function return_xml(){
		$navgroups = $this->navgroups;
                $i = 2;
		$out = '';
                foreach($navgroups as $navgroup){
                        $out .= "<navgroup id=\"$i\">";
                                foreach($navgroup as $label => $array){
                                        $out .= "<link>";
                                                $out .= "<title>$label</title>";
                                                foreach($array as $key => $value){
                                                        $out .= "<queryparam>";
                                                        $out .= "<name>$key</name>";
                                                        $out .= "<value>$value</value>";
                                                        $out .= "</queryparam>";
                                                }
                                        $out .= "</link>";
                                }
                        $out .= "</navgroup>"; 
			$i++;                 
                }
                return $out;
	}

}
?>
