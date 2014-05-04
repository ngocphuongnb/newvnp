<?php if(!class_exists('ntpl')){exit;}?><div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label"><?php echo $Field["label"];?></label>
    <div class="col-sm-10">
    	<?php if( $Field["type"] == 'multi_select' ){ ?>
        <select class="form-control" multiple="multiple" name="Node[<?php echo $Field["name"];?>]" id="NodeField_<?php echo $Field["name"];?>">
        	<?php if( $Field["require"] != 1 ){ ?>
            <option value="">Choose</option>
            <?php } ?>
        	<?php $counter1=-1; if( isset($Field["options"]) && is_array($Field["options"]) && sizeof($Field["options"]) ) foreach( $Field["options"] as $key1 => $Option ){ $counter1++; ?>
            <option value="<?php echo $Option["name"];?>" <?php if( in_array($Option["name"],$Field["value"]) ){ ?>selected="selected"<?php } ?>><?php echo $Option["value"];?></option>
            <?php } ?>
        </select>
        <?php }else{ ?>
        	<?php $counter1=-1; if( isset($Field["options"]) && is_array($Field["options"]) && sizeof($Field["options"]) ) foreach( $Field["options"] as $key1 => $Option ){ $counter1++; ?>     
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="Node[<?php echo $Field["name"];?>][]" id="<?php echo $Field["name"];?>_opt_<?php echo $Option["value"];?>" value="<?php echo $Option["name"];?>" <?php if( in_array($Option["name"],$Field["value"]) ){ ?>checked="checked"<?php } ?>>
                    <?php echo $Option["value"];?>
                </label>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>