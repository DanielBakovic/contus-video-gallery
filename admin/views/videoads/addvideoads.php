<?php
/*
  Name: Wordpress Video Gallery
  Plugin URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery
  Description: Add video ads view file.
  Version: 2.6
  Author: Apptha
  Author URI: http://www.apptha.com
  License: GPL2
 */
?>
<?php
$dir = dirname( plugin_basename( __FILE__ ) );
$dirExp     = explode( '/', $dir );
$dirPage    = $dirExp[0];
$image_path = str_replace( 'plugins/' . $dirPage . '/', 'uploads/videogallery/', APPTHA_VGALLERY_BASEURL );
?>
<script type="text/javascript">
	folder = '<?php echo balanceTags( $dirPage ); ?>'
</script>
<div class="apptha_gallery">
	<?php if ( isset( $videoadId ) ) {
		?>
		<h2 class="option_title"><?php esc_attr_e( 'Update Video Ad', 'video_gallery' ); ?></h2> <?php } else {
		?> <h2  class="option_title"><?php echo '<img src="' . APPTHA_VGALLERY_BASEURL . 'images/vid_ad.png" alt="move" width="30"/>'; ?><?php esc_attr_e( 'Add New Video Ad', 'video_gallery' ); ?></h2> <?php } ?>
	<?php if ( isset( $msg ) ): ?>
		<div class="updated below-h2">
			<p>
				<?php
				echo balanceTags( $msg );
				$url = get_bloginfo( 'url' ) . '/wp-admin/admin.php?page=videoads';
				echo '<a href="'.$url.'" >Back to VideoAds</a>';
				?>
			</p>
		</div>
	<?php endif; ?>
<?php
if ( isset( $videoadEdit->file_path ) && ! strstr( $videoadEdit->file_path, 'wp-content/uploads' ) ) {
	$uploaded_video = 0;
} else {
	$uploaded_video = 1;
}
?>

	<div id="post-body" class="has-sidebar">
		<div id="post-body-content" class="has-sidebar-content">
			<div class="stuffbox">


				<h3 class="hndle videoform_title">
					<span>
						<input type="radio" name="videoadtype" id="prepostroll" value="1" <?php if ( isset( $videoadEdit ) && $videoadEdit->admethod == 'prepost' ) { echo 'checked="checked" '; } ?> onClick="Videoadtype( 'prepostroll' )"/> Pre-roll/Post-roll Ad
					</span>
					<span>
						<input type="radio" name="videoadtype" id="midroll" value="2" <?php if ( isset( $videoadEdit ) && $videoadEdit->admethod == 'midroll' ) { echo 'checked="checked" '; } ?> onClick="Videoadtype( 'midroll' )" />  Mid-roll Ad
					</span>
					<span>
						<input type="radio" name="videoadtype" id="imaad" value="3" <?php if ( isset( $videoadEdit ) && $videoadEdit->admethod == 'imaad' ) { echo 'checked="checked" '; } ?> onClick="Videoadtype( 'imaad' )" />  IMA Ad
					</span>
				</h3>
				<table class="form-table">
					<tr id="videoadmethod" name="videoadmethod">
						<td  width="150"><?php esc_attr_e( 'Select file type', 'video_gallery' ) ?></td>
						<td>
							<input type="radio" name="videoad" id="filebtn" value="1" onClick="Videoadtypemethod( 'fileuplo' );" /> File
							<input type="radio" name="videoad" id="urlbtn" value="2" onClick="Videoadtypemethod( 'urlad' );" />  URL
						</td>
					</tr>
				</table>
				<div id="upload2" class="form-table">

					<table class="form-table">

						<tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1">
							<td  width="150"><?php esc_attr_e( 'Upload Video', 'video_gallery' ) ?></td>
							<td>
								<div id="f1-upload-form" >
									<form name="normalvideoform" method="post" enctype="multipart/form-data" >
										<input type="file" name="myfile" onchange="enableUpload( this.form.name );" />
										<input type="button" class="button" name="uploadBtn" value="<?php esc_attr_e( 'Upload Video', 'video_gallery' ) ?>" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" />
										<input type="hidden" name="mode" value="video" />
										<label id="lbl_normal"><?php 
