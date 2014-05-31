<?php

function n($str)
{
	echo '<pre>';
	echo '<code class="VNP_CodeBlock">';
	print_r($str);
	echo '</code>';
	echo '</pre>';
}

function p($data)
{
	$str = '<pre><code class="VNP_CodeBlock">';
	$str .= print_r($data, true);
	$str .= '</code></pre>';
	Theme::$Hook['before_body'] .= $str;
}

function VNP_AdminLogPanel($time, $mem) { ?>
	<div class="VNP_SysStat">
        <span class="glyphicon glyphicon-time"></span>&nbsp;Time:&nbsp;<?php echo $time ?> s&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-stats"></span>&nbsp;Memory:&nbsp;<?php echo SizeConverter($mem) ?>
        <?php $DBLog = DB::Log() ?>&nbsp;&nbsp;&nbsp;
        <a href="javascript: VNP_ToggleDBQueryLog();" title="Show/Hide DB Query log">
            <span class="glyphicon glyphicon-share-alt"></span>&nbsp;DB Query:&nbsp;<?php echo $DBLog['total_query'] ?>
        </a>
        <?php if($DBLog['total_query'] > 0): ?>
        <pre id="VNP_DBQueryStatistics" style="display:none">
            <style type="text/css">
			#VNP_DBQueryStatistics {
				white-space: normal;
			}
            #VNP_DBQueryStatistics > div {
                display: block;
                text-align: left;
                font-size: 13px;
                margin: 5px
            }
			#VNP_DBQueryStatistics .label {white-space: normal;line-height: 16px;}
			#VNP_DBQueryStatistics .label .glyphicon {top: 3px}
            </style>
            <?php foreach($DBLog['query'] as $q):
            if($q['status'] == 1) $Class = array('label' => 'success', 'icon' => 'ok');
            else $Class = array('label' => 'danger', 'icon' => 'ban') ?>
            <div class="label label-<?=$Class['label']?>">
                <span class="glyphicon glyphicon-<?=$Class['icon']?>-circle"></span>&nbsp;<?php echo $q['sql'] ?>
            </div>
            <?php endforeach ?>
            <script type="text/javascript">
            function VNP_ToggleDBQueryLog() {
                var list = document.getElementById("VNP_DBQueryStatistics");
                if (list.style.display == "none") list.style.display = "block";
                else list.style.display = "none";
                return false;
            }
            </script>
        </pre>
        <?php endif ?>
    </div>
<?php }
function SizeConverter($size) {
	$unit=array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

?>