//FUNCTION GOPAGE >>> THIS FUNCTION IS FOR USE IN CONJUNCTION WITH THE PAGER NAVIGATION
function goPage(url,dd){


	urlstring = new String(url);

	regexp = new RegExp("page", "i")

	if(urlstring.match(regexp)){
		pageregexp = new RegExp("\&page\=.*\&");
		url = urlstring.replace(pageregexp,'&page=' + dd.value + '&');
	}else{
		url += '&page=' + dd.value;
	}	
	
	//alert('url is ' + url);

	window.location = url;
	
}
