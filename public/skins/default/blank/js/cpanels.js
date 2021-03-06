$(document).ready(function(){
	
	$("#searchbox").focus(function() {
		$(this).parent().addClass("curfocus");
		$(this).addClass("largebox");
	});

	$("#searchbox").blur(function() {
		$(this).parent().removeClass("curfocus");
		$(this).removeClass("largebox");
	});
	
	//Custom Action button inside the list of the records
	$(".chkdomain").click( 
		function () {
			if($('.domainame').val()){
				$.post('/common/checkdomain/', {name: $('.domainame').val(), tld: $('.tld').val()}, 
					function(data){
						if(data.available){
							$('#result').removeClass('big-notavailable');
							$('#result').addClass('big-available');
							$('a.ordernow').attr('href', '/domains/buy/tld/' + data.tld + '/name/' + data.name + '/do/register');
						}else{
							$('#result').removeClass('big-available');
							$('#result').addClass('big-notavailable');
							$('a.ordernow').attr('href', '/domains/buy/tld/' + data.tld + '/name/' + data.name + '/do/transfer');
						}
						$('#result').show();
						$('.price').html(data.price);
						$('.domain').html(data.domain);
						$('.message').html(data.mex);
						
					}, 'json');
			}
			return false;
		}
	);
	
	tinyMCE.baseURL='/resources/js/wysiwyg/tiny_mce'; // your path to tinyMCE
    tinyMCE.init({
        // General options
    	mode : "specific_textareas",
        editor_selector : "wysiwyg",
        theme : "simple",
        width : "900",
        height : "400",
        convert_urls : false
    });
    
}); 