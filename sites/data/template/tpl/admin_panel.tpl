<div class="AdminPanel">
	<form action="{#ADMIN_BASE}Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="SwitchDesignMod" value="1" />
        <input type="hidden" name="CurrentState" value="{$CurrentState}" />
    	<input type="submit" class="SWTDesignModBTn" value="{if($InDesignMod)}Turn off design mode{else}Turn on design mode{/if}" />
    </form>
    {if($InDesignMod)}
    <form action="{#ADMIN_BASE}Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="SaveAndQuit" value="1" />
        <input type="hidden" name="CurrentState" value="{$CurrentState}" />
        <input type="submit" name="SaveDesign" class="SaveDesign" value="Save and quit design mode" />
    </form>
    <form action="{#ADMIN_BASE}Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="SaveAndContinue" value="1" />
        <input type="hidden" name="CurrentState" value="{$CurrentState}" />
        <input type="submit" name="SaveDesign" class="SaveDesign" value="Save and continue Design" />
    </form>
    <form action="{#ADMIN_BASE}Design/SwitchDesignMod/" method="post">
    	<input type="hidden" name="LoadCurrentDesign" value="1" />
        <input type="hidden" name="CurrentState" value="{$CurrentState}" />
        <input type="submit" name="ResteDesign" class="SaveDesign" value="Load current Design" />
    </form>
    {/if}
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
