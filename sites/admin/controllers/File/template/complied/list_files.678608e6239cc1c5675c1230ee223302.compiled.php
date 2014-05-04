<?php if(!class_exists('ntpl')){exit;}?><div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <colgroup>
        <col class="col-xs-2">
        <col class="col-xs-6">
        <col class="col-xs-2">
        </colgroup>
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>File name</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody>
        	<?php $counter1=-1; if( isset($Files) && is_array($Files) && sizeof($Files) ) foreach( $Files as $key1 => $File ){ $counter1++; ?>
            <tr>
            	<td><img class="media-object" src="<?php  echo SITE_BASE;?>Thumbnail/50_50<?php echo $UPLOAD_BASE;?><?php echo $File["media_name"];?>" width="50" height="50" /></td>
            	<td><?php echo $File["media_name"];?></td>
                <td>
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="<?php  echo FILE_BASE;?>manage/edit/<?php echo $File["media_id"];?>/">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="<?php  echo FILE_BASE;?>manage/remove/<?php echo $File["media_id"];?>/">Remove</a>
                </td>
            </tr>
            <?php } ?>
      	</tbody>
  	</table>
</div>