<div id="postbox-container-1" class="postbox-container">
<div id="normal-sortables" class="meta-box-sortables ui-sortable">
<div id="spb_setting_dashboard" class="postbox ">
<div class="handlediv" title="Click to toggle"><br></div>
<h2 class="hndle ui-sortable-handle"><span><?php _e("Banners",TONJOO_SIMPLE_ADS) ?></span></h2>
<div class="main">
<div class="repeat section_content">
<div id="" class="wrapper wrapper-banner">
<div id="" class="wrapper wrapper-banner">
   <div class="cont_add_button">
      <span class="button-primary add"><?php _e("Add Banner",TONJOO_SIMPLE_ADS) ?></span>
   </div>
   <div class="container ui-sortable">
      <div class="template row new-row">
         <div class="cont_rm_btn"><span class="remove">&times;</span></div>
         <div class="form-group">
            <label for="title"><?php _e("Title",TONJOO_SIMPLE_ADS) ?></label>
            <input id="title" type="text" name="spb_opt[banner][{{row-count-placeholder}}][title]" placeholder="<?php _e("Banner Title",TONJOO_SIMPLE_ADS) ?>" />
         </div>
         <div class="cont_banner_type form-group">
            <label for="type"><?php _e("Banner Type",TONJOO_SIMPLE_ADS) ?></label>
            <select id="type" class="banner_type" name="spb_opt[banner][{{row-count-placeholder}}][type]">
               <?php  
               foreach ( get_available_banner_types() as $type => $name) {
                  echo '<option value="'.$type.'">'.ucfirst($name).'</option>';
               }
               ?>
            </select>
         </div>
         <div class="form-group">
            <label class="lbpriority" for="priority"><?php _e("Location",TONJOO_SIMPLE_ADS) ?></label>
            <select name="spb_opt[banner][{{row-count-placeholder}}][location]">
               <option value="first"><?php _e("Above article",TONJOO_SIMPLE_ADS) ?></option>
               <option value="last"><?php _e("Below article",TONJOO_SIMPLE_ADS) ?></option>
               <?php
                  for ($j=1; $j <= 15; $j++) { 
                     echo "<option value='$j'>" . __("After paragraph",TONJOO_SIMPLE_ADS) . " $j</option>";
                  }
               ?>               
            </select>
         </div>
         <div class="form-group behaviour-banner-group premium-features">
            <label class="lbpriority" for="behaviour"><?php _e("Behaviours (Available only on PRO version)",TONJOO_SIMPLE_ADS) ?></label>
            <span>
               <input type="checkbox" disabled>
               <span><?php _e("Enable mobile content",TONJOO_SIMPLE_ADS) ?></span>
            </span>
            <span>
               <input type="checkbox" disabled>
               <span><?php _e("Use PHP mobile version instead of Javascript for mobile version (may break cache compability)",TONJOO_SIMPLE_ADS) ?></span>
            </span>
         </div>

         <h2 class="nav-tab-wrapper-origin" id="group-{{row-count-placeholder}}">
            <a class="nav-tab spb-desktop-tab" href='#content-desktop-{{row-count-placeholder}}'><?php _e('Desktop Content',TONJOO_SIMPLE_ADS) ?></a>
            <a class="nav-tab spb-mobile-tab" href='#content-mobile-{{row-count-placeholder}}' style="display:none;" ><?php _e('Mobile Content',TONJOO_SIMPLE_ADS) ?></a>
         </h2>

         <div id="content-desktop-{{row-count-placeholder}}" class="content-desktop-group group-{{row-count-placeholder}}">
            <div class="cont_banner_content form-group">
               <div id="cont_editor_template" class="container_content" data-key="{{row-count-placeholder}}">
                  <textarea id="content_{{row-count-placeholder}}" name="spb_opt[banner][{{row-count-placeholder}}][banner_content]" rows="10"></textarea>
               </div>
            </div>
         </div>
         <div id="content-mobile-{{row-count-placeholder}}" class="content-mobile-group group-{{row-count-placeholder}}">
            <div class="cont_banner_content form-group">
               <div id="cont_editor_template" class="container_content" data-key="{{row-count-placeholder}}">
                  <textarea id="content_{{row-count-placeholder}}" name="spb_opt[banner][{{row-count-placeholder}}][banner_mobile_content]" rows="10"></textarea>
               </div>
            </div>
         </div>
      </div>
      <?php
      if (!empty($spb['banner'])){
      $i = 0;
      foreach ($spb['banner'] as $key => $value) {

      if(! isset($value['type'])) $value['type'] = 'banner';

      ?>
      
      <div class="row">
         <div class="cont_expand_btn">EXPAND</div>
         <div class="cont_rm_btn"><span class="remove">&times;</span></div>
         <div class="form-group">
            <label for="title_<?php echo $i; ?>"><?php _e("Title",TONJOO_SIMPLE_ADS) ?></label>
            <input id="title_<?php echo $i; ?>" type="text" name="spb_opt[banner][<?php echo $i; ?>][title]" value="<?php echo $value['title']; ?>"  placeholder="<?php _e("Banner Title",TONJOO_SIMPLE_ADS) ?>"/>
         </div>
         <div class="cont_banner_type form-group">
            <label for="type_<?php echo $i; ?>"><?php _e("Banner Type",TONJOO_SIMPLE_ADS) ?></label>
            <select id="type_<?php echo $i; ?>" class="banner_type" name="spb_opt[banner][<?php echo $i; ?>][type]">
               <?php  
               foreach ( get_available_banner_types() as $type => $name) {
                  echo '<option value="'.$type.'" '.selected( $value['type'], $type, false ).'>'.ucfirst($name).'</option>';
               }
               ?>
            </select>
         </div>
         <div class="form-group">
            <label class="lbpriority" for="location_<?php echo $i; ?>"><?php _e("Location",TONJOO_SIMPLE_ADS) ?></label>                     
            <select name="spb_opt[banner][<?php echo $i; ?>][location]">
               <option value="first" <?php if($value['location'] == 'first') echo 'selected'; ?> ><?php _e("Above article",TONJOO_SIMPLE_ADS) ?></option>
               <option value="last" <?php if($value['location'] == 'last') echo 'selected'; ?> ><?php _e("Below article",TONJOO_SIMPLE_ADS) ?></option>
               <?php
                  for ($j=1; $j <= 15; $j++) { 
                     $selected = $value['location'] == $j ? 'selected' : '';

                     echo "<option value='$j' $selected >" . __("After paragraph",TONJOO_SIMPLE_ADS) . " $j</option>";
                  }
               ?>               
            </select>
         </div>
         <div class="form-group behaviour-banner-group premium-features">
            <label class="lbpriority" for="behaviour_<?php echo $i; ?>"><?php _e("Behaviours (Available only on PRO version)",TONJOO_SIMPLE_ADS) ?></label>
            <span>
               <input type="checkbox" disabled>
               <span><?php _e("Enable mobile content",TONJOO_SIMPLE_ADS) ?></span>
            </span>
            <span>
               <input type="checkbox" disabled>
               <span><?php _e("Use PHP mobile version instead of Javascript for mobile version (may break cache compability)",TONJOO_SIMPLE_ADS) ?></span>
            </span>
         </div>

         <h2 class="nav-tab-wrapper" id="group-<?php echo $i; ?>">
            <a class="nav-tab spb-desktop-tab" href='#content-desktop-<?php echo $i; ?>'><?php _e('Desktop Content',TONJOO_SIMPLE_ADS) ?></a>
            <a class="nav-tab spb-mobile-tab" href='#content-mobile-<?php echo $i; ?>' style="display:none;" ><?php _e('Mobile Content',TONJOO_SIMPLE_ADS) ?></a>
         </h2>

         <div id="content-desktop-<?php echo $i; ?>" class="content-desktop-group group-<?php echo $i; ?>">
            <?php  
            switch ($value['type']) {
               case 'banner':
                  if(is_array($value['banner_content'])){
                  ?>
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        <div class="shortcode_banner">
                           <div id="img_banner_<?php echo $i; ?>" class="img_banner" data-key="<?php echo $i; ?>" style="background-image:url('<?php echo wp_get_attachment_url( $value['banner_content']['img_id'] ); ?>');"></div>
                           <input type="hidden" id="img_id_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_content][img_id]" value="<?php echo $value['banner_content']['img_id']; ?>">
                           <input type="text" id="link_<?php echo $i; ?>" class="link_banner" name="spb_opt[banner][<?php echo $i; ?>][banner_content][link]" placeholder="Banner Link" value="<?php echo $value['banner_content']['link']; ?>">
                        </div>
                     </div>
                  </div>
                  <?php
                  }
                  break;

               case 'googleads':
                  ?>
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        <textarea id="content_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_content]" rows="10"><?php echo $value['banner_content']; ?></textarea>
                     </div>
                  </div>
                  <?php
                  break;

               case 'shortcode':
                  ?>
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        Shortcode : <input type="text" style="width:inherit;" id="content_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_content]" placeholder="[your_shortcode]" value='<?php echo $value['banner_content']; ?>'>
                     </div>
                  </div>
                  <?php
                  break;

               default:
                  ?> 
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        <textarea class="spb_editor" id="content_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_content]" rows="2"><?php echo $value['banner_content']; ?></textarea>
                     </div>
                  </div>
                  <?php
                  break;
            }

            ?>
         </div>

         <div id="content-mobile-<?php echo $i; ?>" class="content-mobile-group content-group group-<?php echo $i; ?>">
            <?php
            if(! isset($value['banner_mobile_content'])) {
               $value['banner_mobile_content'] = '';
            }

            switch ($value['type']) {
               case 'banner':
                  if(is_array($value['banner_mobile_content'])){
                  ?>
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        <div class="shortcode_banner">
                           <div id="img_banner_<?php echo $i; ?>" class="img_banner" data-key="<?php echo $i; ?>" style="background-image:url('<?php echo wp_get_attachment_url( $value['banner_mobile_content']['img_id'] ); ?>');"></div>
                           <input type="hidden" id="img_id_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_mobile_content][img_id]" value="<?php echo $value['banner_mobile_content']['img_id']; ?>">
                           <input type="text" id="link_<?php echo $i; ?>" class="link_banner" name="spb_opt[banner][<?php echo $i; ?>][banner_mobile_content][link]" placeholder="Banner Link" value="<?php echo $value['banner_mobile_content']['link']; ?>">
                        </div>
                     </div>
                  </div>
                  <?php
                  }
                  break;

               case 'googleads':
                  ?>
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        <textarea id="content_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_mobile_content]" rows="10"><?php echo $value['banner_mobile_content']; ?></textarea>
                     </div>
                  </div>
                  <?php
                  break;

               case 'shortcode':
                  ?>
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        Shortcode : <input type="text" style="width:inherit;" id="content_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_mobile_content]" placeholder="[your_shortcode]" value='<?php echo $value['banner_mobile_content']; ?>'>
                     </div>
                  </div>
                  <?php
                  break;

               default:
                  ?> 
                  <div class="cont_banner_content form-group">
                     <div class="container_content" data-key="<?php echo $i; ?>">
                        <textarea class="spb_editor" id="content_<?php echo $i; ?>" name="spb_opt[banner][<?php echo $i; ?>][banner_mobile_content]" rows="2"><?php echo $value['banner_mobile_content']; ?></textarea>
                     </div>
                  </div>
                  <?php
                  break;
            }

            ?>
         </div>
      </div>

      <?php
      $i++;
      }
     }
     ?>
   </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>