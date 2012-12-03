<?
class view{
	var $document;
	var $stylesheet;
	var $resources;

	
	function build($resourcearray=array(),$auxarray=array()){

		
		$this->mode = $_SESSION['mode']? $_SESSION['mode'] : 'live';
				
		//$this->document->formatOutput = true;
		
		
		$xml = '';
		if(is_array($resourcearray)){
			foreach($resourcearray as $robj){
				if(is_object($robj)){
					$resxml .= $robj->get_props_xml() . "\n";	
				}
			}
		}
		global $message;
		
		//BUILD XML STRING
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet href="xsl/' . $this->stylesheet . '" type="text/xsl"?>
<page>
  <session>
		' . $this->array_to_xml($_SESSION) . ' 
  </session>
  <request>
   ' . $this->array_to_xml($_REQUEST) . '
  </request>
  ' . $message->get_xml() . ' 
  <aux>
  ' . $this->array_to_xml($auxarray) . '
  </aux>
  <navigation>
  ' .  $this->build_navigation() . '
  </navigation>
  <content>
    <resources>
 ' . $resxml . '
    </resources>
  </content>
</page>';
	//END BUILD XML STRING

		//encode xml utf8
		$xml = utf8_encode($xml);
		
		
		//if in debug mode, send xml to browser
		if($this->mode=='debug'){
			
			header("content-type: text/xml");
			//replace stylesheet
		
			return $xml;	
		
		//else proscess xsl and send html to browser
		}else if($this->mode=='live'){
			header("content-type: text/html");
	
			$arguments = array(
  			   '/_xml' => $xml
			);

			$xslpath = "xsl/" . $this->stylesheet;

			$xh = xslt_create();
			$result = xslt_process($xh, 'arg:/_xml', "$xslpath", NULL, $arguments); 


			return $result;
		}
	}
	
	/**
	*Turns an associative array into a string xml fragment
	*/
	function array_to_xml($array = array()){
		$out = "";
		if(is_array($array)){
			foreach($array as $key => $value){	
				$value = str_replace("&","&amp;",$value);
				$value = str_replace("<","&lt;",$value);
				$value = str_replace(">","&gt;",$value);
			
				$out .= "<$key>";
				$out .= $value;
				$out .= "</$key>\n";
			}
		}
		return $out;
	}
	
	/**
	*sets string xsl stylesheet filename
	*/
	function set_stylesheet($path){
		if(!$this->stylesheet){
			$this->stylesheet = $path;
		}	
	}
	
	/**
	*Takes string xml and processes with xsl stylesheet, returning output
	*/
	function process_xsl($xml){
		$xslpath = "../xsl/" . $this->stylesheet;
		$xsl = DomDocument::load($xslpath);  	
	
		$xslproc = new XSLTProcessor();
		$xslproc->importStylesheet($xsl);
		return $xslproc->transformToXML($xml);
	}
	
	function add_request_var($key,$value){
		$dom = $this->document;
		$reqnode = $dom->getElementByTagName("request");
		$reqnode->appendChild($dom->createElement($key,$value));	
		$this->document = $dom;
	}
	
	function build_navigation(){
	}

}

?>
