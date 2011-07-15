<?php
Header("content-type: application/x-javascript");
$request = parse_url($_SERVER['HTTP_REFERER']);

if(!is_authorized($request['host'])):
	return;
endif;

function is_authorized($domain = null){
	return true;
}

echo <<< EOT

if(websitez_mobile_detection_api.insert_mobile_website_footer_override_link)
	window.onload = function(){ document.getElementsByTagName("body")[0].innerHTML += "<div id='websitez_elements'></div>"; }

// this fixes an issue with the old method, ambiguous values
// with this test document.cookie.indexOf( name + "=" );
function websitez_getCookie( check_name ) {
	// first we'll split this cookie up into name/value pairs
	// note: document.cookie only returns name=value, not the other components
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false; // set boolean t/f default f

	for ( i = 0; i < a_all_cookies.length; i++ )
	{
		// now we'll split apart each name=value pair
		a_temp_cookie = a_all_cookies[i].split( '=' );


		// and trim left/right whitespace while we're at it
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

		// if the extracted name matches passed check_name
		if ( cookie_name == check_name )
		{
			b_cookie_found = true;
			// we need to handle case where cookie has no value but exists (no = sign, that is):
			if ( a_temp_cookie.length > 1 )
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
			}
			// note that in cases where cookie is initialized but no value, null is returned
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if ( !b_cookie_found )
	{
		return null;
	}
}
var div = document.getElementsByTagName("head")[0];   
var newScript = document.createElement('script');
newScript.type = 'text/javascript';
var websitez_is_mobile = websitez_getCookie('websitez_is_mobile');

if(websitez_is_mobile == "1")
	newScript.src = 'http://remotedomain.com/is_mobile_functions.php?is_mobile=1';
else
	newScript.src = 'http://remotedomain.com/is_mobile_functions.php';

div.appendChild(newScript);
	
EOT;
?>