if ( isset( $videoadEdit->file_path ) && $uploaded_video == 1 ) {
	$file_path = str_replace( $image_path, '', $videoadEdit->file_path );
} else  {
		$file_path = '';
}
	echo balanceTags( $file_path ); ?>
										</label>
									</form>
									<?php esc_attr_e( '<b>Supported video formats:</b>(  MP4, M4V, M4A, MOV, Mp4v or F4V )', 'video_gallery' ) ?>
								</div>
								<span id="uploadmessage" style="display: block; margin-top:10px;margin-left:300px;color:red;font-size:12px;font-weight:bold;"></span>
								<div id="f1-upload-progress" style="display:none">
									<div style="float:left"><img id="f1-upload-image" src="<?php echo balanceTags( get_option( 'siteurl' ) ) . '/wp-content/plugins/' . $dirPage . '/images/empty.gif' ?>" alt="Uploading"  style="padding-top:2px"/>
										<label style="padding-top:0px;padding-left:4px;font-size:14px;font-weight:bold;vertical-align:top"  id="f1-upload-filename">PostRoll.flv</label></div>
									<div style="float:right"> <span id="f1-upload-cancel">
											<a style="float:right;padding-right:10px;" href="javascript:cancelUpload( 'normalvideoform' );" name="submitcancel">Cancel</a>
										</span>
										<label id="f1-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
										<span id="f1-upload-message" style="float:right;font-size:10px;background:#FFAFAE;">
											<b><?php esc_attr_e( 'Upload Failed:', 'video_gallery' ) ?></b> <?php esc_attr_e( 'User Cancelled the upload', 'video_gallery' ) ?>
										</span></div>
								</div>
								<div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
								<span id="filepathuploaderrormessage" style="display: block;color:red; "></span>
							</td></tr>
					</table>
				</div>
				<form action="" name="videoadsform" class="videoform" method="post" enctype="multipart/form-data"  >
					<div id="videoadurl" style="display: none;" >
						<table class="form-table">
							<tr>
								<td scope="row"  width="150"><?php esc_attr_e( 'Video Ad URL', 'video_gallery' ) ?></td>
								<td>
									<input type="text" size="50" onchange="clear_upload();" onkeyup="validateerrormsg();" name="videoadfilepath" id="videoadfilepath"  value="
<?php 
if ( isset( $videoadEdit->file_path ) ) {
	$file_path_url = $videoadEdit->file_path; 
} else {
	$file_path_url = '';
}
echo balanceTags( $file_path_url );
?>
										   "  />&nbsp;&nbsp
									<br /><?php esc_attr_e( 'Here you need to enter the video ad URL', 'video_gallery' ) ?>
									<br /><?php esc_attr_e( 'It accept also a Youtube link : http://www.youtube.com/watch?v=tTGHCRUdlBs', 'video_gallery' ) ?>
									<span id="filepatherrormessage" style="display: block;color:red; "></span>
								</td>
							</tr>
						</table>
					</div>
					<table id="videoimaaddetails" style="display: none;" class="form-table">
						<tr>
							<td scope="row"  width="150"><?php esc_attr_e( 'IMA Ad Type', 'video_gallery' ) ?></td>
							<td>
								<input type="radio" name="imaadType" id="imaadTypetext" onclick="changeimaadtype( 'textad' );" value="1" <?php if ( isset( $videoadEdit->imaadType ) && $videoadEdit->imaadType == 1 ) { echo 'checked'; } ?>><label>Text/Overlay</label>
								<input type="radio" name="imaadType" id="imaadTypevideo" onclick="changeimaadtype( 'videoad' );" value="0"  <?php if ( isset( $videoadEdit->imaadType ) && $videoadEdit->imaadType == 0 ) { echo 'checked'; } ?>><label>Video</label>
						</tr>
						<tr id="adimapath" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'IMA Ad Path', 'video_gallery' ) ?></td>
							<td>
								<input type="text" size="50" onkeyup="validateerrormsg();" name="imaadpath" id="imaadpath" value="<?php if ( isset( $videoadEdit->imaadpath ) ) { echo balanceTags( $videoadEdit->imaadpath ); } else { echo ''; } ?>" />
								<span id="imaadpatherrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
						<tr id="adimawidth" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Ad Slot Width', 'video_gallery' ) ?></td>
							<td>
								<input type="text" size="50" name="videoimaadwidth" id="adwidth" value="<?php 
