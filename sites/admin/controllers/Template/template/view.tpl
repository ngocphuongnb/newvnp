<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-3">
        <col class="col-xs-2">
        <col class="col-xs-8">
        </colgroup>
        <tbody>
        	<tr>
            	<td rowspan="8"><img class="media-object" src="{$THEME_LIBS_DIR}{$Theme.directory}/sc.png" width="200" /></td>
          	</tr>
            <tr>
            	<td colspan="2"><a href="{$Theme.demo_link}" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Xem thử</a><a href="{#TEMPLATE_BASE}Theme/install/{$Theme.theme_code}/" class="btn btn-success"><i class="glyphicon glyphicon-thumbs-up"></i>&nbsp;&nbsp;Cài đặt</a></td>
          	</tr>
            <tr>
            	<td>Mã giao diện</td><td><code>{$Theme.theme_code}</code></td>
          	</tr>
            <tr>
            	<td>Tên giao diện</td><td>{$Theme.theme_name}</td>
          	</tr>
            <tr>
            	<td>Tác giả</td><td>{$Theme.author}</td>
          	</tr>
            <tr>
            	<td>Loại giao diện</td><td>{$Theme.theme_type}</td>
          	</tr>
            <tr>
            	<td>Miêu tả</td><td>{$Theme.description}</td>
          	</tr>
            <tr>
            	<td>Phiên bản</td><td>{$Theme.version}</td>
          	</tr>
        </tbody>
    </table>
</div>