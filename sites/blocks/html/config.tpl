	<input name="Block[block_id]" value="{$Block.block_id}" type="hidden" /> 
    <input name="Block[block_file]" value="{$Block.block_file}" type="hidden" />
    <input name="Block[theme_area]" value="{$Block.theme_area}" type="hidden" />
    
    <label for="Block_Name" style="width: 100%">Tên khối</label>
    <div class="clearfix"></div>
    <div class="clearfix">
        <textarea id="Block_Name" style="width:100%" name="Block[block_name]" placeholder="Tên khối, hỗ trợ mã html" class="sugar-textbox">{$Data.block_name}</textarea>
    </div>   
    <div class="clearfix">
        <label for="Html_Content" class="sugarbox-label">Nội dung</label>
    </div>
    <div class="clearfix">
    	<textarea id="Html_Content" style="width: 800px; height: 50px; background: #FFF;padding:5px" name="Block[html_content]" placeholder="Nội dung" class="sugar-textbox">{$Data.html_content}</textarea>
  	</div>
    <div class="form-group">
        <label for="Menu_Template" class="sugarbox-label">Chọn giao diện</label>
        <select class="sugar-textbox" name="Block[template]" id="Menu_Template">
            {for $Template in $Templates as $Tkey}
            <option {if($Data.template == $Tkey)} selected="selected"{/if} value="{$Tkey}">{$Template}</option>
            {/for}
        </select>
    </div>