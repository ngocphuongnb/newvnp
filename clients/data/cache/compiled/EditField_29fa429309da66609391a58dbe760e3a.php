<div class="table-responsive">
	<form method="post" role="form">
    	<input type="hidden" name="edit_field" value="1" />
        <input type="hidden" name="field_name" value="<?php echo $NodeField['name'] ?>" />
        <table class="table table-bordered table-striped table-hover">
            <colgroup>
            <col class="col-xs-2">
            <col class="col-xs-6">
            <col class="col-xs-2">
            </colgroup>
            <thead>
                <tr>
                    <th style="width: 30px"><strong>IF</strong></th>
                    <th style="width: 155px"><strong>Label</strong></th>
                    <th style="width: 155px"><strong>Name</strong></th>
                    <th style="width: 130px"><strong>Type</strong></th>
                    <th style="width: 30px"><strong>R</strong></th>
                    <th style="width: 155px"><strong>Filter</strong></th>
                    <th style="width: 155px"><strong>Default value</strong></th>
                    <th style="width: 155px"><strong>DB Type</strong></th>
                    <th style="width: 155px"><strong>DB Length</strong></th>
                    <th style="width: 155px"><strong>Collation</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>       
                	<td>
                    	<input name="Field[inform]"<?php if($NodeField['inform'] > 0) { ?> checked="cheched"<?php } ?> id="FieldInForm" type="checkbox" value="1" />
                  	</td>
                	<td>
                    	<input name="Field[label]" value="<?php echo $NodeField['label'] ?>" type="text" class="form-control" id="FieldLabel" placeholder="Field label">
                  	</td>
                    <td>
                    	<input name="Field[name]" value="<?php echo $NodeField['name'] ?>" type="text" class="form-control" id="FieldName" placeholder="Field name">
                  	</td>
                    <td>
                    <select name="Field[type]" class="form-control" id="FieldType">
                        <option<?php if($NodeField['type'] == 'text') { ?> selected="selected"<?php } ?> value="text">Text</option>
                        <option<?php if($NodeField['type'] == 'textarea') { ?> selected="selected"<?php } ?> value="textarea">Textarea</option>
                        <option<?php if($NodeField['type'] == 'html') { ?> selected="selected"<?php } ?> value="html">Html</option>
                        <option<?php if($NodeField['type'] == 'selectbox') { ?> selected="selected"<?php } ?> value="selectbox">Selectbox</option>
                        <option<?php if($NodeField['type'] == 'hidden') { ?> selected="selected"<?php } ?> value="hidden">Hidden</option>
                    </select>
                  	</td>
                    <td>
                    	<input name="Field[require]"<?php if($NodeField['require'] > 0) { ?> checked="cheched"<?php } ?> id="FieldRequire" type="checkbox" value="1" />
                  	</td>
                    <td>
                    	<input name="Field[filter]" value="<?php echo $NodeField['filter'] ?>" type="text" class="form-control" id="FieldFilter" placeholder="Field filter">
                  	</td>
                    <td>
                    	<input name="Field[value]" value="<?php echo $NodeField['value'] ?>" type="text" class="form-control" id="FieldValue" placeholder="Default value">
                  	</td>
                    <td>
                    	<select name="Field[db_type]" class="form-control" id="FieldDBType">
                        	<?php foreach($DBFieldTypes['global'] as $db_opval) { ?>
                        	<option value="<?php echo $db_opval ?>"<?php if(isset($NodeField['db_config']['type']) && strtoupper($NodeField['db_config']['type']) == strtoupper($db_opval)) { ?> selected="selected"<?php } ?>><?php echo $db_opval ?></option>
                            <?php } ?>
                            <optgroup label="Numeric">
                                <?php foreach($DBFieldTypes['Numeric'] as $db_opval) { ?>
                        		<option value="<?php echo $db_opval ?>"<?php if(isset($NodeField['db_config']['type']) && strtoupper($NodeField['db_config']['type']) == strtoupper($db_opval)) { ?> selected="selected"<?php } ?>><?php echo $db_opval ?></option>
                            	<?php } ?>
                            </optgroup>
                            <optgroup label="Date and time">
                                <?php foreach($DBFieldTypes['DateTime'] as $db_opval) { ?>
                        		<option value="<?php echo $db_opval ?>"<?php if(isset($NodeField['db_config']['type']) && strtoupper($NodeField['db_config']['type']) == strtoupper($db_opval)) { ?> selected="selected"<?php } ?>><?php echo $db_opval ?></option>
                            	<?php } ?>
                        	</optgroup>
                          	<optgroup label="String">
                                <?php foreach($DBFieldTypes['String'] as $db_opval) { ?>
                        		<option value="<?php echo $db_opval ?>"<?php if(isset($NodeField['db_config']['type']) && strtoupper($NodeField['db_config']['type']) == strtoupper($db_opval)) { ?> selected="selected"<?php } ?>><?php echo $db_opval ?></option>
                            	<?php } ?>
                            </optgroup>
                          	<optgroup label="Spatial">
                                <?php foreach($DBFieldTypes['Spatial'] as $db_opval) { ?>
                        		<option value="<?php echo $db_opval ?>"<?php if(isset($NodeField['db_config']['type']) && strtoupper($NodeField['db_config']['type']) == strtoupper($db_opval)) { ?> selected="selected"<?php } ?>><?php echo $db_opval ?></option>
                            	<?php } ?>
                            </optgroup>
                        </select>
                  	</td>
                    <td>
                    	<input name="Field[db_length]" type="text" class="form-control" id="FieldDBLength" placeholder="DB Length">
                  	</td>
                    <td>
                    	<select name="Field[db_collation]" class="form-control" id="FieldDBCollation">
                        	<optgroup label="utf8">
                            	<?php foreach($DBCollations['utf8'] as $DB_collation) { ?>
                                <option<?php if(isset($NodeField['db_config']['collation']) && strtoupper($NodeField['db_config']['collation']) == strtoupper($DB_collation)) { ?> selected="selected"<?php } ?> value="<?php echo $DB_collation ?>"><?php echo $DB_collation ?></option>
                                <?php } ?>
                            </optgroup>
                        </select>
                 	</td>
                </tr>
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="10">
                    	<span class="label label-warning" style="font-size: 13px">Edit field <?php echo $NodeField['label'] ?></span>&nbsp;
                        <span class="label label-info" style="font-size: 13px">Node type <?php echo $NodeTypeName ?></span>&nbsp;
                    	<button type="button" onClick="window.history.go(-1)" class="btn btn-default">Cancel</button>
                    	<button type="submit" class="btn btn-primary">Save</button>
                    </td>
              	</tr>
            </tfoot>
        </table>
   	</form>
</div>