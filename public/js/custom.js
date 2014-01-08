function updateCarData(el) {
	//TODO clean code add checks and update via ajax
	var param = el.attr('class');
	if (el.hasClass("active")) {return}
	var carId = el.parent().parent().attr('data-car-id');
	var data = el[0].textContent;
	var form = '<form class="form-inline-car-update" method="post" action="/cars/updateOwn">';
	form +='<input name="id" id="id" value="'+ carId +'" type="hidden">';
	form +='<input name="'+ param +'" id="'+ param +'" value="'+ data +'" type="text">';
	form +='<input class="button small inline-update-button" value="update" type="submit">';
	form +='</form>';
	console.log(form);
	el[0].innerHTML = form;
	el.addClass('active');

}

$(window).load(function(){
	$('.flexslider').flexslider({
	animation: "slide",
	controlNav: false,
	directionNav: false,
	})
});