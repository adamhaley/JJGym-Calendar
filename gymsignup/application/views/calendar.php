<script>
        function selectDay(month,day,year){
		event.cancelBubble=true;
        }
</script>
<div id="announcements">
<p>
        <font style="font-size:14px"><em><strong><span style="color: rgb(0, 128, 128);">If you would like to donate to the Kalvan Gym, click the "Donate" button below.  &nbsp;</span></strong></em></font></p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="11051410"> <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"> <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"> </form>

 <? echo $announcements;?><br />
</div>
<?php echo $cal; ?>
