<div class="table-responsive">
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
        	{for $File in $Files}
            <tr>
            	<td><img class="media-object" src="{#SITE_BASE}Thumbnail/50_50{$UPLOAD_BASE}{$File.media_name}" width="50" height="50" /></td>
            	<td>{$File.media_name}</td>
                <td>
                	<span class="glyphicon glyphicon-pencil"></span>&nbsp;
                    <a href="{#FILE_BASE}manage/edit/{$File.media_id}/">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                    <a href="{#FILE_BASE}manage/remove/{$File.media_id}/">Remove</a>
                </td>
            </tr>
            {/for}
      	</tbody>
  	</table>
</div>