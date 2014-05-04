<div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label">{$Field.label}</label>
    <div class="col-sm-10">
    	{if($Field.type == 'multi_select')}
        <select class="form-control" multiple="multiple" name="Node[{$Field.name}]" id="NodeField_{$Field.name}">
        	{if($Field.require != 1)}
            <option value="">Choose</option>
            {/if}
        	{for $Option in $Field.options}
            <option value="{$Option.name}" {if(in_array($Option.name,$Field.value))}selected="selected"{/if}>{$Option.value}</option>
            {/for}
        </select>
        {else}
        	{for $Option in $Field.options}     
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="Node[{$Field.name}][]" id="{$Field.name}_opt_{$Option.value}" value="{$Option.name}" {if(in_array($Option.name,$Field.value))}checked="checked"{/if}>
                    {$Option.value}
                </label>
            </div>
            {/for}
        {/if}
    </div>
</div>