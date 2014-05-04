<?php if(!class_exists('ntpl')){exit;}?><div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" style="text-align:center">
        <colgroup>
        <col class="col-xs-3">
        <col class="col-xs-3">
        <col class="col-xs-3">
        </colgroup>
        <thead>
            <tr>
                <th>Dung lượng đã sử dụng</th>
                <th>Tổng số sản phẩm</th>
                <th>Tổng số tin tức</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<td><canvas id="MemoryUsage" width="200" height="200"></canvas></td>
            	<td><canvas id="ProductStats" width="200" height="200"></canvas></td>
                <td><canvas id="ArticleStats" width="200" height="200"></canvas></td>
            </tr>
      	</tbody>
  	</table>
</div>