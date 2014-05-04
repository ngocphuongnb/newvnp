<?php if(!class_exists('ntpl')){exit;}?><div id="Files_Container">
	<div id="File_Actions">
        <ul class="nav nav-pills">
        	<li class="disabled" id="AddToEditor"><a href=""><span class="glyphicon glyphicon-plus"></span>&nbsp;Add to editor</a></li>
            <li class="disabled" id="EditFile"><a href="" target="_blank"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a></li>
            <li class="disabled" id="DeleteFile"><a href="" target="_blank"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</a></li>
            <li class="disabled" id="OpenImageEditor"><a href="" target="_blank"><span class="glyphicon glyphicon-picture"></span>&nbsp;Open in image editor</a></li>
            <!--
            <li class="disabled"><a href="#">File manager featured</a></li>
            -->
            <li><a href="<?php  echo ADMIN_BASE;?>ajax/text/File/upload/"><span class="glyphicon glyphicon-upload"></span>&nbsp;Open uploader</a></li>
            <li><a href="#" title="Refresh" onclick="window.location=window.location;return false;"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh</a></li>
      	</ul>
        <?php echo $Page;?>
    </div>
    <div class="Main_Files" id="Main_Files">
        <?php $counter1=-1; if( isset($Files) && is_array($Files) && sizeof($Files) ) foreach( $Files as $key1 => $File ){ $counter1++; ?>
        <div class="Media_Item" id="Media_<?php echo $File["media_id"];?>" data-selected="0" data-file-id="<?php echo $File["media_id"];?>" data-file-location="<?php echo $UPLOAD_BASE;?><?php echo $File["media_name"];?>" data-file-alt="" data-file-title="">
            <div class="File_Thumbnail">
                <img class="media-object" src="<?php  echo SITE_BASE;?>Thumbnail/68_68<?php echo $UPLOAD_BASE;?><?php echo $File["media_name"];?>" />
            </div>
            <div class="File_Name"><?php echo $File["media_name"];?></div>
        </div>
        <?php } ?>
    </div>
</div>