<ul class="submenu">
	{for $Menu in $Menus}
    <li><a href="{$Menu.menu_url}"><span>{$Menu.menu_title}</span></a></li>
    {/for}
</ul>