if ( isset( $videoadEdit->imaadwidth ) ) {
	$imaadwidth = $videoadEdit->imaadwidth;
} else {
	$imaadwidth = '';
}
								echo balanceTags( $imaadwidth ); 
								?>"  />
							</td>
						</tr>
						<tr id="adimaheight" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Ad Slot Height', 'video_gallery' ) ?></td>
							<td>
								<input type="text" size="50" name="videoimaadheight" id="adheight" value="<?php 
if ( isset( $videoadEdit->imaadheight ) ) {
	$imaadheight = $videoadEdit->imaadheight; 
} else {
	$imaadheight = '';
}
									echo balanceTags( $imaadheight );
									?>"  />
							</td>
						</tr>
						<tr id="adimapublisher" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Publisher ID', 'video_gallery' ) ?></td>
							<td><input type="text" size="50" onkeyup="validateerrormsg();" name="publisherId" id="publisherId" value="<?php 
if ( isset( $videoadEdit->publisherId ) ) {
	$publisherId = $videoadEdit->publisherId; 
} else {
	$publisherId = '';
}
							echo balanceTags( $publisherId );
							?>" />
								<span id="imapublisherIderrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
						<tr id="adimacontentid" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Content ID', 'video_gallery' ) ?></td>
							<td><input type="text" size="50" name="contentId" onkeyup="validateerrormsg();" id="contentId" value="<?php 
if ( isset( $videoadEdit->contentId ) ) {
	$contentId = $videoadEdit->contentId; 
} else {
	$contentId = '';
}
							echo balanceTags( $contentId );
							?>" />
								<span id="imacontentIderrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>

						<tr id="adimachannels" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Channels', 'video_gallery' ) ?></td>
							<td><input type="text" size="50" onkeyup="validateerrormsg();" name="channels" id="channels" value="<?php 
if ( isset( $videoadEdit->channels ) ) {
	$channels = $videoadEdit->channels; 
} else {
	$channels = '';
}
							echo balanceTags( $channels );
							?>" />
								<span id="imachannelserrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
					</table>
					<table id="videoaddetails" style="display: none;" class="form-table">
						<tr id="adtitle"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Title / Name', 'video_gallery' ) ?></td>
							<td>
								<input type="text" size="50" onkeyup="validateerrormsg();" maxlength="200" name="videoadname" id="name" value="<?php 
if ( isset( $videoadEdit->title ) ) {
	$title = $videoadEdit->title; 
} else {
	$title = '';
}
								echo balanceTags( $title );
								?>"  />
								<span id="nameerrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
						<tr id="addescription"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Description', 'video_gallery' ) ?></td>
							<td>
								<input type="text" size="50" name="description" id="description" value="<?php 
if ( isset( $videoadEdit->description ) ) {
	$description = $videoadEdit->description;
} else {
	$description = '';
}
								echo balanceTags( $description );
								?>"  />
							</td>
						</tr>
						<tr id="adtargeturl"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Target URL', 'video_gallery' ) ?></td>
							<td>
								<input type="text" size="50" name="targeturl" id="targeturl" value="<?php 
if ( isset( $videoadEdit->targeturl ) ) {
	$targeturl = $videoadEdit->targeturl; 
} else {
	$targeturl = '';
}
								echo balanceTags( $targeturl );
								?>" />
								<span id="targeterrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
						<tr id="adclickurl"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Click Hits URL', 'video_gallery' ) ?></td>
							<td><input type="text" size="50" name="clickurl" id="clickurl" value="<?php 
