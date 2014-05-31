<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{$name}</h3>
    </div>
    <div class="panel-body">
        <form method="{$config.method}" action="{$config.action}">
        	{for $token in $config.tokens}
            <input type="hidden" name="{$token.name}" value="{$token.value}" />
            {/for}
            <a href="javascript:window.history.go(-1); return false;" class="btn btn-default">Cancel</a>&nbsp;&nbsp;
            <input type="submit" class="btn btn-danger" value="Confirm" />
        </form>
    </div>
</div>