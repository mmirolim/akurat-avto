//Namespace js functions
//TODO Move all js messages to AK obj, to simplify management
var AK = AK || {
    lang : 'ru',
    targets : [
        { modelProp : 'dailyMilage', htmlClass : 'daily_milage', text : 'Daily milage'},
        { modelProp : 'milage', htmlClass : 'milage', text : 'Milage'},
        { modelProp : 'contactPhone', htmlClass : 'contact_phone', text : 'Contact phone'},
        { modelProp : 'contactEmail', htmlClass : 'contact_email', text : 'Contact Email'},
        { modelProp : 'moreInfo', htmlClass : 'more_info', text : 'Personal information'},
        { modelProp : 'notify', htmlClass : 'notify', text : 'Notification status'},
        { modelProp : 'password', htmlClass : 'password', text : 'Your password'}
    ],
    carServices : ''
};

//Update client's own data like personal info and car milage and daily milage
AK.updateOwnData = function() {

    //Get elements to bind inline ajax update from AK.targets
    var targets = [];
    for (key in AK.targets) {
        //Get all targets by their class names
        targets.push(AK.targets[key]["htmlClass"]);
    }
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
                    switch (param) {
                        case 'password':
                            form +='<label for="current_pass">Your current password</label>';
                            form +='<input name="current_pass" id="current_pass" type="password">';
                            form +='<input name="new_pass" id="new_pass" type="text" autocomplete="off" placeholder="type your new password">';
                            break;
                        case 'notify':
                            if(data == 'Yes') {
                                var checked = 'checked';
                            } else {
                                var checked = '';
                            }
                            form +='<input name="notify" id="notify" type="checkbox" value="'+ data +'"'+ checked +' onClick="'+"$(this).val() == 'Yes' ? $(this).val('No') : $(this).val('Yes');"+'">';
                            break;
                        default :
                             form +='<input name="'+ param +'" id="'+ param +'" value="'+ data +'" type="text">';
                            break;
                    }
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
    event.target.parentNode.parentNode.previousElementSibling.style.display = 'initial';
    event.target.parentNode.parentNode.remove();
}

AK.inlineFormSendData = function(event) {
    //TODO add more comments
    //Get target
    var el = event.target;
    var parent = el.parentNode;
    //Get update url for model
    var url = parent.parentNode.parentNode.parentNode.getAttribute("data-update-url");
    var siblings = parent.children;
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
            var siblingParent = event.target.parentNode.parentNode.previousElementSibling;
            for (key in AK.targets){
                //Find which parameter changed in obj
                if (AK.targets[key]['htmlClass'] == siblingParent.getAttribute("class")){
                    //Set model updated property text
                    var text = AK.targets[key]['text'];
                    var statusMessage = '<div class="alert-box success">'+text+' updated to '+obj[AK.targets[key]["modelProp"]]+'</div>';
                    if (AK.targets[key]["modelProp"] == 'password') {
                        //Show message for password update status
                        if (obj['password'] == 'Success') {
                            statusMessage = '<div class="alert-box success">'+text+' updated Successfully </div>';
                        } else {
                            statusMessage = '<div class="alert-box alert">'+obj['password']+', please verify your current password</div>';
                        }
                    }

                    //Show updated data in message block
                    document.getElementById('message-block').innerHTML = statusMessage;
                    //Set message block display to initial if it was toggled
                    document.getElementById('message-block').style.display = 'initial';
                    //Update text in original element of inline update
                    siblingParent.textContent = obj[AK.targets[key]["modelProp"]];
                    //If milage updated, update data-mlgdate of original element of editing
                    if (AK.targets[key]["modelProp"] == 'milage') {
                        siblingParent.setAttribute("data-milage_date",obj['milageDate']);
                        }
                    }
                }

            siblingParent.style.display = "initial";
            event.target.parentNode.parentNode.remove();
        } else {
            //Show only if xmlhttp status is not OK
            if(xmlhttp.status != 200) {
                document.getElementById('message-block').innerHTML = "<div class='alert-box alert'>Sorry, we can't process your request right now.</div>";
            }
        }
    }
}

//Turn off color code for service if remind status 0
AK.checkRemindStatus = function() {
    //TODO modify to use it after user updates Provided services status to 0 or 1
    var el = document.getElementsByClassName('remind-status');
    for (var i=0; i < el.length; i++){
        if (el[i].textContent == '0') {
            var siblings = el[i].parentNode.children;
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
        id : el.children[0].textContent,
        remindKmStatus : el.children[7].getAttribute("class"),
        remindDateStatus : el.children[8].getAttribute("class")
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
    el.children[7].setAttribute("class",obj.remindKmStatus);
    el.children[8].setAttribute("class",obj.remindDateStatus);
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
        AK.providedServices[rows[i].children[0].textContent] = providedService;
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
        var obj = AK.providedServices[el.children[0].textContent];
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
    //Add appropriate classes to dyna controls
    AK.styleDynatableControls();
    //Automatically restore attributes after each dynatable update
    table.bind("dynatable:afterUpdate",AK.restoreServicesAttr);
    //Restore after initial normalization of dynatable
    AK.restoreServicesAttr();
}
//Style dynatable controls
AK.styleDynatableControls = function() {
    //TODO make it work with many tables per page
    var targets = [];
    targets[".dynatable-search"] = "large-4 columns";
    targets[".dynatable-per-page"] = "large-2 columns";
    var el = $('.dynatable-search');
    el.children('input').attr('placeholder','Искать в таблицы ...' );
    for(key in targets) {
        $(key).addClass(targets[key]);
    }

}

//Add datepicker to appropriate input tags
//TODO use component in datepicker elements
AK.addDatepicker = function () {
    var els = ['#startdate','#finishdate','#reminddate'];
    for (key in els) {
        $(els[key]).datepicker({
            format : 'yyyy-mm-dd'
        });
    }
}
//Format dates from ISO to local
AK.formatDates = function(){
    moment.lang(AK.lang);
    //Select in once all date elements
    var els = document.querySelectorAll('[class^=date-],[id=table-provided-services] td:nth-child(3)');
    var elsTotal = els.length;
    for (var i = 0; i < elsTotal; i++) {
        var date = els[i].textContent;
        //Set required date format
        var localDate = moment(date).format("MMM DD YYYY");
        els[i].textContent = localDate;
    }
}
$(window).load(function(){

    //TODO add appropriate marks to body tag class to identify what functions to initialize

    //Init flexslider
	$('.flexslider').flexslider({ animation: "slide"})

    AK.updateOwnData();
    AK.checkRemindStatus();

    //Format dates from ISO to local before dynatable normalization
    AK.formatDates();

    //TODO create charts from table data
    AK.makeTableSortable("table-provided-services");

    //Call function to add datepicker
    AK.addDatepicker();

});