if ( isset( $videoadEdit->clickurl ) ) {
	$clickurl = $videoadEdit->clickurl; 
} else {
	$clickurl = '';
}
							echo balanceTags( $clickurl );
							?>" />
								<span id="clickerrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
						<tr  id="adimpresurl"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Impression Hits URL', 'video_gallery' ) ?></td>
							<td><input type="text" size="50" name="impressionurl" id="impressionurl" value="<?php 
if ( isset( $videoadEdit->impressionurl ) ) {
	$impressionurl = $videoadEdit->impressionurl; 
} else {
	$impressionurl = '';
}
							echo balanceTags( $impressionurl );
							?>" />
								<span id="impressionerrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
					</table>



					<table class="form-table add_video_publish">
						<tr>
							<td scope="row" width="150"><?php esc_attr_e( 'Publish', 'video_gallery' ) ?></td>
							<td class="checkbox">
								<input type="radio" name="videoadpublish"  value="1" <?php if ( isset( $videoadEdit->publish ) ) { echo 'checked'; } ?>><label>Yes</label>
								<input type="radio" name="videoadpublish" value="0"  <?php if ( ! isset( $videoadEdit->publish ) ) { echo 'checked'; } ?>><label>No</label>
							</td>
						</tr>
					</table>

<?php if ( isset( $videoadId ) ) { ?>
						<input type="submit" name="videoadsadd" class="button-primary" onclick="return validateadInput();"  value="<?php esc_attr_e( 'Update Video Ad', 'video_gallery' ); ?>" class="button" /> <?php } else { ?> <input type="submit" name="videoadsadd" class="button-primary" onclick="return validateadInput();" value="<?php esc_attr_e( 'Add Video Ad', 'video_gallery' ); ?>" class="button" /> <?php } ?>
					<input type="button" onclick="window.location.href = 'admin.php?page=videoads'" class="button-secondary" name="cancel" value="<?php esc_attr_e( 'Cancel' ); ?>" class="button" />
					<input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="<?php if ( isset( $videoadEdit->file_path ) && $uploaded_video == 1 ) { echo balanceTags( str_replace( $image_path, '', $videoadEdit->file_path ) ); } else { echo ''; } ?>"  />
					<input type="hidden" name="admethod" id="admethod" value="<?php 
if ( isset( $videoadEdit->admethod ) ) {
	$admethod = $videoadEdit->admethod; 
} else {
	$admethod = '';
}
					echo balanceTags( $admethod );
					?>"  />
					<input type="hidden" name="adtype" id="adtype" value="<?php 
if ( isset( $videoadEdit->adtype ) ) {
	$adtype = $videoadEdit->adtype; 
} else {
	$adtype = '';
}
					echo balanceTags( $adtype );
					?>"  />
				</form>

			</div>
		</div>
	</div>
	<script type="text/javascript">
<?php
if ( isset( $videoadEdit->file_path ) && $uploaded_video == 1 ) {
	?>
			document.getElementById( "filebtn" ).checked = true;
			Videoadtypemethod( 'fileuplo' );
	<?php
} else {
	?>
			document.getElementById( "urlbtn" ).checked = true;
			Videoadtypemethod( 'urlad' );
	<?php
}
if ( isset( $videoadEdit->admethod ) && $videoadEdit->admethod == 'midroll' ) {
	?>
			document.getElementById( "midroll" ).checked = true;
			Videoadtype( 'midroll' );
	<?php
} else if ( isset( $videoadEdit->admethod ) && $videoadEdit->admethod == 'imaad' ) {
	?>
			document.getElementById( "imaad" ).checked = true;
			Videoadtype( 'imaad' );
	<?php
} else {
	?>
			document.getElementById( "prepostroll" ).checked = true;
			Videoadtype( 'prepostroll' );
	<?php
}
if ( ! empty( $videoadEdit->imaadpath ) ) {
	?> changeimaadtype( 'videoad' );<?php
} else {
	?> changeimaadtype( 'textad' ); <?php
}
?>
	</script>
</div>