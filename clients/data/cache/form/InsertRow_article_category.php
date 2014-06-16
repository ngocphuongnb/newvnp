<?php $Field = $Vars['var1']; ?>
<div class="form-group FieldWrap FieldType_text Field_title RequiredField">
	<label class="col-sm-2 control-label" for="ID_Field[title]">Title<span class="RequireField">*</span></label>
    <div class="col-sm-10">
		<input type="text" name="Field[title]" id="ID_Field[title]" class="form-control FieldType_text Field_title RequiredField" value="<?php echo $FormValue['Field[title]']['value'] ?>" />
 	</div>
</div>
<?php $Field = $Vars['var2']; ?>
<div class="form-group FieldWrap FieldType_url Field_url RequiredField">
	<label class="col-sm-2 control-label" for="ID_Field[url]">Url<span class="RequireField">*</span></label>
    <div class="col-sm-10">
		<input type="" name="Field[url]" id="ID_Field[url]" class="form-control FieldType_url Field_url RequiredField" value="<?php echo $FormValue['Field[url]']['value'] ?>" />
 	</div>
</div>
<?php $Field = $Vars['var3']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[description]">Description</label>
    <div class="col-sm-10">
    	<textarea name="Field[description]" id="ID_Field[description]" class="form-control FieldType_textarea Field_description"><?php echo $Field['Value'] ?></textarea>
        
  	</div>
</div>
<?php $Field = $Vars['var4']; ?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="ID_Field[parent_category]">Parent category</label>
    <div class="col-sm-10">
        <select name="Field[parent_category]" id="ID_Field[parent_category]" class="form-control FieldType_referer Field_parent_category" >
            <?php foreach($Field['Options'] as $Options):?>
			<option value="<?php echo $Options['value'] ?>"<?php if($Options['value'] == $Field['Value']): ?> selected="selected"<?php endif ?>><?php echo $Options['text'] ?></option>
			<?php endforeach ?>
        </select>
    </div>
</div>
