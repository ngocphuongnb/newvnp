<?php $Field = $Vars['var1']; ?>
<div class="form-group FieldWrap FieldType_text Field_title RequiredField">
	<label class="col-sm-2 control-label" for="ID_Field[title]">Title<span class="RequireField">*</span></label>
    <div class="col-sm-10">
		<input type="text" name="Field[title]" id="ID_Field[title]" class="form-control FieldType_text Field_title RequiredField" value="<?php echo $Field['Value'] ?>" />
 	</div>
</div>
<?php $Field = $Vars['var2']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[category]">Category</label>
    <div class="col-sm-10">
        <select name="Field[category]" id="ID_Field[category]" multiple="multiple" class="form-control FieldType_referer Field_category" >
            <?php $ArrValue = explode(',',$Field['Value']); foreach($Field['Options'] as $Options):?>
			<option value="<?php echo $Options['value'] ?>"<?php if(in_array($Options['value'],$ArrValue)): ?> selected="selected"<?php endif ?>><?php echo $Options['text'] ?></option>
			<?php endforeach ?>
        </select>
    </div>
</div>
<?php $Field = $Vars['var3']; ?>
<div class="form-group FieldWrap FieldType_url Field_url RequiredField">
	<label class="col-sm-2 control-label" for="ID_Field[url]">Url<span class="RequireField">*</span></label>
    <div class="col-sm-10">
		<input type="" name="Field[url]" id="ID_Field[url]" class="form-control FieldType_url Field_url RequiredField" value="<?php echo $Field['Value'] ?>" />
 	</div>
</div>
<?php $Field = $Vars['var4']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[description]">Description<span class="RequireField">*</span></label>
    <div class="col-sm-10">
    	<textarea name="Field[description]" id="ID_Field[description]" class="form-control FieldType_textarea Field_description RequiredField"><?php echo $Field['Value'] ?></textarea>
        
  	</div>
</div>
<?php $Field = $Vars['var5']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[body]">Content<span class="RequireField">*</span></label>
    <div class="col-sm-10">
    	<textarea name="Field[body]" id="ID_Field[body]" class="form-control FieldType_html Field_body RequiredField"><?php echo $Field['Value'] ?></textarea>
        
  	</div>
</div>
<?php $Field = $Vars['var6']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[status]">Status</label>
    <div class="col-sm-10">
        <select name="Field[status]" id="ID_Field[status]" class="form-control FieldType_single_value Field_status" >
            <option value="0"<?php if('0' == $Field['Value']): ?> selected="selected"<?php endif ?>>Draft</option>
<option value="1"<?php if('1' == $Field['Value']): ?> selected="selected"<?php endif ?>>Publish</option>
<option value="2"<?php if('2' == $Field['Value']): ?> selected="selected"<?php endif ?>>Pending</option>
        </select>
    </div>
</div>
<?php $Field = $Vars['var7']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[author]">Color</label>
    <div class="col-sm-10">
        <select name="Field[author]" id="ID_Field[author]" class="form-control FieldType_single_value Field_author" >
            <option value="red"<?php if('red' == $Field['Value']): ?> selected="selected"<?php endif ?>>Red</option>
        </select>
    </div>
</div>
<?php $Field = $Vars['var8']; ?>
<div class="form-group FieldWrap FieldType_text Field_new_field">
	<label class="col-sm-2 control-label" for="ID_Field[new_field]">New Field</label>
    <div class="col-sm-10">
		<input type="text" name="Field[new_field]" id="ID_Field[new_field]" class="form-control FieldType_text Field_new_field" value="<?php echo $Field['Value'] ?>" />
 	</div>
</div>
<?php $Field = $Vars['var9']; ?>
<div class="form-group FieldWrap FieldType_file Field_image">
	<label class="col-sm-2 control-label" for="ID_Field[image]">Image</label>
    <div class="col-sm-10">
		<input type="file" name="Field[image]" id="ID_Field[image]" class="form-control FieldType_file Field_image" value="<?php echo $Field['Value'] ?>" />
 	</div>
</div>
<?php $Field = $Vars['var10']; ?>
<div class="form-group FieldWrap FieldType_text Field_source">
	<label class="col-sm-2 control-label" for="ID_Field[source]">source</label>
    <div class="col-sm-10">
		<input type="text" name="Field[source]" id="ID_Field[source]" class="form-control FieldType_text Field_source" value="<?php echo $Field['Value'] ?>" />
 	</div>
</div>
<?php $Field = $Vars['var11']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[main_catid]">Main category</label>
    <div class="col-sm-10">
        <select name="Field[main_catid]" id="ID_Field[main_catid]" class="form-control FieldType_referer Field_main_catid" >
            <?php foreach($Field['Options'] as $Options):?>
			<option value="<?php echo $Options['value'] ?>"<?php if($Options['value'] == $Field['Value']): ?> selected="selected"<?php endif ?>><?php echo $Options['text'] ?></option>
			<?php endforeach ?>
        </select>
    </div>
</div>
