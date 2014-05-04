<?php if(!class_exists('ntpl')){exit;}?><div class="Theme_Containers clearfix">
	<?php $counter1=-1; if( isset($Themes) && is_array($Themes) && sizeof($Themes) ) foreach( $Themes as $key1 => $Theme ){ $counter1++; ?>
    <div class="Theme_Item">
        <a class="View_Demo" href="#5555">Xem demo</a>
        <a href="<?php  echo TEMPLATE_BASE;?>Theme/view/<?php echo $Theme["theme_code"];?>/">
            <img class="media-object" src="<?php echo $THEME_LIBS_DIR;?><?php echo $Theme["directory"];?>/sc.png" width="200" />
            <span class="Theme_Code"><?php echo $Theme["theme_code"];?></span>
        </a>
    </div>
    <?php } ?>
</div>