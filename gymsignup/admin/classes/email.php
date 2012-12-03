<?
class email{
  var $to ='';
  var $from = '';
  var $replyto = '';
  var $subject = '';
  var $body = '';
  var $headers = '';
  function __construct(){
    return;
  }

  function set_prop($propname,$value){
    eval("\$this->$\$propname = $value;");
  }

  function get_prop($propname){
    eval("\$value = \$this->$\$propname;");
    return $value;
  }

  function send(){
    mail($this->to,$this->subject,$this->body,"From:" . $this->from . "\r\n" . "Reply-To: " . $this->replyto . "\r\n" . $this->headers);
  }
}
?>
