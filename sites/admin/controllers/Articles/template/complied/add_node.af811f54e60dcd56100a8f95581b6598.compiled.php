<?php if(!class_exists('ntpl')){exit;}?><form role="form" action="<?php echo $FormAction;?>" method="post">
	<input type="hidden" name="Add_Node" value="<?php echo $NodeType["node_type_id"];?>" />
    <input type="hidden" name="Is_Edit" value="0" />
    <?php echo $Form;?>
    <br />
    <center><button type="submit" class="btn btn-primary">Save</button></center>
</form>