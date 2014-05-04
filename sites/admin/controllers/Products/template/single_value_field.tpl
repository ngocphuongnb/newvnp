<div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label">{$Field.label}</label>
    <div class="col-sm-10">
    	{if($Field.display == 'radio')}
        	{for $Option in $Field.options}
            <div class="radio">
                <label>
                    <input type="radio" name="Node[{$Field.name}]" id="{$Field.name}_opt_{$Option.value}" value="{$Option.name}" {if($Field.value == $Option.name)}checked="checked"{/if}>
                    {$Option.value}
                </label>
            </div>
            {/for}
        {else}
        <select class="form-control" name="Node[{$Field.name}]" id="NodeField_{$Field.name}">
        	{if($Field.require != 1)}
            <option value="">Choose</option>
            {/if}
        	{for $Option in $Field.options}
            <option value="{$Option.name}" {if($Field.value == $Option.name)}selected="selected"{/if}>{$Option.value}</option>
            {/for}
        </select>
        {/if}
    </div>
</div>