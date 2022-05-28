<script>
        function selectDay(month,day,year){
            alert('month is ' + month + ', day is ' + day + ' and year is ' + year);
		    form = document.forms[0];        
		    form.date_month.selectedIndex = month-1;
		    form.date_day.selectedIndex = day-1;
            form.date_year.selectedIndex = (year==(new Date()).getFullYear())? 0 : 1;
        }
	
	function showCalendar(){
		//alert('in show calendar');

		//alert($("calendar"));
		/*
		$('calendar').css('display') = 'block';
		*/
	}
</script>
<form method="post" name="bookform" action="index.php?calendar/book_time_process">
<div id="form">
	<div class="formrow">
		<div class="formlabel">
				Date:
		</div>
		<div class="formfield">
			<select name="date_month">
				<?
				$i = 1;
				foreach(array('January','February','March','April','May','June','July','August','September','October','November','December') as $month){
					echo "<option value='$i' ";
					if(date('F') == $month){
						echo "selected='1' ";
					}
					echo ">$month</option>\n";
					$i++;
				}
				?>
			</select>
			<select name="date_day">
				<?
				foreach(array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31) as $day){
					echo "<option value='$day'";
					if(date("j") ==	$day){
						echo " selected='1' ";
					}
					echo ">$day</option>\n";		
				}
				?>
			</select>
			<select name="date_year">
                    <?
                    for($i=date("Y");$i<=date("Y")+1;$i++){
                            echo "<option value='$i'>$i</option>";
                    }
                    ?>
            </select>
			<!--
			[<a href="#" onClick="showCalendar();">Calendar</a>]
			-->
		</div>
	</div>
	<div class="formrow">
		<div class="formlabel">
			Start Time:
                </div>
                <div class="formfield">
		<select name="time_start">

			<option value="7:00">7:00 am</option>
			<option value="7:30">7:30 am</option>
			<option value="8:00">8:00 am</option>
			<option value="8:30">8:30 am</option>
			<option value="9:00">9:00 am</option>
			<option value="9:30">9:30 am</option>
			<option value="10:00">10:00 am</option>
			<option value="10:30">10:30 am</option>
			<option value="11:00">11:00 am</option>
			<option value="11:30">11:30 am</option>
			<option value="12:00">12:00 pm</option>
			<option value="12:30">12:30 pm</option>
			<option value="13:00">1:00 pm</option>
			<option value="13:30">1:30 pm</option>
			<option value="14:00">2:00 pm</option>
			<option value="14:30">2:30 pm</option>
			<option value="15:00">3:00 pm</option>
			<option value="15:30">3:30 pm</option>
			<option value="16:00">4:00 pm</option>
			<option value="16:30">4:30 pm</option>
			<option value="17:00">5:00 pm</option>
			<option value="17:30">5:30 pm</option>
			<option value="18:00">6:00 pm</option>
			<option value="18:30">6:30 pm</option>
			<option value="19:00">7:00 pm</option>
			<option value="19:30">7:30 pm</option>
			<option value="20:00">8:00 pm</option>
			<option value="20:30">8:30 pm</option>
			<option value="21:00">9:00 pm</option>
			<option value="21:30">9:30 pm</option>
			<option value="22:00">10:00 pm</option>
			<option value="22:30">10:30 pm</option>
			<option value="23:00">11:00 pm</option>
			<option value="23:30">11:30 pm</option>
		</select>

			<br />        
	</div>
	</div>
	<div class="formrow">
		<div class="formlabel">
			End Time:
		</div>
		<div class="formfield">
			<select name="time_end">
						<option value="7:00">7:00 am</option>
						<option value="7:30">7:30 am</option>
                        <option value="8:00">8:00 am</option>
                        <option value="8:30">8:30 am</option>
                        <option value="9:00">9:00 am</option>
                        <option value="9:30">9:30 am</option>
                        <option value="10:00">10:00 am</option>
                        <option value="10:30">10:30 am</option>
                        <option value="11:00">11:00 am</option>
                        <option value="11:30">11:30 am</option>
                        <option value="12:00">12:00 pm</option>
                        <option value="12:30">12:30 pm</option>
                        <option value="13:00">1:00 pm</option>
                        <option value="13:30">1:30 pm</option>
                        <option value="14:00">2:00 pm</option>
                        <option value="14:30">2:30 pm</option>
                        <option value="15:00">3:00 pm</option>
                        <option value="15:30">3:30 pm</option>
                        <option value="16:00">4:00 pm</option>
                        <option value="16:30">4:30 pm</option>
                        <option value="17:00">5:00 pm</option>
                        <option value="17:30">5:30 pm</option>
                        <option value="18:00">6:00 pm</option>
                        <option value="18:30">6:30 pm</option>
                        <option value="19:00">7:00 pm</option>
                        <option value="19:30">7:30 pm</option>
                        <option value="20:00">8:00 pm</option>
                        <option value="20:30">8:30 pm</option>
                        <option value="21:00">9:00 pm</option>
                        <option value="21:30">9:30 pm</option>
                        <option value="22:00">10:00 pm</option>
                        <option value="22:30">10:30 pm</option>
                        <option value="23:00">11:00 pm</option>
                        <option value="23:30">11:30 pm</option>
                </select>
		</div>
	</div>
	<div class="formrow">
		<div class="formlabel">
			Usage: (percentage of the studio needed)
                </div>
                <div class="formfield">
                	<select name="usage">
                        	<option value="25">25%</option>
							<option value="50">50%</option>
							<option value="75">75%</option>
							<option value="100">100%</option>
                        </select>
                        <br />
		</div>
	</div>
