//Namespace js functions
AK = {

}

//Update client's own data like personal info and car milage and daily milage
AK.updateOwnData = function() {

    //Prepare array with target elements
    var targets = ['dailymilage','milage','contactphone','contactemail','moreinfo'];
    for (var i = 0; i < targets.length; i++) {
        var els = document.getElementsByClassName(targets[i]);
        //Check if elements present
        if(els.length === 0) {return}
        for (var j = 0; j < els.length; j++) {
            //Add class to inline updatable elements
            els[j].setAttribute("data-updatable","yes");
            els[j].setAttribute("title","Обновить данные")
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
                    form +='<input class="button inline-update-button" value="update" type="button" onclick="AK.inlineFormSendData(event);">';
                    form +='<input class="button secondary inline-close-button" value="close" type="button" onclick="AK.inlineFormRemove(event);">';
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
AK.inlineFormRemove = function(event) {
    event.target.parentNode.parentNode.previousSibling.style.display = 'initial';
    event.target.parentNode.parentNode.remove();
}

AK.inlineFormSendData = function(event) {
    //TODO add more comments
    //Get target
    var el = event.target;
    var parent = el.parentNode;
    //Get update url for model
    var url = parent.parentNode.parentNode.parentNode.getAttribute("data-update-url");
    var siblings = parent.childNodes;
    var data = '';
    //Prepare data to send
    for (var i = 0; i < (siblings.length - 2); i++) {
        //Get  model property name to update and id property
        var id = siblings[i].getAttribute("id");
        //Get new value for model property and model id
        var value = siblings[i].value;
        data += id + "="+ value +'&';
    }
    //Create xmlhttp
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(data);
    xmlhttp.onreadystatechange = function(){
        //If status OK
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            var obj = JSON.parse(xmlhttp.response);
            //Get original element of inline update, previous sibling of current target's parent
            var siblingParent = event.target.parentNode.parentNode.previousSibling;
            for (key in obj){
                //Find which parameter changed in obj
                if (key == siblingParent.getAttribute("class")){
                    //Show updated data in message block
                    document.getElementsByClassName('message-block')[0].innerHTML = '<div class="alert-box success">'+key+' updated to '+obj[key]+'</div>';
                    //Set message block display to initial if it was toggled
                    document.getElementsByClassName('message-block')[0].style.display = 'initial';
                    //Update text in original element of inline update
                    siblingParent.textContent = obj[key];
                    //If milage updated, update data-mlgdate of original element of editing
                    if (key == 'milage') {
                        siblingParent.setAttribute("data-mlgdate",obj["mlgdate"]);
                        }
                    }
                }

            siblingParent.style.display = "initial";
            event.target.parentNode.parentNode.remove();
        }
    }
}

//Turn off color code for service if remind status 0
AK.checkRemindStatus = function() {
    //TODO modify to use it after user updates Provided services status to 0 or 1
    var el = document.getElementsByClassName('remind-status');
    for (var i=0; i < el.length; i++){
        if (el[i].textContent == '0') {
            var siblings = el[i].parentNode.childNodes;
            for(var j = 0; j < siblings.length; j++) {
                siblings[j].parentNode.setAttribute("status-of-prs","0");
            }
        }}
}

//Create an obj properties from required attributes in provided service row
//TODO make it work with any table and attributes
AK.getProvidedServiceAttr = function(el) {
    //Prepare obj from attributes of child elements in provided service row
    var obj = {
        statusOfPrs : el.getAttribute('status-of-prs'),
        id : el.childNodes[0].textContent,
        remindKmStatus : el.childNodes[8].getAttribute("class"),
        remindDateStatus : el.childNodes[9].getAttribute("class")
    }
    //Return obj to store
    return obj
}
//Restore provided attributes to provided services row from obj
//TODO make it work with any table and attributes
AK.setProvidedServiceAttr = function(el,obj){
    if (obj.statusOfPrs) {
        el.setAttribute('status-of-prs', obj.statusOfPrs);
    }
    el.childNodes[8].setAttribute("class",obj.remindKmStatus);
    el.childNodes[9].setAttribute("class",obj.remindDateStatus);
}

//Store all provided services as obj in array
//TODO store data in jQuery Data
AK.providedServices = [];

//Backup provided services row attributes before dynatable runs
//TODO make it work with any table
AK.backUpServiceAttr = function () {
    var table = document.getElementById('table-provided-services');
    var rows = table.children;
    rows = rows[1].children;
    var rowsLength = rows.length;
    for(var i = 0; i < rowsLength; i++) {
        //Get obj from row children attributes
        var providedService = AK.getProvidedServiceAttr(rows[i]);
        AK.providedServices[rows[i].childNodes[0].textContent] = providedService;
    }
}
//Callback function to restore attributes in provided services row
//TODO make it work with any table
AK.restoreServicesAttr = function(){
    var table = document.getElementById('table-provided-services');
    var rows = table.children;
    rows = rows[1].children;
    var rowsLength = rows.length;
    for(var i = 0; i < rowsLength; i++) {
        var el = rows[i];
        //Get appropriate stored service attributes as obj according to key
        var obj = AK.providedServices[el.childNodes[0].textContent];
        //Restore service attributes
        AK.setProvidedServiceAttr(el,obj);
    }
}
//TODO make any table sortable and attributees restorable
AK.makeTableSortable = function(tableId) {
    if(!document.getElementById(tableId)) {
        console.log("No such tableID");
        return
    }
    //Backup service attributes from provided services table
    AK.backUpServiceAttr();
    //Make provided services table sortable with dynatable js
    //TODO make work with multiple tables on one page
    var table = $('#'+tableId).dynatable();
    //Automatically restore attributes after each dynatable update
    table.bind("dynatable:afterUpdate",AK.restoreServicesAttr);
    //Restore after initial normalization of dynatable
    AK.restoreServicesAttr();
}
$(window).load(function(){

    //TODO add appropriate marks to body tag class to identify what functions to initialize

    //Init flexslider
	$('.flexslider').flexslider({ animation: "slide"})

    AK.updateOwnData();
    AK.checkRemindStatus();

    AK.makeTableSortable("table-provided-services");

});