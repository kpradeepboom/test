<?php
	session_start();
	include("../include/dbconfig.php");
	include("../include/functions.php");
	
	date_default_timezone_set(time_zone);
	if(!is_login($_SESSION["staff_id"]))
	{
		header("location:".site_address);
	}
	if(!check_permission($_SESSION["staff_id"], "Check in form Management", ""))
	{
		echo '<script>alert("Error!,\nPermission Not Allowed.");</script>';
		echo '<script>window.location.replace("index.php");</script>';
	}
	$title = company_name." | Check in out form";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    
</head>
    <body>
	
	<?php
	if(isset($_POST['save_easy_check_in']))
		{
		$client_name = $_POST['client_name'].' '.$_POST['client_middle_name'].' '.$_POST['client_last_name'];
		$dob = $_POST['dob'];
		$first_name = $_POST['client_name'];
		$mid_name = $_POST['client_middle_name'];
		$last_name = $_POST['client_last_name'];
		$self_check_in_reason = $_POST['self_check_in_reason'];
		date_default_timezone_set('America/New_York');
        $timestamp = date("m-d-Y H:i:sA");
        $time_now = date("H:ia");
        $cli_id = 'EPP'.mt_rand(10000, 99999);
        $pre_registration_date = $_POST['cur_date'];
        $date_y = date("Y-m-d", strtotime($pre_registration_date));
        $token_id = mt_rand(10000,99999);
		$staff_id = $_SESSION["staff_id"];

		$insert = mysqli_query($conn, "insert into check_in_form_table 
		(client_name,client_reg_no,date,dob,check_in_reason,time_in,program_name,created_at,created_by,token_id)values
		('$client_name','$cli_id','$date_y','$dob','$self_check_in_reason','$time_now','Individual Client','$timestamp','$staff_id','$token_id')");
		
		if($insert){
		    

		    
		    echo"<script>
		    alert('Your Token id is $token_id Your Registration number is client_reg_no=$cli_id');
		    window.location.assign('check_in_out_form.php');
		    </script>";
		}else{
			echo"<script>
		    alert('Check-in Failure');
		    
		    </script>";
		}
        
	}
?>
		<form method="post" autocomplete="off">
                            	<div class="row">
                                	
                                <div class="col-lg-12">
                                    <p class="label2">Check-in reason</p>
                                    	<textarea id="self_check_in_reason" name="self_check_in_reason" type="text" class="form-control" required></textarea> 
                                    	<p class="label2">First name</p>
                                        <input id="txt_client_name" name="client_name" autocomplete="off"  type="text" class="form-control" required>
                                        <p class="label2">Middle name</p>
                                        <input id="txt_client_name" name="client_middle_name" autocomplete="off" type="text" class="form-control">
                                        <p class="label2">Last name</p>
                                        <input id="txt_client_name" name="client_last_name" autocomplete="off"  type="text" class="form-control" required>
                                        <p class="label2" hidden>Patient registration no.</p>
                                        <input id="txt_client_form_reg_no" name="client_reg_no" autocomplete="off" value="<?php echo $dob1; ?>" type="hidden" class="form-control" readonly required>
                                        
                                        <p class="label2" hidden>Date of birth</p>
                                        <input type="hidden" name="cur_date" placeholder="mm/dd/yyyy" autocomplete="off" value="<?php echo date("Y/m/d");?>"  class="form-control need_datepicker" required>
                                        
                                       <p class="label2">Date of birth</p>
                                        <input type="text" name="dob"  autocomplete="off" class="form-control need_datepicker" required>
                                    </div>
                                    
                                </div>
								<br>
                                 
								</div>
								<div class="modal-footer">
								<input type="submit" name="save_easy_check_in" class="btn btn-default" value="Submit">
								  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
								</form>
    </body>    
 </html>