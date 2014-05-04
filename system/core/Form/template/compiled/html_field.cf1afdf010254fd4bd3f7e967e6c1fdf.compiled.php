<?php if(!class_exists('ntpl')){exit;}?><div class="form-group clearfix">
    <div class="col-sm-12">
    	<label for="NodeType_name" class="control-label"><?php echo $Field["label"];?></label>
        <textarea class="form-control" name="Node[<?php echo $Field["name"];?>]" id="NodeField_<?php echo $Field["name"];?>"><?php echo $Field["value"];?></textarea>
    </div>
</div>