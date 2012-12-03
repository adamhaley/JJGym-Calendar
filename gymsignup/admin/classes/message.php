<?php
/**
*@package message.php
*/
/**
*@package message
*/
class message{
	var $messages;
	function message(){
		$this->messages = array();
	}
	
	function add($type,$message){
		//add the error to the error list
		$this->messages[] = array('message' => "$message","type" => "$type");
		
	}	

	function get(){
		//return message list web-readable 
		if($this->num_messages()){
			$list = '<div class="messages">';
			foreach($this->messages as $msgarray){
				
			
					$type = $msgarray['type'];
					$msg = $msgarray['message'];
					$list .= "<div class='" . $type . "'>\n";
					$list .=  $msg . "\n<br />";
					$list .= "</div>\n";
			
			}
			$list .= '</div>';
		}
		return $list;
	}
	
	function get_xml(){
		$messages = $this->get_messages_array();
		
		$out = '';
		$out .= '<messages>';
		if(count($messages)){
			foreach($messages as $k => $array){
			
			$out .= "<message type='" . $array['type'] . "'>" . $array['message'] . '</message>';
		
			}
		}
		$out .= '</messages>';
		return $out;
	}
	
	function num_messages() {
		return count($this->messages);
	}
	function num_errors() {
		$i=0;
		foreach($this->messages as $message){
			if($message['type'] == 'error'){
				$i++;
			}	
		}
		return $i;
	}
	function get_messages_array(){
		return $this->messages;	
	}
}
?>
