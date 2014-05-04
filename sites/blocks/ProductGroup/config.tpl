	<input name="Block[block_id]" value="{$Block.block_id}" type="hidden" /> 
    <input name="Block[block_file]" value="{$Block.block_file}" type="hidden" />
    <input name="Block[theme_area]" value="{$Block.theme_area}" type="hidden" />
    <label for="Block_Name" style="width: 100%">Tên khối</label>
    <div class="clearfix"></div>
    <div class="clearfix">
        <textarea id="Block_Name" style="width:100%" name="Block[block_name]" placeholder="Tên khối, hỗ trợ mã html" class="sugar-textbox">{$Data.block_name}</textarea>
    </div>   
    <div class="form-group">
        <label for="Block_Url" class="sugarbox-label">Đường dẫn</label>
        <input type="text" id="Block_Url" style="width:305px" name="Block[block_url]" placeholder="Đường dẫn tên khối, có thể để trống" class="sugar-textbox" value="{$Data.block_url}" />
    </div>
    <div class="form-group">
        <label for="Num_Rows" class="sugarbox-label">Số lượng sản phẩm</label>
        <input type="text" id="Num_Rows" style="width:305px" name="Block[num_rows]" placeholder="Số lượng sản phẩm" class="sugar-textbox" value="{$Data.num_rows}" />
    </div>
    <div class="form-group">
        <label for="From_Date" class="sugarbox-label">Lấy từ ngày</label>
        <input type="number" id="From_Date" style="width:305px" name="Block[from_date]" placeholder="Số ngày gần nhất, để 0 nếu lấy tất cả" class="sugar-textbox" value="{$Data.from_date}" />
    </div>  
    <div class="form-group">
        <label for="Product_Group" class="sugarbox-label">Chọn khối sản phẩm</label>
        <select class="sugar-textbox" name="Block[product_group]" id="Product_Group">
            {for $Group in $ProductGroups}
            <option {if($Data.product_group == $Group.product_group_id)} selected="selected"{/if} value="{$Group.product_group_id}">{$Group.product_group_title}</option>
            {/for}
        </select>
    </div>
    <div class="form-group">
        <label for="Product_Template" class="sugarbox-label">Chọn giao diện</label>
        <select class="sugar-textbox" name="Block[template]" id="Product_Template">
            {for $Template in $Templates as $Tkey}
            <option {if($Data.template == $Tkey)} selected="selected"{/if} value="{$Tkey}">{$Template}</option>
            {/for}
        </select>
    </div>