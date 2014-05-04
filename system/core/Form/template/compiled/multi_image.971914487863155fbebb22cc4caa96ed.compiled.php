<?php if(!class_exists('ntpl')){exit;}?><div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label"><?php echo $Field["label"];?></label>
   	<input data-field-type="<?php echo $Field["type"];?>" type="hidden" class="form-control NodeField_MultiImages" name="Node[<?php echo $Field["name"];?>][]" id="NodeField_<?php echo $Field["name"];?>" value="" placeholder="<?php echo $Field["label"];?>"/>
    <div class="col-sm-10">
    	<div class="clearfix">
            <button class="btn btn-primary" onclick="VNP.SugarBox.Open('MultiImages','<?php echo $Field["name"];?>'); return false;">Browse</button>
            <button class="btn btn-danger" onclick="document.getElementById('MultiImages_<?php echo $Field["name"];?>').innerHTML = ''; return false;">Delete all</button>
      	</div>
        <div class="clearfix MultiImages_Container" id="MultiImages_<?php echo $Field["name"];?>">
        	<?php $counter1=-1; if( isset($Field["value"]) && is_array($Field["value"]) && sizeof($Field["value"]) ) foreach( $Field["value"] as $key1 => $__Img ){ $counter1++; ?>
            <?php if( !empty($__Img) ){ ?>
            <div class="MultiImages_Item">
            	<input type="hidden" name="Node[<?php echo $Field["name"];?>][]" value="<?php echo $__Img;?>" />
                <img src="/Thumbnail/60_60<?php echo $__Img;?>"/>
                <a href="#" onclick="this.parentNode.parentNode.removeChild(this.parentNode); return false;">Delete</a>
          	</div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<br />
<br />
<style type="text/css">
.MultiImages_Container .MultiImages_Item {
	text-align:center; width: 60px; margin:10px 10px 0 0; float: left
}
</style>