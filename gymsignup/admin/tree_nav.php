<?
/**
*This class handles tree navigation through a web browser
*Pass it an associative array with parent ids as values, and child ids as keys.
*/
class tree_nav extends tree{
	var $list = array();
	var $propname;
	var $resource;
	var $contentfile;
	
	function tree_nav($resource = '',$contentfile='content.php',$propname='name'){
		
		$this->contentfile = $contentfile;
		$this->propname = $propname;
		$this->resource = $resource;
		if(is_object($resource)){
			$this->build_from_resource($resource);	
		}
		return $this->tree($this->list);
	}
	
	function get_css(){
		return "<style type='text/css'>
ul ul{
 display:none;
}

li{
 list-style-type: none;
}
		</style>";
	}
	
	function get_js(){
		return '<script language="javascript">
		
var CLASS_NAME = "expandable";


var DEFAULT_DISPLAY = "none";


var XMLNS = "http://www.w3.org/1999/xhtml";

function initExpandableLists() {
    if (!document.getElementsByTagName) return;

    // Top-level function to accommodate browsers that do not register
    // a click event when a link is activated by the keyboard.
    switchNode = function(id) {
        var node = document.getElementById(id);
        if (node && /^switch /.test(node.className)) node.onclick();
    }

    // Top-level function to be assigned as the event handler for the
    // switch. This could have been bound to the handler as a closure,
    // but closures are associated with memory leak problems in IE.
    actuate = function() {
        var sublist = this.parentNode.getElementsByTagName("ul")[0];
        if (sublist.style.display == "block") {
            sublist.style.display = "none";
            this.firstChild.data = "+";
            this.className = "switch off";
            this.title = this.title.replace("collapse", "expand");
        } else {
            sublist.style.display = "block";
            this.firstChild.data = "-";
            this.className = "switch on";
            this.title = this.title.replace("expand", "collapse");
        }
        return false;
    }

    // Create switch node from which the others will be cloned.
    if (typeof document.createElementNS == "function")
        var template = document.createElementNS(XMLNS, "a");
    else
        var template = document.createElement("a");
    template.appendChild(document.createTextNode(" "));

    var list, i = 0;
    var pattern = new RegExp("(^| )" + CLASS_NAME + "( |$)");

    while ((list = document.getElementsByTagName("ul")[i++])) {
        // Only lists with the given class name are processed.
        if (pattern.test(list.className) == false) continue;

        var item, j = 0;
        while ((item = list.getElementsByTagName("li")[j++])) {
            var sublist = item.getElementsByTagName("ul")[0];
            // No sublist under this list item. Skip it.
            if (sublist == null) continue;

            // Attempt to determine initial display style of the
            // sublist so the proper symbol is used.
            var symbol;
            switch (sublist.style.display) {
            case "none" : symbol = "+"; break;
            case "block": symbol = "-"; break;
            default:
                var display = DEFAULT_DISPLAY;
                if (sublist.currentStyle) {
                    display = sublist.currentStyle.display;
                } else if (document.defaultView &&
                           document.defaultView.getComputedStyle &&
                           document.defaultView.getComputedStyle(sublist, ""))
                {
                    var view = document.defaultView;
                    var computed = view.getComputedStyle(sublist, "");
                    display = computed.getPropertyValue("display");
                }
                symbol = (display == "none") ? "+" : "-";
                // Explicitly set the display style to make sure it is
                // set for the next read. If it is somehow the empty
                // string, use the default value from the (X)HTML DTD.
                sublist.style.display = display || "block";
                break;
            }

            var actuator = template.cloneNode(true);
            var uid = "switch" + i + "-" + j; // a reasonably unique ID
            actuator.id = uid;
            actuator.href = "javascript:switchNode(\'" + uid + "\')";
            actuator.className = "switch " + ((symbol == "+") ? "off" : "on");
            actuator.title = ((symbol == "+") ? "expand" : "collapse") + " list";
            actuator.firstChild.data = symbol;
            actuator.onclick = actuate;
            item.insertBefore(actuator, item.firstChild);
        }
    }
}

function setContent(what){
	framecollection = document.getElementsByTagName("iframe");
	cframe = framecollection[0];
		
	cframe.setAttribute("src",what);
	
	
}	
		
var oldhandler = window.onload;
window.onload = (typeof oldhandler == "function")
    ? function() { oldhandler(); initExpandableLists(); } : initExpandableLists;

		
		
		</script>';
	}
	
	function navlet($id){
		$resource = $this->resource;
		$resource->populate($id);
		$name = $resource->get_prop($this->propname);
		$level = count($this->trace_ancestors($id));
		$parent = $resource->get_prop('parent');	
			

		$tabs = "\t";
		for($i=0;$i<$this->count_ancestors($id);$i++){
			$tabs .= "\t";	
		}
		
		$contentfile = $this->contentfile;
		$out .= $tabs . "<a href='#' onClick='setContent(\"$contentfile?id=$id\")'";

		$out .= ">$name</a>\n";
			
		return $out;
	}
	
	
	
	function show_nav(){
		//class = navlevel[number]
		//where [number] represents how many levels deep 
		//the node is

	
		//$out .= "\t<div id='nav'>";
		$out .= "\t\t<ul class='expandable'>\n";
		
		
		
		foreach($this->get_root_nodes() as $node){
			//$out .= $this->navlet($id); 
			$out = $this->call_recursive($node,"\$this->navlet(\$id)",$out);	
		}

		$out .= "\t\t</ul>\n";
		//$out .= "\t</div>\n";
		
		return $out;

	}	
		
	function call_recursive($id, $function, $out){
		$tabs = "\t";
		
		for($i=0;$i<$this->count_ancestors($id);$i++){
			$tabs .= "\t";	
		}
		$out .= "$tabs<li>\n";
		eval("\$out .= $function;");
	
		if($this->count_children($id)){
			$out .= "$tabs\t<ul>\n";
			$array = $this->get_children($id);
			foreach($array as $id){
				
				$out = $this->call_recursive($id,$function, $out);
			
			}	
			$out .= "\t$tabs</ul>\n";
			
		}
		$out .= "$tabs</li>\n";
		return $out;	
		
	}
}
?>
