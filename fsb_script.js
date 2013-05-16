/** Options **/
var fontMax = 18; // maximum font size in pixels
var fontMin = 10; // minimum font size in pixels

$(document).ready(function() {
	jQuery('.font-size-smaller').click(	function () { change_font_size(-1);});
	jQuery('.font-size-default').click(	function () { change_font_size(0);});
	jQuery('.font-size-bigger').click(	function () { change_font_size(1);});

	//check wether the user has changed the font size before
	if(get_fsb_cookie('fsb_font_size') !== null) {
		var fontSize = parseFloat(get_fsb_cookie('fsb_font_size'));
		console.log('found cookie, setting font size to ' + fontSize);
		$('body').css('font-size', fontSize);

	//save the default font size, so we can access it later
	} else if ( get_fsb_cookie('fsb_default_font_size') === null ){
		console.log('setting default cookie');
		var defaultFontSize = parseFloat( $('body').css('font-size') );
		set_fsb_cookie('fsb_default_font_size', defaultFontSize);
	}

});

function set_fsb_cookie(name, value) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + 10);
	var c_value=escape(value) + "; expires="+exdate.toUTCString() +"; path=/";
	document.cookie= name + "=" + c_value;
}


function get_fsb_cookie(c_name) {
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");

	if (c_start == -1)
	{
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1)
	{
		c_value = null;
	}
	else
	{
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1)
		{
			c_end = c_value.length;
		}
			c_value = unescape(c_value.substring(c_start,c_end));
		}
	return c_value;
}

/**
 * Change the font size of body if value is between given limits
 * @param  {float} step steps to increase/decrease font size. 0 sets font size to default
 */
function change_font_size(step) {
	//if step is zero, set default font size
	if(step === 0) {
		var defaultFontSize = parseFloat( get_fsb_cookie('fsb_default_font_size') );
		$('body').css('font-size', defaultFontSize);
	} else {
		var currentFontSize = parseFloat( $('body').css('font-size') );
		var newFontSize = currentFontSize+step;
		if(newFontSize<=fontMax && newFontSize>=fontMin) {
			$('body').css('font-size', newFontSize);
			set_fsb_cookie('fsb_font_size', newFontSize);
		}
	}
}