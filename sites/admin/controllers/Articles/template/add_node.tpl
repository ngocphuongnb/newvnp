<form role="form" action="{$FormAction}" method="post">
	<input type="hidden" name="Add_Node" value="{$NodeType.node_type_id}" />
    <input type="hidden" name="Is_Edit" value="0" />
    {$Form}
    <br />
    <center><button type="submit" class="btn btn-primary">Save</button></center>
</form>