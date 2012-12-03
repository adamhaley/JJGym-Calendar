<?
/**
*This class is for paginating through datasets
*@package pager
*/
class pager{
		/**
		*The constructor takes three arguments. total,perpage,and currentpage.
		*$total is total number of records in the result set.
		*$perpage is the number of records to display per page.
		*$currentpage is the current page number.
		*
		*/

		/**
		*@var int Total number of records in result set
		*/
		var $total;

		/**
		*@var int Number of records to display per page
		*/
		var $perpage;
		
		/**
		*@var int Current page number
		*/
		var $currentpage;
		/**
		*@var int Number of pages recordset will be spread out amongst
		*/
		var $numpages;
		
        function pager($total,$perpage,$currentpage){
				$this->total = $total;
                $this->perpage = $perpage;
                $this->currentpage = $currentpage ? $currentpage : 1;
        	$this->numpages = ceil($total / $perpage);
		
        		
        		//echo "TOTAL IS " . $this->total . " PERPAGE IS " . $perpage . " CURRENTPAGE IS " . $currentpage;
        		
	}

		/**
		*This function returns the limit clause to tack on to the end of your SQL query.
		*Using your sql query with this limit clause will keep your page from loading the full result set
		*/
        function limit_clause(){
                $pp = $this->perpage;
		
                $cp = $this->currentpage -1;
                $start = $cp * $pp;
                $clause = "$start,$pp";
		return $clause;
        }
        
   
		/**
		*This function returns the pagination navigation 
		*/
        function nav($url=''){
        
            $url =  $url? $url : new url(); 
        	
        	$cp = $this->currentpage;
        	$np = $this->numpages;
        	
        	$nav = '';
        	$url->remove_key('page');
 			$url->remove_key('p');
        	
        	//$url->add_key_values(array('action' => 'browse'));
        	$string = $url->get_string();
        	if($string){
        		$string = "?$string&";	
        	}else{
        		$string = "?";	
        	}
        	$dd = "<select name='page' onChange=\"goPage('$string',this)\">\n";
        		for($i=1;$i<=$this->numpages;$i++){
        			$dd .= "<option value='$i'";
        			if($i==$cp){
        				$dd .= ' selected ';	
        			}
        			$dd .= ">$i\n";	
        		}
        	$dd .= "</select>"; 

        	$total = $this->total;
        	$start = ($this->currentpage-1) * $this->perpage;
        	$start +=1;
        	$end = $start + $this->perpage -1;
        	$end = $end > $total ? $total : $end;
        	
        	
        	
        	$blurb = "Viewing $start to $end<br />Search results: $total ";
        	
        	  	
			if($np > 1){
				$prev = $cp - 1;
				$next = $cp + 1;
				$nav .= "<div class='paginatorleft'>";
				$nav .= ($cp == 1)? "      &lt;&lt;-     " : "     <a href=\"?" . $url->add_key_values(array('page' => 1)) . "\">&lt;&lt;-</a>      ";
			
				$nav .= $prev ? "     <a href=\"?" . $url->add_key_values(array('page' => $prev)) . "\">&lt;</a>\n     " : "&lt;\n  ";
				$nav .= "</div>";
				$nav .= "<div class='paginatortext'>$blurb<br />Page $dd of $np<br /> <br /></div>";
				
				$nav .= "<div class='paginatorright'>";
				$nav .= ($cp >= $np)? "   &gt;   " : "    <a href=\"?" . $url->add_key_values(array('page' => $next)) ."\">&gt;</a>    ";
				$nav .= ($cp == $np)? "   -&gt;&gt;    " : "    <a href=\"?" . $url->add_key_values(array('page' => $np)) . "\">-&gt;&gt;</a>    "; 
				$nav .= "</div>";
				
			}
			
			//reset url page to current page
			$url->add_key_values(array('page' => $cp));
			return "<div class='paginator'>$nav</div>";
		}
		
	
	
}
?>
