<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $name ?></h3>
    </div>
    <div class="panel-body">
        <form method="<?php echo $config['method'] ?>" action="<?php echo $config['action'] ?>">
        	<?php foreach($config['tokens'] as $token) { ?>
            <input type="hidden" name="<?php echo $token['name'] ?>" value="<?php echo $token['value'] ?>" />
            <?php } ?>
            <a href="javascript:window.history.go(-1); return false;" class="btn btn-default">Cancel</a>&nbsp;&nbsp;
            <input type="submit" class="btn btn-danger" value="Confirm" />
        </form>
    </div>
</div>