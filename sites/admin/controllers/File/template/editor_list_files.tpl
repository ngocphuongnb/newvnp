<div id="Files_Container">
	<div id="File_Actions">
        <ul class="nav nav-pills">
        	<li class="disabled" id="AddToEditor"><a href=""><span class="glyphicon glyphicon-plus"></span>&nbsp;Add to editor</a></li>
            <li class="disabled" id="EditFile"><a href="" target="_blank"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a></li>
            <li class="disabled" id="DeleteFile"><a href="" target="_blank"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</a></li>
            <li class="disabled" id="OpenImageEditor"><a href="" target="_blank"><span class="glyphicon glyphicon-picture"></span>&nbsp;Open in image editor</a></li>
            <!--
            <li class="disabled"><a href="#">File manager featured</a></li>
            -->
            <li><a href="{#ADMIN_BASE}ajax/text/File/upload/"><span class="glyphicon glyphicon-upload"></span>&nbsp;Open uploader</a></li>
            <li><a href="#" title="Refresh" onclick="window.location=window.location;return false;"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh</a></li>
      	</ul>
        {$Page}
    </div>
    <div class="Main_Files" id="Main_Files">
        {for $File in $Files}
        <div class="Media_Item" id="Media_{$File.media_id}" data-selected="0" data-file-id="{$File.media_id}" data-file-location="{$UPLOAD_BASE}{$File.media_name}" data-file-alt="" data-file-title="">
            <div class="File_Thumbnail">
                <img class="media-object" src="{#SITE_BASE}Thumbnail/68_68{$UPLOAD_BASE}{$File.media_name}" />
            </div>
            <div class="File_Name">{$File.media_name}</div>
        </div>
        {/for}
    </div>
</div>