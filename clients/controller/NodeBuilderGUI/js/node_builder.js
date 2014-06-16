// JavaScript Document
//$('#Add_Option').click(function(e) {
$(document).on('click', '#Add_Option', function(e) {
    e.preventDefault();
	var Cloner = $('#Option_To_Clone').html();
	$('#FieldOptions_Container').append(Cloner);
	 ReOrderNodeFieldOptions();
});
$('#FieldType').change(function(e) {
    var FieldType = this.value;
	$('#FieldValue').val('');
	$('#ExtraFieldAttributes,#ExtraOptionsDisplay,#RefereNodeField').remove();
	if(FieldType == 'single_value' || FieldType == 'multi_value' || FieldType == 'referer') {
		VNP.Ajax({
			type:		'POST',
			data:		{FieldType: FieldType},
			url:		'NodeBuilderGUI/NodeFieldExtraAttribute/',
			success:	function(Response) {
				$('#FieldAttributesContainer').append(Response);
				VNP.Loader.hide();
			}
		}, 'text');
	}
});
$(document).on('click', '.Remove_Option', function(e) {
    e.preventDefault();
	if(confirm('Are you sure?'))
		$(this).parent().parent().remove();
	 ReOrderNodeFieldOptions();
});

$(document).ready(function(e) {
    $('#FieldOptions_Container').sortable({
									handle: '.Move_Option',
									items: '.NodeField_Option',
									containment: 'parent',
									stop: function(event, ui) {ReOrderNodeFieldOptions()}
								});
	$('#NodeField_List').sortable({
									handle: '.Move_Option',
									items: '.NodeField_Item',
									containment: 'parent',
									stop: function(event, ui) {Node.ReOrderNodeFields()}
								});
	$(document).on('change', '#RefererNodeType', function(e) {
	//$('#RefererNodeType').change(function(e) {
		//alert(this.value);
		var NodeTypeName = this.value;
		$('#ReferNodeField').html('');
		$.each(NodeTypes[NodeTypeName].NodeFields, function(Index,FieldElement) {
			var NodeFieldOption = document.createElement('option');
			NodeFieldOption.value = FieldElement.name;
			NodeFieldOption.innerHTML = FieldElement.label;
			$('#ReferNodeField').append(NodeFieldOption);
		});
        /*VNP.Ajax({
			type: 'POST',
			url	: 'Node/NodeField/manage/' + this.value + '/fields/',
			success: function(ListFields) {
				var _Options = '';
				for(FieldID in ListFields)
				{
					var Field = ListFields[FieldID];
					_Options += '<option value="' + Field.node_field_id + '">' + Field.node_field_name + '</option>';
				}
				$('#NodeField_TitleField').html(_Options);
				VNP.Loader.TextNotify('Loaded', 'success', 500);
			},
			error: function() {
				VNP.Loader.TextNotify('Error', 'error');
			}
		},'json');*/
    });
});

function ReOrderNodeFieldOptions()
{
	var OptionNameTemplate = 'Field[options]';
	$.each($('#FieldOptions_Container .NodeField_Option'), function(i, OptionElement) {
		var j = i;
		$('input.FieldOption_Default', OptionElement).attr('value', j);
		$('input.FieldOption_Name', OptionElement).attr('name', OptionNameTemplate+'['+j+'][value]');
		$('input.FieldOption_Value', OptionElement).attr('name', OptionNameTemplate+'['+j+'][text]');
	});
}
function objToString(obj) {
    var str = '';
    for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
            str += p + '::' + obj[p] + '\n';
        }
    }
    return str;
}

function NodeBase(NodeTypeID,NodeFieldID,NodeID)
{
	if(typeof NodeTypeID	=== 'undefined') NodeTypeID = 0;
	if(typeof NodeFieldID	=== 'undefined') NodeFieldID = 0;
	if(typeof NodeID		=== 'undefined') NodeID = 0;
	
	this.NodeTypeID		= NodeTypeID;
	this.NodeFieldID	= NodeFieldID;
	this.NodeID			= NodeID;
	
	this.ReOrderNodeFields = function() {
		var OrderedList = new Array();
		$.each($('#NodeField_List .NodeField_Item'), function(i, OptionElement) {
			OrderedList[i] = $(OptionElement).attr('data-field-id');
		});
		
		VNP.Ajax({
			type: 'POST',
			url	: 'Node/NodeField/manage/' + this.NodeTypeID + '/sort/',
			data: {fields:OrderedList.join(',')},
			success: function(data) {
				if(data != 'ok') VNP.Loader.TextNotify('Error', 'error');
				else VNP.Loader.TextNotify('Success', 'success');
			}
		});
	}
}