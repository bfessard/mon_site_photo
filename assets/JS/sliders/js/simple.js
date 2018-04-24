
$(document).ready(function () {
	var $sliderWrapper = $(".slider-wrapper"),
		$slider = $sliderWrapper.find('.extra-slider');
	$(".extra-slider").extraSlider({
		'navigation': $sliderWrapper.find(".navigation"),
		'pagination': $sliderWrapper.find(".pagination")
	});
});