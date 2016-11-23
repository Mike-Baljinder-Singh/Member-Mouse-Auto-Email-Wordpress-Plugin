<?php
/* 
Core function to create cron of emails and send them
 */
function cromme(){
	$optns = unserialize( get_option( 'mm-remind-set' ) );
	$emaildata = beginmm_process( @$optns['mm-remind-days'] );
	$body = stripslashes( @$optns['mm-remind-email-content'] );
	$body = str_ireplace( "https", "http", $body );
	$body = str_ireplace( "\n", "<br>", $body );
	$subject = @$optns['subject'];
	if( !@in_array("test_is_on", $optns ) ){
		foreach($emaildata as $emaildatum){
			//replacement shortcodes
			foreach( $emaildatum as $key => $val ){
				$body = str_ireplace( "[". $key ."]", $val, $body );
				$subject = str_ireplace( "[". $key ."]", $val, $subject );
			}
			wp_mail( $emaildatum['memeberEmail'], $subject, $body, array('Content-Type: text/html; charset=UTF-8') );
			//print_r($emaildatum);
		}
	}
	else{
		$body.= '<br><br><hr><strong>Log Data<strong><br><pre>'.print_r($emaildata, true).'</pre>';
		wp_mail( @$optns['testemail'], $subject, $body, array('Content-Type: text/html; charset=UTF-8') );
	}
	//header('Location: '.site_url());
	if(!isset($_GET['mmaetrigger'])) echo "<script>location.reload(true);</script>";
	else echo "<script>alert('Success! Your manual request to have email notifications sent has been executed. Please note that all subscribers who fit the requirements of the notification have been sent emails just now. If you had test mode enabled, then only the test email recipient will receive the emails.');</script>";
	exit;
}
?>