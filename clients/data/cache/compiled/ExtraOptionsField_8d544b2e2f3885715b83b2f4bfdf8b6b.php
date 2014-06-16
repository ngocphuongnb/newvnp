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
                    <?php if(strtolower($FieldType) == 'single_value') { ?>
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
            <div class="input-group NodeField_Option">
                <span class="input-group-addon Move_Option">
                    <span class="glyphicon glyphicon-resize-vertical"></span>
                </span>
                <span class="input-group-addon">
                    <?php if(strtolower($FieldType) == 'single_value') { ?>
                    <input name="Field[value]" value="0" class="FieldOption_Default" type="radio">
                    <?php }else{ ?>
                    <input name="Field[value][]" value="0" class="FieldOption_Default" type="checkbox">
                    <?php } ?>
                </span>
                <span class="input-group-addon">Value</span>
                <input type="text" name="Field[options][0][value]" class="form-control FieldOption_Name" value="" placeholder="Option value">
                <span class="input-group-addon">Text</span>
                <input type="text" name="Field[options][0][text]" class="form-control FieldOption_Value" value="" placeholder="Option text">
                <div class="input-group-btn">
                    <button class="btn btn-primary" id="Add_Option"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
        </div>
    </td>
</tr>
<tr id="ExtraOptionsDisplay">
    <td colspan="2"><strong>Display</strong></td>
    <td colspan="4">
        <select name="Field[display]" class="form-control" id="FieldDBCollation">
            <?php if(strtolower($FieldType) == 'single_value') { ?>
            <option value="radio">Radio</option>
            <option value="single_selectbox">Single selectbox</option>
            <?php }else{ ?>
            <option value="checkbox">Checkbox</option>
            <option value="multi_selectbox">Multi selectbox</option>
            <?php } ?>
        </select>
    </td>
</tr>