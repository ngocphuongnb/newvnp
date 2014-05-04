<?php if(!class_exists('ntpl')){exit;}?><form class="form-horizontal" role="form" method="post" action="<?php  echo FILE_BASE;?>manage/edit/<?php echo $File["media_id"];?>/">
	<input name="FileID" value="<?php echo $File["media_id"];?>" type="hidden" />
    <!--
    <div class="form-group">
        <label for="File_name" class="col-sm-2 control-label">File name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" readonly="readonly" name="File[media_name]" id="File_name" value="<?php echo $File["media_name"];?>" placeholder="File name"/>
        </div>
    </div>
    -->
    <div class="form-group">
        <label for="File_title" class="col-sm-2 control-label">File title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="File[media_title]" id="File_title" value="<?php echo $File["media_title"];?>" placeholder="File title"/>
        </div>
    </div>
    <div class="form-group">
        <label for="File_alt" class="col-sm-2 control-label">File alt</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="File[media_alt]" id="File_alt" value="<?php echo $File["media_alt"];?>" placeholder="File alt"/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" name="SaveNodeTypeSubmit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>