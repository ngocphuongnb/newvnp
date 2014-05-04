<?php if(!class_exists('ntpl')){exit;}?><div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label"><?php echo $Field["label"];?></label>
    <div class="col-sm-10">
    	<?php if( !in_array($Field["type"], array('textarea','meta_description')) ){ ?>
        <input type="<?php if( $Field["type"] == 'number' ){ ?>number<?php }else{ ?>text<?php } ?>" class="form-control" name="Node[<?php echo $Field["name"];?>]" id="NodeField_<?php echo $Field["name"];?>" value="<?php echo $Field["value"];?>" placeholder="<?php echo $Field["label"];?>"/>
        <?php }else{ ?>
        <textarea class="form-control" name="Node[<?php echo $Field["name"];?>]" id="NodeField_<?php echo $Field["name"];?>"><?php echo $Field["value"];?></textarea>
        <br />
        <?php } ?>
    </div>
</div>