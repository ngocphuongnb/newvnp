<div class="form-group clear">
    <label for="NodeType_name" class="col-sm-2 control-label">{$Field.label}</label>
    <div class="col-sm-10">
    	{if($Field.display == 'multi_select')}
        <select class="form-control" multiple="multiple" name="Node[{$Field.name}]" id="NodeField_{$Field.name}">
        	{if($Field.require != 1)}
            <option value="">Choose</option>
            {/if}
        	{for $Option in $Field.options}
            <option value="{$Option.name}" {if(in_array($Option.name,$Field.value))}selected="selected"{/if}>{$Option.value}</option>
            {/for}
        </select>
        {elseif($Field.display == 'single_select')}
        <select class="form-control" name="Node[{$Field.name}]" id="NodeField_{$Field.name}">
        	{if($Field.require != 1)}
            <option value="">Choose</option>
            {/if}
        	{for $Option in $Field.options}
            <option value="{$Option.name}" {if($Option.name == $Field.value)}selected="selected"{/if}>{$Option.value}</option>
            {/for}
        </select>
        {elseif($Field.display == 'checkbox')}
        	{for $Option in $Field.options}     
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="Node[{$Field.name}][]" id="{$Field.name}_opt_{$Option.name}" value="{$Option.name}" {if(in_array($Option.name,$Field.value))}checked="checked"{/if}>
                    {$Option.value}
                </label>
            </div>
            {/for}
        {elseif($Field.display == 'radio')}
        	{for $Option in $Field.options}     
            <div class="radio">
                <label>
                    <input type="radio" name="Node[{$Field.name}]" id="{$Field.name}_opt_{$Option.name}" value="{$Option.name}" {if($Option.name == $Field.value)}checked="checked"{/if}>
                    {$Option.value}
                </label>
            </div>
            {/for}
        {/if}
    </div>
</div>
<br />