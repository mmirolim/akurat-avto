AK.updateCarData = function () {
	
	//var currentMillageEls = $('.millage');
	//if (currentMillageEls.length === 0) {return}
	var el = $(this).attr('class');
	var form = '<form method="post" action="/cars/updateOwn">';
	form +='<input name="'+ el +'" id="'+ el +'" value="" type="text">';
	form +='<input class="button small inline-update-button" value="update" type="submit">';
	form +='</form>';

}

function updateCarData() {

	//TODO clean code add checks and update via ajax
    var targets = ['dailymilage','milage'];
    for (var i = 0; i < targets.length; i++) {
        var els = document.getElementsByClassName(targets[i]);
        if(els.length === 0) {return}
        for (var j = 0; j < els.length; j++) {
            els[j].addEventListener("click", function(event){
                var el = event.target;
                console.log(el);
                var param = el.getAttribute('class');
                if (el.getAttribute("active") === 'yes') {return}
                var carId = el.parentNode.parentNode.getAttribute('data-car-id');
                var data = el.textContent;
                var form = '<form class="form-inline-car-update" method="post" action="/cars/updateOwn">';
                form +='<input name="id" id="id" value="'+ carId +'" type="hidden">';
                form +='<input name="'+ param +'" id="'+ param +'" value="'+ data +'" type="text">';
                form +='<input class="button small inline-update-button" value="update" type="submit">';
                form +='</form>';
                console.log(form);
                el.innerHTML = form;
                el.setAttribute('active','yes');
            });
        }
    }

}
