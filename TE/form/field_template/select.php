<fieldset>
	<label for="ID_[@@FieldName@@]">[@@FieldLabel@@]</label>
    <select name="[@@FieldName@@]" id="ID_[@@FieldName@@]" class="[@@FieldClass@@]" [@@FieldMultiple@@]>
    	<?php foreach($Field['Options'] as $Options):?>
        <option value="<?php echo $Options['value'] ?>"<?php if($Options['value'] == $Field['Value']): ?> selected="selected"<?php endif ?>><?php echo $Options['text'] ?></option>
        <?php endforeach ?>
    </select>
</fieldset>