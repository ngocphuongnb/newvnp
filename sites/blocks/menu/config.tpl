	<input name="Block[block_id]" value="{$Block.block_id}" type="hidden" /> 
    <input name="Block[block_file]" value="{$Block.block_file}" type="hidden" />
    <input name="Block[theme_area]" value="{$Block.theme_area}" type="hidden" />
    <label for="Block_Name" style="width: 100%">Tên khối</label>
    <div class="clearfix"></div>
    <div class="clearfix">
        <textarea id="Block_Name" style="width:100%" name="Block[block_name]" placeholder="Tên khối, hỗ trợ mã html" class="sugar-textbox">{$Data.block_name}</textarea>
    </div>     
    <div class="form-group">
        <label for="Menu_Group" class="sugarbox-label">Chọn khối menu</label>
        <select class="sugar-textbox" name="Block[menu_group]" id="Menu_Group">
            {for $Group in $MenuGroups}
            <option {if($Data.menu_group == $Group.menu_group_id)} selected="selected"{/if} value="{$Group.menu_group_id}">{$Group.menu_group_title}</option>
            {/for}
        </select>
    </div>
    <div class="form-group">
        <label for="Menu_Template" class="sugarbox-label">Chọn giao diện</label>
        <select class="sugar-textbox" name="Block[template]" id="Menu_Template">
            {for $Template in $Templates as $Tkey}
            <option {if($Data.template == $Tkey)} selected="selected"{/if} value="{$Tkey}">{$Template}</option>
            {/for}
        </select>
    </div>