<ul class="NodeTypeFromXml">
	{for $XmlFile in $XmlFiles}
    {$XmlFileName = $XmlFile|basename}
    <li><a href="{$XmlFileName}" title="{$XmlFileName}">{$XmlFileName}</a></li>
    {/for}
</ul>
