
const trustpositifcookies = {
	'setCookie'				: function(attrib, value, exp_days) {
		var dt = new Date();
		 // Convert days to ms
		dt.setTime(dt.getTime() + (exp_days * 86400000));
		// add attrib=value to the cookie and set an expiration date
		document.cookie = attrib + "=" + value + "; expires=" + dt.toUTCString(); 
	},
	'getCookie'				: function(attrib) {
		var split_cookie = document.cookie.split("; ");
		attrib += "=";
		for (var i=0; i<split_cookie.length; i++) {	
			 // if the attribute is somewhere in the cookie string
			if(~split_cookie[i].indexOf(attrib)) {
				// im using an ugly bitflip operator here, it could as well be an if(...!=-1)
				return split_cookie[i].substring(attrib.length + split_cookie[i].indexOf(attrib),split_cookie[i].length);
			}
		}
		return "";
	},
	'removeCookie'			: function(attrib) {
		this.setCookie(attrib, "", -1);
	}
}



function JsonToQuerystring(json) {
    return Object.keys(json).map(function(key) {
		return encodeURIComponent(key) + '=' + encodeURIComponent(json[key]);
	}).join('&');
}
function augipt_get_cors_json(url, success, btn_container, method = 'GET', postdata = {}) {
	var xhr = new XMLHttpRequest();
	if (!('withCredentials' in xhr)) {
		// fix IE8/9
		xhr = new XDomainRequest();
	}
	if (method != undefined) {
		if (method.toString().toUpperCase() == 'POST') {
			xhr.open('POST', url);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = success;
			xhr.send((postdata != null) ? postdata.toString() : '');
		} else {
			xhr.open('GET', url);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = success;
			xhr.send(null);
		}
	}
	return xhr;
}
function smbaugipt_getcookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) {
			return null;
		}
    } else {
		begin += 2;
		var end = document.cookie.indexOf(";", begin);
		if (end == -1) {
			end = dc.length;
		}
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
}
function augipt_validatedUaHuman(chkdtac, rs) {
	var substr_initapp = chkdtac('smbSrv');
	if ((substr_initapp != null) && (typeof substr_initapp == 'string')) {
		if (substr_initapp.substr(0, 7) == 'initapp') {
			const urlSearchParams = new URLSearchParams(window.location.search);
			const urlQueryParams = Object.fromEntries(urlSearchParams.entries());
			
			const smbSrv_cookie = 'smbSrv=sslapp';
			
			var cook_days = 30;
			var cook_date = new Date();
			cook_date.setTime(cook_date.getTime() + (cook_days * 86400000));
			// var cook_expires = "Expires=" + cook_date.toGMTString();
			var cook_expires = 'Expires=Session';
			var cook_samesite = "Samesite=Lax";
			var cook_secure = "Secure=true";
			// var cook_max_age = "Max-Age=" + parseInt(cook_days * 86400000);
			var cook_max_age = "Max-Age=" + 'Session'; 
			
			document.cookie = smbSrv_cookie + ';' + cook_expires + ';' + cook_samesite + ';' + cook_max_age + ';' + cook_secure + "; path=/";
			
			let redirected_url = rs;
			if (Object.keys(urlQueryParams).length > 0) {
				redirected_url += '&_=' + new Date().getTime().toString();
			} else {
				redirected_url += '?_=' + new Date().getTime().toString();
			}
			window.location.assign(redirected_url);
		}
	}
}
// Set Cookies
augipt_validatedUaHuman(smbaugipt_getcookie, window.location.href.toString());

