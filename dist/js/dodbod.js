$(function(){
	$('.fancybox-thumbs').fancybox({
		prevEffect : 'none',
		nextEffect : 'none',

		closeBtn  : false,
		arrows    : false,
		nextClick : true,

		helpers : {
			thumbs : {
				width  : 50,
				height : 50
			}
		}
	});
 
	/*
	 * Çoklu dosya seçme işlemini gerçekleştiriyoruz
	 * tümü seçilebilir veya tek tek seçilebilir, opsiyonel.
	*/
	$("#tumunu_sec").click(function(){
		$(".eleman_sec").prop('checked', this.checked);
	}); 
	$(".eleman_sec").change(function(){
		var eleman_sec = ($(".eleman_sec").filter(":checked").length == $(".eleman_sec").length);
		$("#tumunu_sec").prop("checked", chec);
	}); 
}); 
function TumunuSec(id)
{
	document.getElementById(id).focus();
	document.getElementById(id).select();
}