<div class="formrow">
	  	<div class="formlabel">
			Note:
                </div>
                <div class="formfield">
					<input type="text" size="30" name="comments" value="<?if(isset($event->comments)){echo $event->comments;}?>"/>
                </div>
	</div>
	<script>
		function toggleRepeatDate(){
			newstyle=($('repeatDate').style.display=='none')? 'block' : 'none';
		
			$("repeatDate").style.display=newstyle;
		}

	</script>
	<div class="formrow">
		<div class="formlabel">
        		Repeat Weekly: 
	       </div>
                <div class="formfield">
					<input type="checkbox" name="repeat" onChange="toggleRepeatDate()"/>
                </div>
	</div>
	<div style="display:none;" id="repeatDate">
		<div class="formlabel">
                        Repeat Until:
               	</div>
		<div class="formfield">
		 <select name="repeat_until_month">
                                <?
                                $i = 1;
                                foreach(array('January','February','March','April','May','June','July','August','September','October','November','December') as $month){
                                        echo "<option value='$i' ";
                                        if(date('F') == $month){
                                                echo "selected='1' ";
                                        }
                                        echo ">$month</option>\n";
                                        $i++;
                                }
                                ?>
                        </select>
                        <select name="repeat_until_day">
                                <?
                                foreach(array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31) as $day){
                                        echo "<option value='$day'";
                                        if(date("j") == $day){
                                                echo " selected='1' ";
                                        }
                                        echo ">$day</option>\n";
                                }
                                ?>
                        </select>
			<select name="repeat_until_year">
				<?
				for($i=date("Y");$i<=date("Y")+1;$i++){
					echo "<option value='$i'>$i</option>";
				}
				?>
			</select>
		</div>
	</div>
	<br /><br />
	<div class="formrow">
		<input type="submit" value="Reserve" />  
	</div>
</div>
<style>
	td.day,td.before,td.today{
        	width:40px;
        	height:40px;
	}
	td.day:hover,td.before:hover,td.today:hover {
		background-color:#dfdfdf;
		cursor : pointer;
	}
	td.title{
        font-size:10px;
        text-align:center;
}

</style>
<div id="calendar" style="position:absolute;left:270px;top:70px;">
Click a date to select:
<?php
	echo $cal;	
?>

</div>

</form>
