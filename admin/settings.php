<?php
/* 
Settings page of the plugin
 */
//Saving the options
if( isset( $_POST[ 'saveoptions' ] ) ){
	update_option( 'mm-remind-set', serialize( $_POST ) );
	//update_option( 'mm-remind-email-content', $_POST['mm-remind-email-content'] );
}
$optns = unserialize( get_option( 'mm-remind-set' ) );
//echo 'baltest- '.MM_TABLE_ORDER_ITEMS;

$settings = array();// 'quicktags' => array('media_buttons' => false) );
?>
<div class="wrap soc-settings">
	<h1>MemberMouse Email Reminder Settings</h1>	<br><br>
		<div class="soc_content">
			<form action="" method="post">
				<div id="titlediv">
					<h2>Subject for Email to be sent</h2>
					<div id="titlewrap">
							<label class="screen-reader-text" id="title-prompt-text" for="title">Subject for Email to be sent</label>
						<input type="text" name="subject" size="30" value="<?=@$optns['subject']?>" id="title" spellcheck="true" autocomplete="off">
					</div>
				</div>
				<br>
				<div class="editor">
					<?php wp_editor( stripslashes( @$optns['mm-remind-email-content'] ), "mm-remind-email-content", $settings ); ?>
				</div>
				<br>
				<table class="mm-settings-table">
					<tr>
						<td class="left">Days Prior to send Reminder:</td>
						<td class="right"><input type="number" required min="1" name="mm-remind-days" value="<?=@$optns['mm-remind-days']	?>" /></td>
						<td class="left">Test Mode:</td>
						<td class="right"><input type="checkbox" name="test_mode" <?php if( @in_array("test_is_on", $optns ) ) echo "checked"; ?> value="test_is_on"/> <i>Sends email only to Test Email, with log.</i></td>
					</tr>
					<tr>
						<td class="left">Secret trigger Code:</td>
						<td class="right"><input type="text" name="triggercode" value="<?=@$optns['triggercode']?>" required/></td>
						<td class="left">Test Email:</td>
						<td class="right"><input type="email" name="testemail" value="<?=@$optns['testemail']?>" /><!--<br><i>Test email will send 1 email only with all possible values in a log, only to the test email and not to the users email.</i>--></td>
					</tr>
					
				</table>
				
				 
				<br>
				<?php if(@$optns['triggercode'] <> ''){?>
				<a href="<?=site_url().'?mmaetrigger='.@$optns['triggercode']?>" onclick="triggermmae(this); return false;" target="_blank">Click to trigger the Automated Email right away. <strong>Must be used with caution.</strong></a>
				<br><br>
				<!--Wordpress Crons are not reliable. Please add the following php script calls from your hosting account <strong>Daily</strong>.
				<br>
				Path of php call to make: <?=get_home_path().'?mmaetrigger='.@$optns['triggercode']?>-->
				<?php } ?>
				<div class="input_wrap1 input_wrap_submit">
					<input type="submit" name="saveoptions" value="Save Settings" />
				</div>
			</form><br>
			<i><strong>Available Shortcodes and their example output:</strong></i>
			<br>
			[memberID] => 152<br>
            [memeberEmail] => reich@pobox.com<br>
            [memberPhone] => 6507232608<br>
            [memberFName] => R<br>
            [memberLName] => Reich<br>
            [memExpiry] => Aug 20, 2016<br>
            [id] => 17<br>
            [name] => $5 Fishhook Subscription<br>
            [sku] => 7854IKI<br>
            [amount] => 5.00<br>
            [quantity] => 1<br>
            [total] => 5.00<br>
            [is_recurring] => 1<br>
            [recurring_amount] => 20.0000<br>
            [rebill_period] => 1<br>
            [rebill_frequency] => years
			<br>
			
	</div>
</div>
