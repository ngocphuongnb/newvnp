<div class="table-responsive">
	<form method="post" role="form">
    	<input type="hidden" name="edit_field" value="1" />
        <input type="hidden" name="field_name" value="{$NodeField.name}" />
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
                    	<input name="Field[inform]"{if($NodeField.inform > 0)} checked="cheched"{/if} id="FieldInForm" type="checkbox" value="1" />
                  	</td>
                	<td>
                    	<input name="Field[label]" value="{$NodeField.label}" type="text" class="form-control" id="FieldLabel" placeholder="Field label">
                  	</td>
                    <td>
                    	<input name="Field[name]" value="{$NodeField.name}" type="text" class="form-control" id="FieldName" placeholder="Field name">
                  	</td>
                    <td>
                    <select name="Field[type]" class="form-control" id="FieldType">
                        <option{if($NodeField.type == 'text')} selected="selected"{/if} value="text">Text</option>
                        <option{if($NodeField.type == 'textarea')} selected="selected"{/if} value="textarea">Textarea</option>
                        <option{if($NodeField.type == 'html')} selected="selected"{/if} value="html">Html</option>
                        <option{if($NodeField.type == 'selectbox')} selected="selected"{/if} value="selectbox">Selectbox</option>
                        <option{if($NodeField.type == 'hidden')} selected="selected"{/if} value="hidden">Hidden</option>
                    </select>
                  	</td>
                    <td>
                    	<input name="Field[require]"{if($NodeField.require > 0)} checked="cheched"{/if} id="FieldRequire" type="checkbox" value="1" />
                  	</td>
                    <td>
                    	<input name="Field[filter]" value="{$NodeField.filter}" type="text" class="form-control" id="FieldFilter" placeholder="Field filter">
                  	</td>
                    <td>
                    	<input name="Field[value]" value="{$NodeField.value}" type="text" class="form-control" id="FieldValue" placeholder="Default value">
                  	</td>
                    <td>
                    	<select name="Field[db_type]" class="form-control" id="FieldDBType">
                        	{for $db_opval in $DBFieldTypes.global}
                        	<option value="{$db_opval}"{if(isset($NodeField.db_config.type) && strtoupper($NodeField.db_config.type) == strtoupper($db_opval))} selected="selected"{/if}>{$db_opval}</option>
                            {/for}
                            <optgroup label="Numeric">
                                {for $db_opval in $DBFieldTypes.Numeric}
                        		<option value="{$db_opval}"{if(isset($NodeField.db_config.type) && strtoupper($NodeField.db_config.type) == strtoupper($db_opval))} selected="selected"{/if}>{$db_opval}</option>
                            	{/for}
                            </optgroup>
                            <optgroup label="Date and time">
                                {for $db_opval in $DBFieldTypes.DateTime}
                        		<option value="{$db_opval}"{if(isset($NodeField.db_config.type) && strtoupper($NodeField.db_config.type) == strtoupper($db_opval))} selected="selected"{/if}>{$db_opval}</option>
                            	{/for}
                        	</optgroup>
                          	<optgroup label="String">
                                {for $db_opval in $DBFieldTypes.String}
                        		<option value="{$db_opval}"{if(isset($NodeField.db_config.type) && strtoupper($NodeField.db_config.type) == strtoupper($db_opval))} selected="selected"{/if}>{$db_opval}</option>
                            	{/for}
                            </optgroup>
                          	<optgroup label="Spatial">
                                {for $db_opval in $DBFieldTypes.Spatial}
                        		<option value="{$db_opval}"{if(isset($NodeField.db_config.type) && strtoupper($NodeField.db_config.type) == strtoupper($db_opval))} selected="selected"{/if}>{$db_opval}</option>
                            	{/for}
                            </optgroup>
                        </select>
                  	</td>
                    <td>
                    	<input name="Field[db_length]" type="text" class="form-control" id="FieldDBLength" placeholder="DB Length">
                  	</td>
                    <td>
                    	<select name="Field[db_collation]" class="form-control" id="FieldDBCollation">
                        	<optgroup label="utf8">
                            	{for $DB_collation in $DBCollations.utf8}
                                <option{if(isset($NodeField.db_config.collation) && strtoupper($NodeField.db_config.collation) == strtoupper($DB_collation))} selected="selected"{/if} value="{$DB_collation}">{$DB_collation}</option>
                                {/for}
                            </optgroup>
                        </select>
                 	</td>
                </tr>
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="10">
                    	<span class="label label-warning" style="font-size: 13px">Edit field {$NodeField.label}</span>&nbsp;
                        <span class="label label-info" style="font-size: 13px">Node type {$NodeTypeName}</span>&nbsp;
                    	<button type="button" onClick="window.history.go(-1)" class="btn btn-default">Cancel</button>
                    	<button type="submit" class="btn btn-primary">Save</button>
                    </td>
              	</tr>
            </tfoot>
        </table>
   	</form>
</div>