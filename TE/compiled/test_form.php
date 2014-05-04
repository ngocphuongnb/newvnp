<?php $Field = $Vars['var1']; ?>
<fieldset>
	<label for="ID_name1">Text field 1</label>
    <input type="text" name="name1" id="ID_name1" class="" value="<?php echo $Field['Value'] ?>" />
</fieldset>
<?php $Field = $Vars['var2']; ?>
<fieldset>
	<label for="ID_name2">Text field 2</label>
    <input type="text" name="name2" id="ID_name2" class="" value="<?php echo $Field['Value'] ?>" />
</fieldset>
<?php $Field = $Vars['var3']; ?>
<fieldset>
	<label for="ID_name3">Text field 3</label>
    <input type="text" name="name3" id="ID_name3" class="" value="<?php echo $Field['Value'] ?>" />
</fieldset>
<?php $Field = $Vars['var4']; ?>
<fieldset>
	<label for="ID_name4">Select field 4</label>
    <select name="name4" id="ID_name4" class="" >
    	<?php foreach($Field['Options'] as $Options):?>
        <option value="<?php echo $Options['value'] ?>"<?php if($Options['value'] == $Field['Value']): ?> selected="selected"<?php endif ?>><?php echo $Options['text'] ?></option>
        <?php endforeach ?>
    </select>
</fieldset>
<?php $Field = $Vars['var5']; ?>
<fieldset>
	<label for="ID_name5">Radio field 5</label>
    
		<?php foreach($Field['Options'] as $Options):?>
		<label for="ID_<?php echo $Field['Name'] ?>_<?php echo $Options['value'] ?>">
			<input type="radio" name="<?php echo $Field['Name'] ?>" id="ID_<?php echo $Field['Name'] ?>_<?php echo $Options['value'] ?>" class="<?php echo $Field['Class'] ?>" value="<?php echo $Options['value'] ?>"<?php if($Options['value'] == $Field['Value']): ?> checked="checked"<?php endif ?>/>
			<?php echo $Options['text'] ?>
		</label>
		<?php endforeach ?>
</fieldset>
<?php $Field = $Vars['var6']; ?>
<fieldset>
	<label for="ID_name6">Checkbox field 6</label>
    
		<?php foreach($Field['Options'] as $Options):?>
		<label for="ID_<?php echo $Field['Name'] ?>_<?php echo $Options['value'] ?>">
			<input type="checkbox" name="<?php echo $Field['Name'] ?>[]" id="ID_<?php echo $Field['Name'] ?>_<?php echo $Options['value'] ?>" class="<?php echo $Field['Class'] ?>" value="<?php echo $Options['value'] ?>"<?php if($Options['value'] == $Field['Value']): ?> checked="checked"<?php endif ?>/>
			<?php echo $Options['text'] ?>
		</label>
		<?php endforeach ?>
</fieldset>
<?php $Field = $Vars['var7']; ?>
<fieldset>
	<label for="ID_name7">File field 7</label>
    <input type="file" name="name7" id="ID_name7" class=""/>
</fieldset>
<?php $Field = $Vars['var8']; ?>
<fieldset>
	<label for="ID_name8">Image</label>
    <input type="file" name="name8" id="ID_name8" class=""/>
    <div class="FieldImagePreviewer"></div>
</fieldset>
<?php $Field = $Vars['var9']; ?>
<fieldset>
	<label for="ID_name9">Save</label>
	<button name="name9" id="ID_name9" class=""><?php echo $Field['Value'] ?></button>
</fieldset>
