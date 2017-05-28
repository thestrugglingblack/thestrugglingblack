
/*Custom Scripts for admin panel*/

jQuery( document ).ready(function() {
  jQuery('#select_bg_video_revslider').change(function(){
    if(jQuery(this).val() == 'bg_video'){
      jQuery(".bg_video_inputs_group").fadeIn('slow');
      jQuery(".bg_revslider_inputs_group").fadeOut('slow');
    }else if(jQuery(this).val() == 'bg_revslider'){
      jQuery(".bg_revslider_inputs_group").fadeIn('slow');
      jQuery(".bg_video_inputs_group").fadeOut('slow');
    }else if(jQuery(this).val() == 'bg_image'){
      jQuery(".bg_revslider_inputs_group").fadeOut('slow');
      jQuery(".bg_video_inputs_group").fadeOut('slow');
    }
  });


  if(jQuery('#select_bg_video_revslider option:selected').val() == 'bg_video'){
    jQuery(".bg_video_inputs_group").fadeIn('slow');
    jQuery(".bg_revslider_inputs_group").fadeOut('slow');
  }else if(jQuery('#select_bg_video_revslider option:selected').val() == 'bg_revslider'){
    jQuery(".bg_revslider_inputs_group").fadeIn('slow');
    jQuery(".bg_video_inputs_group").fadeOut('slow');
  }else{
    jQuery(".bg_revslider_inputs_group").fadeOut('slow');
    jQuery(".bg_video_inputs_group").fadeOut('slow');
  }
});