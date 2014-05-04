<?php if(!class_exists('ntpl')){exit;}?><div id="File_Uploader">
    <form action="<?php  echo FILE_BASE;?>upload/" method="post" enctype="multipart/form-data">
        <input type="hidden" name="Upload_Form" value="1" />
        <input name="VNP_Files" id="Files_Input" type="file" />
        <div id="Files_Holder"></div>
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
    </form>
</div>
<div id="Upload_Progress" class="clearfix">
</div>
<style type="text/css">
.Single_Upload {
	cursor: pointer
}
</style>