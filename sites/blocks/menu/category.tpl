<div id="cate-menu" class="DefaultModule cate-menu">
    <div class="defaultTitle cate-menu-title"><span>{$BLOCK.block_name}</span></div>
    <div class="defaultContent cate-menu-content">
        <ul>
        	{for $Menu in $Menus}
            <li>
            	<a href="{$Menu.menu_url}"><span>{$Menu.menu_title}</span></a>
                {$Menu.sub}
            </li>
            {/for}
        </ul>
    </div>
    <div class="defaultFooter cate-menu-footer">
        <div></div>
    </div>
</div>