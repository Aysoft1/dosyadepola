 
$(function(){
$("#progressbar1").hide();
var bar_1 = $('.progress-bar');
var percent_1 = $('.percent_1');
var status_1 = $('#dosya_sonuc');
$('#form').submit(function() { 
$('#form').ajaxSubmit({
	beforeSend: function() {
	$("#progressbar1").show();
		status_1.empty();
		$("#dosya_sonuc").slideDown().html('<center><img src="./dist/img/yukleniyor/loading2.gif" alt="Yükleniyor..."/></center>');     
		var percentVal_2 = '0%';
		bar_1.width(percentVal_2)
		percent_1.css("width", percentVal_2);
	},
	uploadProgress: function(event, position_2, total_2, percentComplete_2) {
		var percentVal_2 = percentComplete_2 + '%';
		bar_1.width(percentVal_2)
		percent_1.css("width", percentVal_2); 
	},
	success: function() {
		var percentVal_2 = '100%';
		bar_1.width(percentVal_2)
		percent_1.css("width", percentVal_2);
		
	},
	complete: function(xhr) {
		status_1.html(xhr.responseText);
	}
});        
return false; 
});

});
