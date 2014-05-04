<div class="Theme_Containers clearfix">
	{for $Theme in $Themes}
    <div class="Theme_Item">
        <a class="View_Demo" href="#5555">Xem demo</a>
        <a href="{#TEMPLATE_BASE}Theme/view/{$Theme.theme_code}/">
            <img class="media-object" src="{$THEME_LIBS_DIR}{$Theme.directory}/sc.png" width="200" />
            <span class="Theme_Code">{$Theme.theme_code}</span>
        </a>
    </div>
    {/for}
</div>