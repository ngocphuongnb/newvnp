<tr id="ExtraFieldAttributes">
    <td colspan="2"><strong>Referer node type</strong></td>
    <td colspan="4">
        <select name="Field[referer][node_type]" class="form-control" id="RefererNodeType">
            <option value="">-- Select node type --</option>
        </select>
    </td>
</tr>
<tr id="RefereNodeField">
    <td colspan="2"><strong>Referer node field</strong></td>
    <td colspan="4">
        <select name="Field[referer][node_field]" class="form-control" id="ReferNodeField">
        </select>
    </td>
    {skip}
	<script type="text/javascript">
    for(i in NodeTypes) $('#RefererNodeType').append($('<option/>').val(i).html(NodeTypes[i].NodeTypeInfo.title));
    </script>
    {/skip}
</tr>
<tr id="ExtraOptionsDisplay">
    <td colspan="2"><strong>Display</strong></td>
    <td colspan="4">
        <select name="Field[display]" class="form-control" id="FieldDBCollation">
        	<option value="single_selectbox">Single selectbox</option>
            <option value="radio">Radio</option>
            <option value="checkbox">Checkbox</option>
            <option value="multi_selectbox">Multi selectbox</option>
        </select>
    </td>
</tr>