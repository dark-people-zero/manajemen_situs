(function($) {
	"use strict";

	//P-scrolling

	if ($('.chat-scroll').length > 0) {
        const ps2 = new PerfectScrollbar('.chat-scroll', {
        useBothWheelAxes:true,
        suppressScrollX:true,
        });
    }
	if ($('.Notification-scroll').length > 0) {
        const ps3 = new PerfectScrollbar('.Notification-scroll', {
        useBothWheelAxes:true,
        suppressScrollX:true,
        });
    }



})(jQuery);
