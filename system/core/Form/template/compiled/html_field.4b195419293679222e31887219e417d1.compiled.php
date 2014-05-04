<?php if(!class_exists('ntpl')){exit;}?><div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label"><?php echo $Field["label"];?></label>
</div>
<div class="form-group clearfix">
    <div class="col-sm-12">
        <textarea class="form-control" name="Node[<?php echo $Field["name"];?>]" id="NodeField_<?php echo $Field["name"];?>"><?php echo $Field["value"];?></textarea>
    </div>
</div>