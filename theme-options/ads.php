<div class="postbox-container">
<div id="column3-sortables" class="meta-box-sortables ui-sortable">
   <div id="dashboard_primary" class="postbox ">
      <div class="handlediv" title="Click to toggle"><br></div>
      <h2 class="hndle ui-sortable-handle"><span><?php _e('Tonjoo News',TONJOO_SIMPLE_ADS) ?></span></h2>
      <div class="inside">
      <div class="ads-box-wrapper">
      <div class="us-postbox">
         <script type="text/javascript">
            jQuery(function(){
               var pluginName = "simple-ads";
               var url = 'https://tonjoostudio.com/jsonp/?promo=get&plugin=' + pluginName;
               var promoFirst = new Array();
               var promoSecond = new Array();

               <?php if(TONJOO_SIMPLE_ADS_ACTIVATED == 'Premium'): ?>
                  var url = 'https://tonjoostudio.com/jsonp/?promo=get&plugin=' + pluginName + '&premium=true';
               <?php endif ?>

               // strpos function
               function strpos(haystack, needle, offset) {
                  var i = (haystack + '')
                     .indexOf(needle, (offset || 0));
                  return i === -1 ? false : i;
               }

               jQuery.ajax({url: url, dataType:'jsonp'}).done(function(data){
                  if(typeof data =='object')
                  {
                     var fristImg, fristUrl;
                     // looping jsonp object
                     jQuery.each(data, function(index, value){
                     <?php if(TONJOO_SIMPLE_ADS_ACTIVATED != 'Premium'): ?>
                     fristImg = pluginName + '-premium-img';
                     fristUrl = pluginName + '-premium-url';
                     // promoFirst
                     if(index == fristImg)
                     {
                        promoFirst['img'] = value;
                     }
                     if(index == fristUrl)
                     {
                        promoFirst['url'] = value;
                     }
                     <?php else: ?>
                     if(! fristImg)
                     {
                     // promoFirst
                     if(strpos(index, "-img"))
                     {
                        promoFirst['img'] = value;
                        fristImg = index;
                     }
                     if(strpos(index, "-url"))
                     {
                        promoFirst['url'] = value;
                        fristUrl = index;
                     }
                  }
                   <?php endif; ?>
                     // promoSecond
                     if(strpos(index, "-img") && index != fristImg)
                     {
                       promoSecond['img'] = value;
                     }
                     if(strpos(index, "-url") && index != fristUrl)
                     {
                        promoSecond['url'] = value;
                     }
                  });
                  //promo_1
                  jQuery("#promo_1 img").attr("src",promoFirst['img']);
                  jQuery("#promo_1 a").attr("href",promoFirst['url']);
                  //promo_2
                  jQuery("#promo_2 img").attr("src",promoSecond['img']);
                  jQuery("#promo_2 a").attr("href",promoSecond['url']);
               }
            });
          });
         </script>
         <div class="inside" style="margin: 14px 14px 6px 14px;">
            <div id="promo_1">
               <a href="https://tonjoostudio.com" target="_blank">
                  <img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/loading-big.gif") ?>" width="100%">
               </a>
            </div>
            <div id="promo_2">
               <a href="https://tonjoostudio.com" target="_blank">
                  <img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/loading-big.gif") ?>" width="100%">
               </a>
            </div>
         </div>
      </div>
      </div>
      </div>
   </div>
</div>
</div>