AK.updateCarData = function () {
	
	//var currentMillageEls = $('.millage');
	//if (currentMillageEls.length === 0) {return}
	var el = $(this).attr('class');
	var form = '<form method="post" action="/cars/updateOwn">';
	form +='<input name="'+ el +'" id="'+ el +'" value="" type="text">';
	form +='<input class="button small inline-update-button" value="update" type="submit">';
	form +='</form>';

}

function updateCarData(el) {
	
	var param = el.attr('class');
	if (el.hasClass("active")) {return}
	var data = el[0].textContent;
	var form = '<form class="form-inline-car-update" method="post" action="/cars/updateOwn">';
	form +='<input name="'+ param +'" id="'+ param +'" value="'+ data +'" type="text">';
	form +='<input class="button small inline-update-button" value="update" type="submit">';
	form +='</form>';
	console.log(form);
	el[0].innerHTML = form;
	el.addClass('active');

}