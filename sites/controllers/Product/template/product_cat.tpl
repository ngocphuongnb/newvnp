<div id="HomeFeaturedProducts" class="Block FeaturedProducts DefaultModule">
    <div class="defaultTitle TitleContent">
        <span>{$Category.product_category_title}</span>
  	</div>
    <div class="defaultContent BlockContent clearfix">
        <ul class="ProductList clearfix">
        	{for $Product in $Products}
            <li>
                <div id="ProductImage" class="ProductImage ProductImageTooltip">
                	<a href="#" title="{$Product.product_title}">
                    	<img alt="{$Product.product_title}" title="{$Product.product_title}" src="{$Product.product_thumb}">
                   	</a>
               	</div>
                <div class="saleFlag iconSprite disable"></div>
                <div class="ProductDetails"><strong><a href="#" title="{$Product.product_title}">{$Product.product_title}</a></strong></div>
                <div class="ProductPrice">
                    <div class="special-price">
                    	<span class="price-label"></span><span class="price"><em>{$Product.product_price}</em></span>
                   	</div>
                </div>
                <div class="ProductRating Rating-1" style="display: ;">
                    <div class="RatingImage"></div>
                </div>
                <div class="ProductActionAdd"><a href="#"><span>Mua hàng</span></a></div>
            </li>
            {/for}
            <br class="clearfix" />
        </ul>
    </div>
    <div class="defaultFooter FooterContent">
        <div></div>
    </div>
    <div class="Clear"></div>
</div>