//Update client's own data like personal info and car milage and daily milage
function updateOwnData() {

    //Prepare array with target elements
    var targets = ['dailymilage','milage','contactphone','contactemail','moreinfo'];
    for (var i = 0; i < targets.length; i++) {
        var els = document.getElementsByClassName(targets[i]);
        //Check if elements present
        if(els.length === 0) {return}
        for (var j = 0; j < els.length; j++) {
            //AddEventListeners to target elements
            els[j].addEventListener("click", function(event){
                    //Remove all other inline forms
                    var close = document.getElementsByClassName('inline-close-button');
                    for (var i = 0; i < close.length; i++) {
                        close[i].click();
                    }
                    var el = event.target;
                    var param = el.getAttribute('class');
                    //Get data id
                    var dataId = el.parentNode.parentNode.getAttribute('data-id');
                    //Get current property's value
                    var data = el.textContent;
                    //Prepare form
                    var form = '<div class="form-inline-update">';
                    form +='<input name="id" id="id" value="'+ dataId +'" type="hidden">';
                    //TODO change to textarea for moreinfo data
                    form +='<input name="'+ param +'" id="'+ param +'" value="'+ data +'" type="text">';
                    form +='<input class="button inline-update-button" value="update" type="button" onclick="inlineFormSendData(event);">';
                    form +='<input class="button secondary inline-close-button" value="close" type="button" onclick="inlineFormRemove(event);">';
                    form +='</idv>';
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
function inlineFormRemove(event) {
    event.target.parentNode.parentNode.previousSibling.style.display = 'initial';
    event.target.parentNode.parentNode.remove();
}
function inlineFormSendData(event) {

    //Get target
    var el = event.target;
    var parent = el.parentNode;
    //Get update url
    var url = parent.parentNode.parentNode.parentNode.getAttribute("data-update-url");
    var siblings = parent.childNodes;
    var data = '';
    for (var i = 0; i < (siblings.length - 2); i++) {
        var id = siblings[i].getAttribute("id");
        var value = siblings[i].value;
        data += id + "="+ value +'&';
    }
    //Create xmlhttp
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(data);
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            var obj = JSON.parse(xmlhttp.response);
            var siblingParent = event.target.parentNode.parentNode.previousSibling;
            for (key in obj){
                //Find which parameter changed in obj
                if (key == siblingParent.getAttribute("class")){
                    //Show updated data in message block
                    document.getElementsByClassName('message-block')[0].innerHTML = '<div class="alert-box success">'+key+' updated to '+obj[key]+'</div>';
                    siblingParent.textContent = obj[key];
                }
            }

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
    updateOwnData();
});