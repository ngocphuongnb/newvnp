<div class="table-responsive">
	<form method="post" role="form">
    	<input type="hidden" name="edit_field" value="1" />
        <input type="hidden" name="field_name" value="{$NodeField.name}" />
        <table class="table table-bordered table-striped table-hover">
            <colgroup>
                <col class="col-xs-2">
                <col class="col-xs-1">
                <col class="col-xs-2">
                <col class="col-xs-1">
                <col class="col-xs-2">
                <col class="col-xs-1">
            </colgroup>
            <tbody id="FieldAttributesContainer">
                <tr>
                	<td><strong>Show in form</strong></td>   
                	<td>
                    	<input name="Field[inform]"{if(isset($NodeField.inform) && $NodeField.inform > 0)} checked="cheched"{/if} id="FieldInForm" type="checkbox" value="1" />
                  	</td>
                    <td><strong>Require</strong></td>
                    <td>
                    	<input name="Field[require]"{if(isset($NodeField.require) && $NodeField.require > 0)} checked="cheched"{/if} id="FieldRequire" type="checkbox" value="1" />
                  	</td>
                    <td><strong>Is auto increament</strong></td>
                    <td>
                    	<input name="Field[db_config][auto_increament]"{if(isset($NodeField.db_config.auto_increament) && $NodeField.db_config.auto_increament == 1)} checked="checked"{/if} type="checkbox" value="1" />
                	</td>
            	</tr>
                <tr>
                	<td><strong>Is unique</strong></td>   
                	<td colspan="5">
                    	<input name="Field[db_config][is_unique]"{if(isset($NodeField.db_config.is_unique) && $NodeField.db_config.is_unique > 0)} checked="cheched"{/if} id="FieldIsUnique" type="checkbox" value="1" />
                  	</td>
            	</tr>
                <tr>
                	<td colspan="2"><strong>Label</strong></td>
                	<td colspan="4">
                    	<input name="Field[label]" value="{$NodeField.label}" type="text" class="form-control" id="FieldLabel" placeholder="Field label">
                  	</td>
               	</tr>
                <tr>
                	<td colspan="2"><strong>Name</strong></td>
                    <td colspan="4">
                    	<input name="Field[name]" value="{$NodeField.name}" type="text" class="form-control" id="FieldName" placeholder="Field name"{if($NodeField.name != '')} readonly="readonly"{/if}>
                  	</td>
             	</tr>
                <tr>
                	<td colspan="2"><strong>Type</strong></td>
                    <td colspan="4">
                    <select name="Field[type]" class="form-control" id="FieldType">
                    	{for $FieldType in $FieldTypes as $FieldTypeKey}
                        <option{if($NodeField.type == $FieldTypeKey)} selected="selected"{/if} value="{$FieldTypeKey}">{$FieldTypeKey|strtoupper}</option>
                        {/for}
                    </select>
                  	</td>
              	</tr>
                <tr>
                	<td colspan="2"><strong>Filter</strong></td>
                    <td colspan="4">
                    	<input name="Field[filter]" value="{$NodeField.filter}" type="text" class="form-control" id="FieldFilter" placeholder="Field filter">
                  	</td>
             	</tr>
                <tr>
                	<td colspan="2"><strong>Default value</strong></td>
                    <td colspan="4">
                    	<input name="Field[value]" value="{$NodeField.value}" type="text" class="form-control" id="FieldValue" placeholder="Default value">
                  	</td>
              	<tr>
                <tr>
                	<td colspan="2"><strong>DB Type</strong></td>
                    <td colspan="4">
                    	<select name="Field[db_config][type]" class="form-control" id="FieldDBType">
                        	<option value="">-- Auto --</option>
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
               	</tr>
                <tr>
                	<td colspan="2"><strong>DB Length</strong></td>
                    <td colspan="4">
                    	<input value="{$NodeField.db_config.length}" name="Field[db_config][length]" type="text" class="form-control" id="FieldDBLength" placeholder="DB Length">
                  	</td>
              	</tr>
                <tr id="VNP_LastGeneralAttribute">
                	<td colspan="2"><strong>Collation</strong></td>
                    <td colspan="4">
                    	<select name="Field[db_config][collation]" class="form-control" id="FieldDBCollation">
                        	<option value="">-- Auto --</option>
                        	<optgroup label="utf8">
                            	{for $DB_collation in $DBCollations.utf8}
                                <option{if(isset($NodeField.db_config.collation) && strtoupper($NodeField.db_config.collation) == strtoupper($DB_collation))} selected="selected"{/if} value="{$DB_collation}">{$DB_collation}</option>
                                {/for}
                            </optgroup>
                        </select>
                 	</td>
              	</tr>
                {if(strtolower($NodeField.type) == 'single_value' || strtolower($NodeField.type) == 'multi_value')}
                <tr id="ExtraFieldAttributes">
                	<td colspan="2"><strong>Options</strong></td>
                    <td colspan="4">
                    	<!-- Option to clone -->
                        <div id="Option_To_Clone" style="display:none; visibility:hidden">
                            <div class="input-group NodeField_Option">
                                <span class="input-group-addon Move_Option">
                                    <span class="glyphicon glyphicon-resize-vertical"></span>
                                </span>
                                <span class="input-group-addon">
                                	{if(strtolower($NodeField.type) == 'single_value')}
                                    <input name="Field[value]" value="" class="FieldOption_Default" type="radio">
                                    {else}
                                    <input name="Field[value][]" value="" class="FieldOption_Default" type="checkbox">
                                    {/if}
                                </span>
                                <span class="input-group-addon">Value</span>
                                <input type="text" class="form-control FieldOption_Name" placeholder="Option value">
                                <span class="input-group-addon">Text</span>
                                <input type="text" class="form-control FieldOption_Value" placeholder="Option text">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger Remove_Option"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                            </div>
                        </div>
                        <!-- End option to clone -->
                    	<div class="col-sm-10" id="FieldOptions_Container">
                        	{for $Option in $NodeField.options as $FieldKey}
                            <div class="input-group NodeField_Option">
                                <span class="input-group-addon Move_Option">
                                    <span class="glyphicon glyphicon-resize-vertical"></span>
                                </span>
                                <span class="input-group-addon">
                                	{if(strtolower($NodeField.type) == 'single_value')}
                                    <input name="Field[value]"{if(in_array($Option['value'],explode(',',$NodeField.value)))} checked="checked"{/if} value="{$FieldKey}" class="FieldOption_Default" type="radio">
                                    {else}
                                    <input name="Field[value][]"{if(in_array($Option['value'],explode(',',$NodeField.value)))} checked="checked"{/if} value="{$FieldKey}" class="FieldOption_Default" type="checkbox">
                                    {/if}
                                </span>
                                <span class="input-group-addon">Value</span>
                                <input type="text" name="Field[options][{$FieldKey}][value]" class="form-control FieldOption_Name" value="{$Option.value}" placeholder="Option value">
                                <span class="input-group-addon">Text</span>
                                <input type="text" name="Field[options][{$FieldKey}][text]" class="form-control FieldOption_Value" value="{$Option.text}" placeholder="Option text">
                                <div class="input-group-btn">
                                	{if($FieldKey == 0)}
                                    <button class="btn btn-primary" id="Add_Option"><span class="glyphicon glyphicon-plus"></span></button>
                                    {else}
                                    <button class="btn btn-danger Remove_Option"><span class="glyphicon glyphicon-remove"></span></button>
                                    {/if}
                                </div>
                            </div>
                            {/for}
                      	</div>
                    </td>
               	</tr>
                <tr id="ExtraOptionsDisplay">
                	<td colspan="2"><strong>Display</strong></td>
                    <td colspan="4">
                    	<select name="Field[display]" class="form-control" id="FieldDBCollation">
                        	{if(strtolower($NodeField.type) == 'single_value')}
                        	<option value="radio"{if($NodeField.display == 'radio')} selected="selected"{/if}>Radio</option>
                            <option value="single_selectbox"{if($NodeField.display == 'single_selectbox')} selected="selected"{/if}>Single selectbox</option>
                            {else}
                            <option value="checkbox"{if($NodeField.display == 'checkbox')} selected="selected"{/if}>Checkbox</option>
                            <option value="multi_selectbox"{if($NodeField.display == 'multi_selectbox')} selected="selected"{/if}>Multi selectbox</option>
                            {/if}
                        </select>
                 	</td>
              	</tr>
                {elseif(strtolower($NodeField.type) == 'referer')}
                <tr id="ExtraFieldAttributes">
                	<td colspan="2"><strong>Referer node type</strong></td>
                    <td colspan="4">
                    	<select name="Field[referer][node_type]" class="form-control" id="RefererNodeType">
                        	<option value="">-- Select node type --</option>
                        	{for $NodeType in $NodeTypes.NodeTypes as $NodeTypeName}
                            {if($NodeTypeName == $NodeField.referer.node_type)}{$NodeTypeSelected = 'selected="selected"'}
                            {else}{$NodeTypeSelected = ''}{/if}
                            <option {$NodeTypeSelected} value="{$NodeTypeName}">{$NodeType.NodeTypeInfo.title}</option>
                         	{/for}
                      	</select>
                   	</td>
               	</tr>
             	<tr id="RefereNodeField">
                	<td colspan="2"><strong>Referer node field</strong></td>
                    <td colspan="4">
                        <select name="Field[referer][node_field]" class="form-control" id="ReferNodeField">
                        	{if(!empty($NodeField.referer.node_type))}
                            {$NodeFields = $NodeTypes['NodeTypes'][$NodeField['referer']['node_type']]['NodeFields']}
                            {for $OptionField in $NodeFields}
                            <option{if($OptionField.name == $NodeField.referer.node_field)} selected="selected"{/if} value="{$OptionField.name}">{$OptionField.label}</option>
                            {/for}
                            {/if}
                        </select>
                    </td>
              	</tr>
                <tr id="ExtraOptionsDisplay">
                	<td colspan="2"><strong>Display</strong></td>
                    <td colspan="4">
                    	<select name="Field[display]" class="form-control" id="FieldDBCollation">
                        	{if(!isset($NodeField.display))}{$NodeField.display = 'single_selectbox'}{/if}
                            <option value="single_selectbox"{if($NodeField.display == 'single_selectbox')} selected="selected"{/if}>Single selectbox</option>
                        	<option value="radio"{if($NodeField.display == 'radio')} selected="selected"{/if}>Radio</option>
                            <option value="checkbox"{if($NodeField.display == 'checkbox')} selected="selected"{/if}>Checkbox</option>
                            <option value="multi_selectbox"{if($NodeField.display == 'multi_selectbox')} selected="selected"{/if}>Multi selectbox</option>
                        </select>
                 	</td>
              	</tr>
                {/if}
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="6">
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
<script type="text/javascript">
var NodeTypes = $.parseJSON('{$NodeTypes.NodeTypes|json_encode}');
</script>