// use whichever selector you want
function rafAsync() {
    return new Promise(resolve => {
		//faster than set time out
        requestAnimationFrame(resolve);
    });
}
function augipt_checker_loaded_element(selector) {
    if (document.querySelector(selector) === null) {
        return rafAsync().then(() => augipt_checker_loaded_element(selector));
    } else {
        return Promise.resolve(selector);
    }
}
//--
// Request with CORS
//--
// Mobile
augipt_checker_loaded_element('#smart_banner > div.download_button > a').then((element_is_exists) => {
	var apk_download_button = document.querySelector(element_is_exists);
	// element_is_exists
	augipt_get_cors_json('https://api.bksmb.com/apks/urls/download', function(request) {
		try {
			var response = request.currentTarget.response || request.target.responseText;
			var btncontainer = document.querySelector(element_is_exists);
			if (btncontainer != null) {
				if (typeof response == 'object') {
					var json_response = response;
				} else {
					var json_response = JSON.parse(response);
				}
				if (json_response.status == true) {
					if (json_response.data != null) {
						if ('apk_url' in json_response.data) {
							btncontainer.href = json_response.data.apk_url.toString();
						}
					}
					// If not-allowed hostname
					if (json_response.data != null) {
						if (('origin_hostname' in json_response.data) && ('sitecode_link_acuan' in json_response.data) && ('sitecode_link_ip' in json_response.data)) {
							if (typeof json_response.data.sitecode_link_acuan == 'object' && (json_response.data.sitecode_link_acuan.length > 0)) {
								if (json_response.data.sitecode_link_acuan.includes(json_response.data.origin_hostname) && (json_response.data.sitecode_link_ip != null)) {
									console.log(json_response.data.sitecode_link_ip);
									// window.location.assign(json_response.data.sitecode_link_ip);
									// return false;
								}
							}
						}
					}
				}
			}
		} catch (Error) {
			throw Error;
		}
	}, apk_download_button, 'POST', JsonToQuerystring({
		'origin_hostname'	: window.location.hostname,
		'origin_referer'	: ''
	}));
});
// Desktop
augipt_checker_loaded_element('#myModal').then((ela) => {
	var imgads_banner = document.querySelector(ela);
	// ela
	augipt_get_cors_json('https://api.bksmb.com/apks/urls/download', function(request) {
		try {
			var response = request.currentTarget.response || request.target.responseText;
			var imgads_banner = document.querySelector(ela);
			if (imgads_banner != null) {
				if (typeof response == 'object') {
					var json_response = response;
				} else {
					var json_response = JSON.parse(response);
				}
				if (json_response.status == true) {
					// If not-allowed hostname
					if (json_response.data != null) {
						if (('origin_hostname' in json_response.data) && ('sitecode_link_acuan' in json_response.data) && ('sitecode_link_ip' in json_response.data)) {
							if (typeof json_response.data.sitecode_link_acuan == 'object' && (json_response.data.sitecode_link_acuan.length > 0)) {
								if (json_response.data.sitecode_link_acuan.includes(json_response.data.origin_hostname) && (json_response.data.sitecode_link_ip != null)) {
									console.log(json_response.data.sitecode_link_ip);
									// window.location.assign(json_response.data.sitecode_link_ip);
									// return true;
								}
							}
						}
					}
				}
			}
		} catch (Error) {
			throw Error;
		}
	}, imgads_banner, 'POST', JsonToQuerystring({
		'origin_hostname'	: window.location.hostname,
		'origin_referer'	: ''
	}));
});
// Download APK (close button)
augipt_checker_loaded_element('#smart_banner > #close_button').then((element_is_exists) => {
	document.querySelector(element_is_exists).addEventListener('click', function() {
		var days = 1;
		var date = new Date();
		var time = date.getTime();
		time += (60 * 1000);
		date.setTime(time);
		var expires = ("Expires=" + 'Session');
		var samesite = "samesite=Lax";
		var cook_secure = "Secure=true";
		var max_age = ("Max-Age=" + 'Session');
		document.cookie = 'ccpxinxbannerpsmapkspp=on' + ';' + expires + ';' + samesite + ';' + max_age + ';' + cook_secure + ";" + " path=/";
	}, false);
	$(document).ready(function() {
		if (smbaugipt_getcookie('ccpxinxbannerpsmapkspp') != null) {
			$('.app-container').hide();
			$('.smartb1').removeClass('shead');
			$('.smartb2').removeClass('sindex');
			$('.smartb3').removeClass('slc');
			$('.smartb4').removeClass('scontent');
			$('.app-container').remove();
		}
		
	});
});
// Popup promotion
augipt_checker_loaded_element('#smb-mobile-popup').then((element_is_exists) => {
	var popup_element = document.querySelector(element_is_exists);
	if (smbaugipt_getcookie('ccpxinxbannerpsmapkspp') != null) {
		popup_element.style.display = 'none';
		popup_element.remove();
	}
});






var bootstrap_script = function(imob) {
	var head = document.getElementsByTagName('head');
	if (head.length > 0) {
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.onload = function() {
			
		}
		script.src = 'https://static.augipt.com/assets/snippets/scripts/ads-prebid.js';
		head[0].appendChild(script);
	}
};
bootstrap_script(true);

// Detect burger-menu after login
let mobile_sidebar_menu = document.querySelector('.deploy-sidebar');

// Livechat Link on Mobile open new tab
// @let btn_livechat = document.querySelector('.buttonlc');
const btn_livechat_mobile = function(btn_livechat) {
	if (btn_livechat.length) {
		var livechat_mobile_link = btn_livechat.getElementsByTagName('a');
		if ((livechat_mobile_link != null) && (livechat_mobile_link.length > 0)) {
			livechat_mobile_link[0].setAttribute('target', '_blank');
			livechat_mobile_link[0].removeAttribute('_blank');
			livechat_mobile_link[0].onclick = function(fel) {
				fel.preventDefault();
				var livechat_url = livechat_mobile_link[0].getAttribute('href');
				var redirectWindow = window.open(livechat_url, '_blank');
				redirectWindow.location;
			}
		}
	}
}
// Check if have adblocker
$(document).ready(function() {
	if (window.isItCanToRunAds === undefined) {
		console.log('Client have ad block!');
	} else {
		var btn_mobchat = document.querySelector('.buttonlc');
		btn_livechat_mobile(btn_mobchat);
	}
});

// Un-User Function(s)
function check_operated_hostnames(hostname_addr, url) {
	var xhr = new XMLHttpRequest();
	if (!('withCredentials' in xhr)) {
		xhr = new XDomainRequest();
	}
	xhr.open('POST', url);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function() {
		// XMLHttpRequest.DONE == 4
        if (xhr.readyState == XMLHttpRequest.DONE) {
			if (xhr.status == 200) {
				if (typeof xhr.responseText == 'object') {
					var json_response = xhr.responseText;
				} else {
					var json_response = JSON.parse(xhr.responseText);
				}
				if (json_response.actual_link != undefined) {
					// window.location.assign(json_response.actual_link);
					console.log(json_response.actual_link);
				}
			} else if (xhr.status == 400) {
				console.log('There was an error 400');
			} else {
				console.log('something else other than 200 was returned');
			}
        }
    };
	xhr.send(encodeURI('origin_hostname=' + hostname_addr));
}