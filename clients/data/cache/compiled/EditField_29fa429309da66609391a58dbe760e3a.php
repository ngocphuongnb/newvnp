<div class="table-responsive">
	<form method="post" role="form">
    	<input type="hidden" name="edit_field" value="1" />
        <input type="hidden" name="field_name" value="<?php echo $NodeField['name'] ?>" />
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
                    	<input name="Field[inform]"<?php if(isset($NodeField['inform']) && $NodeField['inform'] > 0) { ?> checked="cheched"<?php } ?> id="FieldInForm" type="checkbox" value="1" />
                  	</td>
                    <td><strong>Require</strong></td>
                    <td>
                    	<input name="Field[require]"<?php if(isset($NodeField['require']) && $NodeField['require'] > 0) { ?> checked="cheched"<?php } ?> id="FieldRequire" type="checkbox" value="1" />
                  	</td>
                    <td><strong>Is auto increament</strong></td>
                    <td>
                    	<input name="Field[db_config][auto_increament]"<?php if(isset($NodeField['db_config']['auto_increament']) && $NodeField['db_config']['auto_increament'] == 1) { ?> checked="checked"<?php } ?> type="checkbox" value="1" />
                	</td>
            	</tr>
                <tr>
                	<td><strong>Is unique</strong></td>   
                	<td colspan="5">
                    	<input name="Field[db_config][is_unique]"<?php if(isset($NodeField['db_config']['is_unique']) && $NodeField['db_config']['is_unique'] > 0) { ?> checked="cheched"<?php } ?> id="FieldIsUnique" type="checkbox" value="1" />
                  	</td>
            	</tr>
                <tr>
                	<td colspan="2"><strong>Label</strong></td>
                	<td colspan="4">
                    	<input name="Field[label]" value="<?php echo $NodeField['label'] ?>" type="text" class="form-control" id="FieldLabel" placeholder="Field label">
                  	</td>
               	</tr>
                <tr>
                	<td colspan="2"><strong>Name</strong></td>
                    <td colspan="4">
                    	<input name="Field[name]" value="<?php echo $NodeField['name'] ?>" type="text" class="form-control" id="FieldName" placeholder="Field name"<?php if($NodeField['name'] != '') { ?> readonly="readonly"<?php } ?>>
                  	</td>
             	</tr>
                <tr>
                	<td colspan="2"><strong>Type</strong></td>
                    <td colspan="4">
                    <select name="Field[type]" class="form-control" id="FieldType">
                    	<?php foreach($FieldTypes as $FieldTypeKey => $FieldType) { ?>
                        <option<?php if($NodeField['type'] == $FieldTypeKey) { ?> selected="selected"<?php } ?> value="<?php echo $FieldTypeKey ?>"><?php echo strtoupper($FieldTypeKey) ?></option>
                        <?php } ?>
                    </select>
                  	</td>
              	</tr>
                <tr>
                	<td colspan="2"><strong>Filter</strong></td>
                    <td colspan="4">
                    	<input name="Field[filter]" value="<?php echo $NodeField['filter'] ?>" type="text" class="form-control" id="FieldFilter" placeholder="Field filter">
                  	</td>
             	</tr>
                <tr>
                	<td colspan="2"><strong>Default value</strong></td>
                    <td colspan="4">
                    	<input name="Field[value]" value="<?php echo $NodeField['value'] ?>" type="text" class="form-control" id="FieldValue" placeholder="Default value">
                  	</td>
              	<tr>
                <tr>
                	<td colspan="2"><strong>DB Type</strong></td>
                    <td colspan="4">
                    	<select name="Field[db_config][type]" class="form-control" id="FieldDBType">
                        	<option value="">-- Auto --</option>
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
               	</tr>
                <tr>
                	<td colspan="2"><strong>DB Length</strong></td>
                    <td colspan="4">
                    	<input value="<?php echo $NodeField['db_config']['length'] ?>" name="Field[db_config][length]" type="text" class="form-control" id="FieldDBLength" placeholder="DB Length">
                  	</td>
              	</tr>
                <tr id="VNP_LastGeneralAttribute">
                	<td colspan="2"><strong>Collation</strong></td>
                    <td colspan="4">
                    	<select name="Field[db_config][collation]" class="form-control" id="FieldDBCollation">
                        	<option value="">-- Auto --</option>
                        	<optgroup label="utf8">
                            	<?php foreach($DBCollations['utf8'] as $DB_collation) { ?>
                                <option<?php if(isset($NodeField['db_config']['collation']) && strtoupper($NodeField['db_config']['collation']) == strtoupper($DB_collation)) { ?> selected="selected"<?php } ?> value="<?php echo $DB_collation ?>"><?php echo $DB_collation ?></option>
                                <?php } ?>
                            </optgroup>
                        </select>
                 	</td>
              	</tr>
                <?php if(strtolower($NodeField['type']) == 'single_value' || strtolower($NodeField['type']) == 'multi_value') { ?>
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
                                	<?php if(strtolower($NodeField['type']) == 'single_value') { ?>
                                    <input name="Field[value]" value="" class="FieldOption_Default" type="radio">
                                    <?php }else{ ?>
                                    <input name="Field[value][]" value="" class="FieldOption_Default" type="checkbox">
                                    <?php } ?>
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
                        	<?php foreach($NodeField['options'] as $FieldKey => $Option) { ?>
                            <div class="input-group NodeField_Option">
                                <span class="input-group-addon Move_Option">
                                    <span class="glyphicon glyphicon-resize-vertical"></span>
                                </span>
                                <span class="input-group-addon">
                                	<?php if(strtolower($NodeField['type']) == 'single_value') { ?>
                                    <input name="Field[value]"<?php if(in_array($Option['value'],explode(',',$NodeField['value']))) { ?> checked="checked"<?php } ?> value="<?php echo $FieldKey ?>" class="FieldOption_Default" type="radio">
                                    <?php }else{ ?>
                                    <input name="Field[value][]"<?php if(in_array($Option['value'],explode(',',$NodeField['value']))) { ?> checked="checked"<?php } ?> value="<?php echo $FieldKey ?>" class="FieldOption_Default" type="checkbox">
                                    <?php } ?>
                                </span>
                                <span class="input-group-addon">Value</span>
                                <input type="text" name="Field[options][<?php echo $FieldKey ?>][value]" class="form-control FieldOption_Name" value="<?php echo $Option['value'] ?>" placeholder="Option value">
                                <span class="input-group-addon">Text</span>
                                <input type="text" name="Field[options][<?php echo $FieldKey ?>][text]" class="form-control FieldOption_Value" value="<?php echo $Option['text'] ?>" placeholder="Option text">
                                <div class="input-group-btn">
                                	<?php if($FieldKey == 0) { ?>
                                    <button class="btn btn-primary" id="Add_Option"><span class="glyphicon glyphicon-plus"></span></button>
                                    <?php }else{ ?>
                                    <button class="btn btn-danger Remove_Option"><span class="glyphicon glyphicon-remove"></span></button>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                      	</div>
                    </td>
               	</tr>
                <tr id="ExtraOptionsDisplay">
                	<td colspan="2"><strong>Display</strong></td>
                    <td colspan="4">
                    	<select name="Field[display]" class="form-control" id="FieldDBCollation">
                        	<?php if(strtolower($NodeField['type']) == 'single_value') { ?>
                        	<option value="radio"<?php if($NodeField['display'] == 'radio') { ?> selected="selected"<?php } ?>>Radio</option>
                            <option value="single_selectbox"<?php if($NodeField['display'] == 'single_selectbox') { ?> selected="selected"<?php } ?>>Single selectbox</option>
                            <?php }else{ ?>
                            <option value="checkbox"<?php if($NodeField['display'] == 'checkbox') { ?> selected="selected"<?php } ?>>Checkbox</option>
                            <option value="multi_selectbox"<?php if($NodeField['display'] == 'multi_selectbox') { ?> selected="selected"<?php } ?>>Multi selectbox</option>
                            <?php } ?>
                        </select>
                 	</td>
              	</tr>
                <?php } elseif(strtolower($NodeField['type']) == 'referer') { ?>
                <tr id="ExtraFieldAttributes">
                	<td colspan="2"><strong>Referer node type</strong></td>
                    <td colspan="4">
                    	<select name="Field[referer][node_type]" class="form-control" id="RefererNodeType">
                        	<option value="">-- Select node type --</option>
                        	<?php foreach($NodeTypes['NodeTypes'] as $NodeTypeName => $NodeType) { ?>
                            <?php if($NodeTypeName == $NodeField['referer']['node_type']) { ?><?php $NodeTypeSelected = 'selected="selected"' ?>
                            <?php }else{ ?><?php $NodeTypeSelected = '' ?><?php } ?>
                            <option <?php echo $NodeTypeSelected ?> value="<?php echo $NodeTypeName ?>"><?php echo $NodeType['NodeTypeInfo']['title'] ?></option>
                         	<?php } ?>
                      	</select>
                   	</td>
               	</tr>
             	<tr id="RefereNodeField">
                	<td colspan="2"><strong>Referer node field</strong></td>
                    <td colspan="4">
                        <select name="Field[referer][node_field]" class="form-control" id="ReferNodeField">
                        	<?php if(!empty($NodeField['referer']['node_type'])) { ?>
                            <?php $NodeFields = $NodeTypes['NodeTypes'][$NodeField['referer']['node_type']]['NodeFields'] ?>
                            <?php foreach($NodeFields as $OptionField) { ?>
                            <option<?php if($OptionField['name'] == $NodeField['referer']['node_field']) { ?> selected="selected"<?php } ?> value="<?php echo $OptionField['name'] ?>"><?php echo $OptionField['label'] ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
              	</tr>
                <tr id="ExtraOptionsDisplay">
                	<td colspan="2"><strong>Display</strong></td>
                    <td colspan="4">
                    	<select name="Field[display]" class="form-control" id="FieldDBCollation">
                        	<?php if(!isset($NodeField['display'])) { ?><?php $NodeField['display'] = 'single_selectbox' ?><?php } ?>
                            <option value="single_selectbox"<?php if($NodeField['display'] == 'single_selectbox') { ?> selected="selected"<?php } ?>>Single selectbox</option>
                        	<option value="radio"<?php if($NodeField['display'] == 'radio') { ?> selected="selected"<?php } ?>>Radio</option>
                            <option value="checkbox"<?php if($NodeField['display'] == 'checkbox') { ?> selected="selected"<?php } ?>>Checkbox</option>
                            <option value="multi_selectbox"<?php if($NodeField['display'] == 'multi_selectbox') { ?> selected="selected"<?php } ?>>Multi selectbox</option>
                        </select>
                 	</td>
              	</tr>
                <?php } ?>
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="6">
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
<script type="text/javascript">
var NodeTypes = $.parseJSON('<?php echo json_encode($NodeTypes['NodeTypes']) ?>');
</script>