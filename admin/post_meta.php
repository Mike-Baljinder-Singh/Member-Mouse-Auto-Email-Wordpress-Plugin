<?php
function post_meta_box_soc_share( $post ) {
    add_meta_box( 
        'soc-share',
        __( 'Soc Share Post Specific Settings' ),
        'render_soc_share',
        '',
        'normal',
        'default'
    );
}
function render_soc_share($post){
	?>
	Use Global: 
	<select name="soc-share-global">
		<option value="yes">Yes</option>
		<option <?php if( get_post_meta( $post->ID, 'soc-share-global', true ) == 'custom' ) echo "selected"; ?> value="custom">Use Custom for this post</option>
	</select>
	<?php
	$optns = unserialize( get_post_meta( $post->ID, 'soc-share-set', true ) );
	?>
	<div class="wrap soc-post-settings" <?php if( get_post_meta( $post->ID, 'soc-share-global', true ) <> 'custom' ) echo "style='display:none'"; ?>>
		<div class="input_wrap input_wrap_ntwrks">
			<div class="heading">Social Networks:</div>
			<?php
			$sns=array(
					"fb" => "Facebook",
					"tw" => "Twitter",
					"gp" => "Google+",
					"pt" => "Pinterest",
					"li" => "LinkedIn",
					"wa" => "WhatsApp"
				);
			if( is_array( @$optns[ 'soc_netwrks' ] ) ) $srtdsns = array_merge( $optns[ 'soc_netwrks' ], $sns );
			else $srtdsns = $sns;
			$srtcntr = 1;
			foreach( $srtdsns as $snid => $sn ){
			?>
				<div class="content">
					<span class="row_hldr" position="<?php echo $srtcntr++; ?>">						<span class="inputelements">
							<input <?php if( @in_array( $sn, $optns[ 'soc_netwrks' ] ) ) echo "checked"; ?> type="checkbox" name="soc-share-set[soc_netwrks][<?php echo $snid; ?>]" id="<?php echo $snid; ?>" value="<?php echo $sn; ?>" />
							<label for="<?php echo $snid; ?>"><?php echo $sn; ?></label>
						</span>
						<img src="<?php echo SOCSHAREURL ?>/assets/upArrow.png" class="moveup" /> 						<img src="<?php echo SOCSHAREURL ?>/assets/downArrow.png" class="movedown" />
					</span>
				</div>
			<?php
			}
			?>
			<i> Note: WhatsApp works on mobile devices only!</i>
		</div>
		<div class="input_wrap input_wrap_sizes">
			<div class="sizes_table">
				<div class="heading2 none2">Sizes:</div>
				<div class="social_size social_size_new">
					<input <?php if( @in_array("lrg", $optns ) ) echo "checked"; ?> type="radio" name="soc-share-set[size]" value="lrg" id="lrg" />
					<label for="lrg"> Large	</label>
					<div class="img_social">
						<img src="<?php echo SOCSHAREURL ?>/assets/tray.png" class="large"/>
					</div>
				</div>
				<div class="social_size">
					<input <?php if( @in_array("mdm", $optns ) ) echo "checked"; ?> type="radio" name="soc-share-set[size]" value="mdm" id="mdm" />
					<label for="mdm">Medium</label>
					<div class="img_social">
						<img src="<?php echo SOCSHAREURL ?>/assets/tray.png" class="med"/>
						</div>
					</div>
					<div class="social_size">
						<input <?php if( @in_array("sml", $optns ) ) echo "checked"; ?> type="radio" name="soc-share-set[size]" value="sml" id="sml" />
						<label for="sml">Small</label>
						<div class="img_social">
							<img src="<?php echo SOCSHAREURL ?>/assets/tray.png" class="small"/>
						</div>
					</div>
				</div>
			</div>
			<div class="input_wrap">
				<div class="heading"> Colors: </div>
				<div class="color_div">
					<label for="color">Original </label>
					<input id="color" <?php if( @in_array("original", $optns ) ) echo "checked"; ?> type="checkbox" name="soc-share-set[color]" value="original"  />
					<span <?php if( @in_array("original", $optns ) ) echo "style='display:none'"; ?> class="row_hldr1">
						Custom <input readonly class="jscolor" onChange="ths=this; $('#customcolor').val(ths.value);" value="<?php echo $optns['customcolor'] ?>">
					</span>
					<input id="customcolor" type="hidden" value="<?php echo $optns['customcolor'] ?>" name="soc-share-set[customcolor]"/>
				</div>
			</div>
			<div class="input_wrap input_wrap_plcmnt">
				<div class="sizes_table2">
					<div class="heading full_width">Placement options: </div>
					<div class="box4_div">
						<div class="placement_div">
							&nbsp;&nbsp;<input <?php if( @in_array("dflt", $optns ) ) echo "checked"; ?> type="radio" name="soc-share-set[placement]" value="dflt" id="dflt" checked />
							<label for="dflt">Below Title (Default)</label>
							<img src="<?php echo SOCSHAREURL ?>/assets/belowtitle.png" class="placement" />
						</div>
						<div class="placement_div">
							&nbsp;&nbsp;<input <?php if( @in_array("left", $optns ) ) echo "checked"; ?> type="radio" name="soc-share-set[placement]" value="left" id="left" />
							<label for="left">Floating Left Area</label>
							<img src="<?php echo SOCSHAREURL ?>/assets/leftarea.png" class="placement" />
						</div>
						<div class="placement_div">
							&nbsp;&nbsp;<input <?php if( @in_array("aftrcntnt", $optns ) ) echo "checked"; ?> type="radio" name="soc-share-set[placement]" value="aftrcntnt" id="aftrcntnt" />
							<label for="aftrcntnt">After Content</label>
							&nbsp;&nbsp;<img src="<?php echo SOCSHAREURL ?>/assets/postcont.png" class="placement"/>
						</div>
						<div class="placement_div">						
							&nbsp;&nbsp;<input <?php if( @in_array("insdftrdimg", $optns ) ) echo "checked"; ?> type="radio" name="soc-share-set[placement]" value="insdftrdimg" id="insdftrdimg" />
							<label for="insdftrdimg">Inside Featured Image</label>
							<img src="<?php echo SOCSHAREURL ?>/assets/feat.png" class="placement" />
	 					<!--ethe-->
	 					</div>
	 				</div>
	 			</div>
				<i>Note: "Inside Featured Image" option only works with post having featured Image. Fallback is "Default"</i>
			</div>
		</div>
	<?php
}
function add_metas_soc_share( $post_id ){
	update_post_meta( $post_id, 'soc-share-global', sanitize_text_field( $_POST['soc-share-global'] ) );
	update_post_meta( $post_id, 'soc-share-set', serialize( $_POST['soc-share-set'] ) );
}
?>
