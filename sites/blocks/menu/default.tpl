<ul id="nav">
	{for $Menu in $Menus}
    <li id="nav-{$Menu.menu_id}" class="nav-{$Menu.menu_id}">
    	<a href="{$Menu.menu_url}" >{$Menu.menu_title}</a>
        {$Menu.sub}
  	</li>
    {/for}
</ul>