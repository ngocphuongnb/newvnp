<?php if(!class_exists('ntpl')){exit;}?><div class="AdminPanel">
	<form action="<?php  echo ADMIN_BASE;?>Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="SwitchDesignMod" value="1" />
        <input type="hidden" name="CurrentState" value="<?php echo $CurrentState;?>" />
    	<input type="submit" class="SWTDesignModBTn" value="<?php if( $InDesignMod ){ ?>Turn off design mode<?php }else{ ?>Turn on design mode<?php } ?>" />
    </form>
    <?php if( $InDesignMod ){ ?>
    <form action="<?php  echo ADMIN_BASE;?>Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="SaveAndQuit" value="1" />
        <input type="hidden" name="CurrentState" value="<?php echo $CurrentState;?>" />
        <input type="submit" name="SaveDesign" class="SaveDesign" value="Save and quit design mode" />
    </form>
    <form action="<?php  echo ADMIN_BASE;?>Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="SaveAndContinue" value="1" />
        <input type="hidden" name="CurrentState" value="<?php echo $CurrentState;?>" />
        <input type="submit" name="SaveDesign" class="SaveDesign" value="Save and continue Design" />
    </form>
    <form action="<?php  echo ADMIN_BASE;?>Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="LoadCurrentDesign" value="1" />
        <input type="hidden" name="CurrentState" value="<?php echo $CurrentState;?>" />
        <input type="submit" name="ResteDesign" class="SaveDesign" value="Load current Design" />
    </form>
    <?php } ?>
</div>

<style type="text/css">
body {padding-top:40px}
.AdminPanel {
	height:35px;
	width:100%;
	background: #EFEFEF;
	position: fixed;
	top: 0;
	border-bottom:1px solid #C9BFCB;
	z-index:2
}
.SWTDesignModBTn, .SaveDesign {
	height: 25px;
	margin: 5px 10px 4px 0;
	float: right;
}
</style>
