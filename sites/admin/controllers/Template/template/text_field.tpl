<div class="form-group">
    <label for="NodeType_name" class="col-sm-2 control-label">{$Field.label}</label>
    <div class="col-sm-10">
    	{if(!in_array($Field.type, array('textarea','meta_description')))}
        <input type="{if($Field.type == 'number')}number{else}text{/if}" class="form-control" name="Node[{$Field.name}]" id="NodeField_{$Field.name}" value="{$Field.value}" placeholder="{$Field.label}"/>
        {else}
        <textarea class="form-control" name="Node[{$Field.name}]" id="NodeField_{$Field.name}">{$Field.value}</textarea>
        <br />
        {/if}
    </div>
</div>