<nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <li>
        	<a href="{#TEMPLATE_BASE}MenuGroup/Add/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm khối menu
            </a>
     	</li>
        <li>
            <a href="{#TEMPLATE_BASE}Menu/Add/{$MenuGroup.menu_group_id}/">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Thêm menu
            </a>
     	</li>
 	</ul>
</nav>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-1">
        <col class="col-xs-4">
        <col class="col-xs-2">
        <col class="col-xs-3">
        <col class="col-xs-3">
        </colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên menu</th>
                <th>Tiêu đề link</th>
                <th>Đường dẫn</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody>
        	{for $Node in $Nodes}
            <tr>
            	<td><code>{$Node['menu_id']}</code></td>
                <td>{if($Node['level'] != '')}&nbsp;&nbsp;&nbsp;&nbsp;{/if}<span class="menu_level">{$Node['level']}</span>&nbsp;<a href="{#TEMPLATE_BASE}Menu/Edit/{$Node['menu_id']}/">{$Node['menu_title']}</a></td>
                <td>{$Node['menu_titletag']}</td>
                <td>{$Node['menu_url']}</td>
                <td class="Item_Featured">
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="{#TEMPLATE_BASE}Menu/Edit/{$Node['menu_id']}/">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="{#TEMPLATE_BASE}Menu/Remove/{$Node['menu_id']}/">Remove</a>
                </td>
            </tr>
            {/for}
        </tbody>
    </table>
</div>
<style type="text/css">
.menu_level {
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px
}
.table>tbody>tr>td {
	padding: 8px
}
</style>