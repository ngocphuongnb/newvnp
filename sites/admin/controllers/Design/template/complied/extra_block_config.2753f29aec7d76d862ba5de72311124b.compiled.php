<?php if(!class_exists('ntpl')){exit;}?>   	<label for="Pages" class="sugarbox-label" style="width: 630px">Trang hiển thị (Chọn các trang mà khối sẽ hiển thị)</label>
    <div class="form-group" style="width: 630px">
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" value="current_page"/>Trang hiện tại</label></div>
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" <?php if( in_array("ProductCategory", $Pages) ){ ?>checked<?php } ?> value="ProductCategory"/>Danh mục sản phẩm</label></div>
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" <?php if( in_array("ProductGroup", $Pages) ){ ?>checked<?php } ?> value="ProductGroup"/>Nhóm sản phẩm</label></div>
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" <?php if( in_array("ProductDetail", $Pages) ){ ?>checked<?php } ?> value="ProductDetail"/>Chi tiết sản phẩm</label></div>
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" <?php if( in_array("NewsHome", $Pages) ){ ?>checked<?php } ?> value="NewsHome"/>Trang tin tức</label></div>
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" <?php if( in_array("NewsCategory", $Pages) ){ ?>checked<?php } ?> value="NewsCategory"/>Chuyên mục tin tức</label></div>
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" <?php if( in_array("NewsGroup", $Pages) ){ ?>checked<?php } ?> value="NewsGroup"/>Nhóm tin tức</label></div>
        <div class="AppearPages"><label><input type="checkbox" name="Block[pages][]" <?php if( in_array("NewsDetail", $Pages) ){ ?>checked<?php } ?> value="NewsDetail"/>Xem tin</label></div>
        <div class="clearfix"></div>
        <label for="Pages" class="sugarbox-label" style="width: 630px">Danh sách trang (mỗi trang nằm trên một dòng, trang chủ có đường dẫn là / )</label>
        <div class="clearfix"></div>
        <textarea class="sugar-textbox" style="width: 616px; height: 50px; background: #FFF;padding:5px" name="Block[custom_pages]" placeholder="Ví dụ: /rau-cu.html"><?php echo $CustomPages;?></textarea>
    </div>
    <style type="text/css">
	div.AppearPages {
		width: 25% !important;
		float: left !important;
		margin-bottom: 5px !important;
	}
	div.AppearPages label {
		cursor: pointer !important
	}
	div.AppearPages label input {
		margin-right: 5px !important
	}
	iframe#Block_Name_ifr { height: 28px !important}
	.mce-edit-area.mce-container.mce-panel.mce-stack-layout-item iframe {
padding-bottom: 3px !important;
}
	</style>