<ul class="NodeTypeFromXml">
	<?php foreach( $XmlFiles as $XmlFile) { ?>
    <?php $XmlFileName = basename($XmlFile) ?>
    <li><a href="<?php echo $XmlFileName ?>" title="<?php echo $XmlFileName ?>"><?php echo $XmlFileName ?></a></li>
    <?php } ?>
</ul>
