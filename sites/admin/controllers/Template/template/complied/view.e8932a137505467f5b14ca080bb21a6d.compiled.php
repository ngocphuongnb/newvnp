<?php if(!class_exists('ntpl')){exit;}?><div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-3">
        <col class="col-xs-2">
        <col class="col-xs-8">
        </colgroup>
        <tbody>
        	<tr>
            	<td rowspan="8"><img class="media-object" src="<?php echo $THEME_LIBS_DIR;?><?php echo $Theme["directory"];?>/sc.png" width="200" /></td>
          	</tr>
            <tr>
            	<td colspan="2"><a href="<?php echo $Theme["demo_link"];?>" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Xem thử</a><a href="<?php  echo TEMPLATE_BASE;?>Theme/install/<?php echo $Theme["theme_code"];?>/" class="btn btn-success"><i class="glyphicon glyphicon-thumbs-up"></i>&nbsp;&nbsp;Cài đặt</a></td>
          	</tr>
            <tr>
            	<td>Mã giao diện</td><td><code><?php echo $Theme["theme_code"];?></code></td>
          	</tr>
            <tr>
            	<td>Tên giao diện</td><td><?php echo $Theme["theme_name"];?></td>
          	</tr>
            <tr>
            	<td>Tác giả</td><td><?php echo $Theme["author"];?></td>
          	</tr>
            <tr>
            	<td>Loại giao diện</td><td><?php echo $Theme["theme_type"];?></td>
          	</tr>
            <tr>
            	<td>Miêu tả</td><td><?php echo $Theme["description"];?></td>
          	</tr>
            <tr>
            	<td>Phiên bản</td><td><?php echo $Theme["version"];?></td>
          	</tr>
        </tbody>
    </table>
</div>