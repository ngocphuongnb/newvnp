<div class="ProductDetailContainer DetailItem DefaultModule">
    <div id="ProductDetails" class="PrimaryProductDetails">
        <div class="BlockContent">
            <div class="product-title defaultTitle">
                <h1>{$Product.product_title}</h1>
            </div>
            <div class="ProductThumb" style="overflow: visible; width: 230px; height: 286px;">
                <div class="ProductThumbImage" style="width: 220px; height: 220px; text-align:center; overflow:visible;">
                    <a rel="prodImage" style="margin: auto;" href="#" title="{$Product.product_title}">
                        <div class="zoomPad">
                        	<img src="{$Product.product_thumb}" alt="{$Product.product_title}" title="{$Product.product_title}" style="opacity: 1;"/>
                      	</div>
                    </a>
                </div>
                <div id="slideShow" class="ImageCarouselBox" style="margin: 10px auto 0px; padding-left: 58px;">
                    
                </div>
            </div>
            <div class="ProductMain">
                <div class="ProductDetailsGrid">          
                    <div class="DetailRow">
                        <div class="Label PriceLabel">
                            Giá bán
                            <em class="ProductPrice">
                                </em><span>:</span></div>
                        <div class="Label PriceByRuleLabel" style="display: none;">
                            Giá bán:</div>
                        <div class="Value">
                            <em class="ProductPrice VariationProductPrice">
                                {$Product.product_price} ₫</em>
                        </div>
                    </div>
                    
                    <div class="DetailRow">
                        <div class="Label">
                            &nbsp;</div>
                        <div class="Value">
                            <em class="VariationProductVAT">
                                {$Product.price_detail}</em>
                        </div>
                    </div>
                    
                    <div class="DetailRow ProductSKU">
                        <div class="Label">
                            Mã sản phẩm<span>:</span>
                        </div>
                        <div class="Value">
                            <span class="VariationProductSKU">
                                {$Product.product_code}</span>
                        </div>
                    </div>
                    
                    
                    <div class="DetailRow">
                        <div class="Label">
                            Số lượng đã bán<span>:</span>
                        </div>
                        <div class="Value">
                            0
                        </div>
                    </div>
                    
                    <div style="display: ;" class="DetailRow">
                        <div class="Label">
                            Đánh giá<span>:</span>
                        </div>
                        <div class="Value">
                            <div class="ProductRating Rating-1"><div class="RatingImage"></div></div>
                        </div>
                    </div>
                    
                    <div style="display: ;" class="DetailRow">
                        <div class="Label">
                            Phí vận chuyển<span>:</span></div>
                        <div class="Value">
                            Tính phí khi thanh toán
                        </div>
                    </div>
                    
                </div>
                <input id="checkOptionRule" type="hidden" value="0">         
                <div class="ProductDetailsGrid ProductAddToCart">
                    <div class="DetailRow">
                        <div class="Label QuantityInput">
                            Số lượng<span>:</span></div>
                        <div class="Value AddCartButton">
                            <div>
                                <input name="" type="text" id="" style="width: 50px;" class="Field45 quantityInput NormalTextBox" maxlength="3" value="1">
                            </div>
                            <div id="BulkDiscount" class="BulkDiscount">
                                <a id="bulk" class="ProductAdd" rel="nofollow" href="#">
                                    <span>Mua hàng</span> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="ProductDetailsGrid">
                    <div class="DetailRow">
                        <div class="Label">
                        </div>
                        <div class="Value">
                        </div>
                    </div>
                </div>
                
            </div>
            
            <br class="Clear">
            <hr>
            <div class="Panel" id="ProductTabs">
                <ul class="TabNav" id="ProductTabsList">
                    <li id="ProductDescription_Tab" class="Active">
                        <a onclick="ActiveProductTab('ProductDescription_Tab'); return false;" href="#">
                            Thông tin
                        </a>
                    </li>
                    <li id="ProductReviews_Tab" class="">
                        <a onclick="ActiveProductTab('ProductReviews_Tab'); return false;" href="#">
                            Đánh giá
                        </a>
                    </li>
                    
                </ul>
            </div>
            <div id="ProductDescription" class="Block Panel ProductDescription" style="display: block; overflow: hidden;">
                <div class="ProductDescriptionContainer">
                    
                </div>
            </div>
            <div id="ProductArticleReview" class="Block Panel ProductDescription" style="display: none;">
                <div class="ProductDescriptionContainer">
                    
                </div>
            </div>
            <div id="ProductRelatedProducts" style="display: none;" class="Block Panel">
                
                <div class="Clear">
                </div>
            </div>
            <div id="ProductReviews" class="Block Panel" style="display: none;">

            </div>
            <div id="ProductVideos" class="Block Panel" style="display: none;">
                <div class="VideoContainer">
                    <div id="youtubeLeftBox" class="youtubeVideoListBox" style="width: 100%; text-align: center;
                        border: none; height: 435px; overflow: hidden;">
                        
                    </div>
                    <div class="Clear">
                    </div>
                    <div id="youtubeRightBox" class="youtubeVideoListBox" style="width: 100%;">
                        <ul id="youTubeCurrentVideos" class="ui-sortable">
                            
                        </ul>
                    </div>
                </div>
                <div class="Clear">
                </div>
            </div>
            <div id="ProductFeatures" class="Block Panel" style="display: none;">
                <div class="BlockContent">
                    <div class="item-container">
                        
                    </div>
                </div>
                <div class="Clear"></div>
            </div>
            
        </div>
    </div>
    <hr class="Clear">
    <div class="clear defaultFooter product-footer">
    </div>
</div>