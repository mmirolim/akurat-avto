
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
                    form +='<input class="button small inline-update-button" value="update" type="button" onclick="inlineFormSendData(event);">';
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
function inlineFormSendData(event) {

    //Get target
    var el = event.target;
    var parent = el.parentNode;
    var siblings = parent.childNodes;
    var data = '';
    for (var i = 0; i < (siblings.length - 1); i++) {
        var id = siblings[i].getAttribute("id");
        var value = siblings[i].value;
        data += id + "="+ value +'&';
    }
    //Create xmlhttp
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","/cars/updateOwn",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(data);
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            var obj = JSON.parse(xmlhttp.response);
            var siblingParent = event.target.parentNode.parentNode.previousSibling;
            for (key in obj){
                if (key == siblingParent.getAttribute("class")){
                    var updatedData = obj[key];
                }
            }
            document.getElementsByClassName('message-block')[0].innerHTML = updatedData;
            siblingParent.textContent = updatedData;
            siblingParent.style.display = "initial";
            event.target.parentNode.parentNode.remove();
        }
    }
}
$(window).load(function(){
	$('.flexslider').flexslider({
	animation: "slide",
	controlNav: false,
	directionNav: false
	})
    updateCarData();
});