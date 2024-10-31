jQuery(document).ready(function() {
	
	jQuery('.ntp-wl-setting-tabs').on('click', '.ntp-wl-tab', function(e) {
		e.preventDefault();
		var id = jQuery(this).attr('href');
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.ntp-wl-setting-tabs-content .ntp-wl-setting-tab-content').removeClass('active');
		jQuery('.ntp-wl-setting-tabs-content').find(id).addClass('active');
	});

});
 
