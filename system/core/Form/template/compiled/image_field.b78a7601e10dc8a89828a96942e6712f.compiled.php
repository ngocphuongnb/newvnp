<?php if(!class_exists('ntpl')){exit;}?><div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label"><?php echo $Field["label"];?></label>
    <div class="clearfix">
        <div class="col-sm-7">
            <input data-field-type="<?php echo $Field["type"];?>" type="text" class="form-control NodeField_ImageInput" name="Node[<?php echo $Field["name"];?>]" id="NodeField_<?php echo $Field["name"];?>" value="<?php echo $Field["value"];?>" placeholder="<?php echo $Field["label"];?>" onchange="document.getElementById('Thumb_NodeField_<?php echo $Field["name"];?>').setAttribute('src', this.value); return false;"/>
        </div>
        <div class="col-sm-3">
            <button class="btn btn-primary" onclick="VNP.SugarBox.Open('FileManager','NodeField_<?php echo $Field["name"];?>'); return false;">Browse</button>
            <button class="btn btn-danger" onclick="document.getElementById('NodeField_<?php echo $Field["name"];?>').value = ''; document.getElementById('Thumb_NodeField_<?php echo $Field["name"];?>').setAttribute('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=='); return false;">Delete</button>
        </div>
  	</div>
    <label for="NodeType_name" class="col-sm-2 control-label"></label>
    <div class="col-sm-7" style="margin-top:5px">
    	<img id="Thumb_NodeField_<?php echo $Field["name"];?>" src="<?php if( empty($Field["value"]) ){ ?>data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==<?php }else{ ?>/Thumbnail/80_80<?php echo $Field["value"];?><?php } ?>" />
    </div>
</div>