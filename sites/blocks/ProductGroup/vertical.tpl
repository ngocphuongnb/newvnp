<div id="SideTopSeller" class="TopSellers Moveable Panel DefaultModule">
    <div class="defaultTitle SideTopSeller-Title">
    	{if($Config.block_url != '')}
    	<a href="{$Config.block_url}" title="{$BLOCK.block_name}">{$BLOCK.block_name}</a>
        {else}
        <span>{$BLOCK.block_name}</span>
        {/if}
    </div>
    <div class="defaultContent SideTopSeller-content">
        <div class="BlockContent">
            <ul class="ProductList">
            	{for $Product in $Products as $i}
                {if($i == 0)}
                <li class="Odd first">
                    <div class="TopSellerNumber1">{$i+1}</div>
                    <div id="ProductImage" class="ProductImage" style="display: block">
                    	<a class="" href="{$Product.product_url}" title="{$Product.product_title}">
                        	<img src="{$Product.product_thumb}" alt="{$Product.product_title}" title="{$Product.product_title}" />
                       	</a>
                  	</div>
                    <div class="ProductDetails"> <strong><a href="{$Product.product_url}">{$Product.product_title}</a></strong></div>
                    <div class="ProductPrice">
                        <div class="special-price">
                        	<span class="price-label"></span>
                            <span class="price"><em>{$Product.product_price}₫ </em></span>
                       	</div>
                    </div>
                    <hr class="Clear" />
                </li>
                {else}
                <li>
                    <div class="TopSellerNumber">{$i+1}</div>
                    <div class="ProductDetails"><strong><a href="{$Product.product_url}" title="{$Product.product_title}">{$Product.product_title}</a></strong> </div>
                    <div class="ProductPrice">
                        <div class="special-price">
                        	<span class="price-label"></span>
                            <span class="price"><em>{$Product.product_price} ₫ </em></span>
                     	</div>
                    </div>
                    <hr class="Clear" />
                </li>
                {/if}
                {/for}
            </ul>
        </div>
        <div class="Clear"> </div>
    </div>
    <div class="clear defaultFooter SideTopSeller-footer">
        <div> </div>
    </div>
</div>
<span class="hidden"> </span>