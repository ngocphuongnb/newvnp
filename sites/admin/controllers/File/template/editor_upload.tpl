<div id="File_Actions">
    <ul class="nav nav-pills">
    	<li class="disabled" id="AddToEditor"><a href=""><span class="glyphicon glyphicon-plus"></span>&nbsp;Add to editor</a></li>
      	<li class="disabled" id="EditFile"><a href="" target="_blank"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a></li>
		<li class="disabled" id="DeleteFile"><a href="" target="_blank"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</a></li>
		<li class="disabled" id="OpenImageEditor"><a href="" target="_blank"><span class="glyphicon glyphicon-picture"></span>&nbsp;Open in image editor</a></li>
        <!--
        <li class="disabled"><a href="#">File manager featured</a></li>
        -->
        <li><a href="{#ADMIN_BASE}ajax/text/File/list_files/"><span class="glyphicon glyphicon-th"></span>&nbsp;Open file manager</a></li>
        <li><a href="#" title="Refresh" onclick="window.location=window.location;return false;"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh</a></li>
    </ul>
</div>
<div id="File_Uploader" class="Editor_Uploader">
    <form action="{#FILE_BASE}upload/" method="post" enctype="multipart/form-data">
        <input type="hidden" name="Upload_Form" value="1" />
        <div class="Upload_Sidebar">
        	<input name="VNP_Files" id="Files_Input" type="file" class="btn btn-success" />
            <button type="submit" name="Upload_Submiter" id="Start_Upload" class="btn btn-primary">
                <span class="glyphicon glyphicon-upload"></span>&nbsp;&nbsp;Upload
            </button>
            <button name="Pause_Resume" id="Pause_Resume" class="btn btn-warning">
                <span class="glyphicon glyphicon-pause"></span>&nbsp;&nbsp;Pause
            </button>
            <button name="Clear_Form" id="Clear_Form" class="btn btn-info">
                <span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;Reset
            </button>
            <button name="Cancel_Upload" id="Cancel_Upload" class="btn btn-danger">
                <span class="glyphicon glyphicon-ban-circle"></span>&nbsp;&nbsp;Cancel
            </button>
            <button name="Debug" id="Debug" class="btn btn-default">
                Debug
            </button>
       	</div>
        <div class="Uploader_Content">
        	<div id="Files_Holder"></div>
            <div id="Upload_Progress" class="clearfix">
			</div>
     	</div>
    </form>
</div>
<script type="text/javascript">
	var IsEditorUpload = true;
</script>