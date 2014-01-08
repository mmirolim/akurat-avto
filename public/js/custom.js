function updateCarData() {
    //TODO clean code add checks and update via ajax
    //Prepare array with target elements
    var targets = ['dailymilage','milage'];
    for (var i = 0; i < targets.length; i++) {
        var els = document.getElementsByClassName(targets[i]);
        //Check if elements present
        if(els.length === 0) {return}
        for (var j = 0; j < els.length; j++) {
            //AddEventListeners to target elements
            els[j].addEventListener("click", function(event){
                //Don't insert form twice if element activated
                    var el = event.target;
                    var param = el.getAttribute('class');
                    //Get car id
                    var carId = el.parentNode.parentNode.getAttribute('data-car-id');
                    //Get current property's value
                    var data = el.textContent;
                    //Prepare form
                    var form = '<form class="form-inline-car-update" method="post" action="/cars/updateOwn">';
                    form +='<input name="id" id="id" value="'+ carId +'" type="hidden">';
                    form +='<input name="'+ param +'" id="'+ param +'" value="'+ data +'" type="text">';
                    form +='<input class="button small inline-update-button" value="update" type="submit">';
                    form +='</form>';
                    //Create element to insert after event.target
                    var sibling = document.createElement("span");
                    //Insert form to inside of sibling element
                    sibling.innerHTML = form;
                    //Append sibling
                    el.parentNode.appendChild(sibling);
                    //Hide target element
                    el.style.display = "none";
            });
        }
    }
}

$(window).load(function(){
	$('.flexslider').flexslider({
	animation: "slide",
	controlNav: false,
	directionNav: false,
	})
    updateCarData();
});