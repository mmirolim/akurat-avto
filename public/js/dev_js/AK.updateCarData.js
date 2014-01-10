AK.getProvidedServiceAttr = function(el) {
    var obj = {
        statusOfPrs : el.getAttribute('status-of-prs'),
        id : el.childNodes[0].textContent,
        remindKmStatus : el.childNodes[8].getAttribute("class"),
        remindDateStatus : el.childNodes[9].getAttribute("class")
    }
    return obj
}
AK.setProvidedServiceAttr = function(el,obj){
        if (obj.statusOfPrs) {
            el.setAttribute('status-of-prs', obj.statusOfPrs);
        }
        el.childNodes[8].setAttribute("class",obj.remindKmStatus);
        el.childNodes[9].setAttribute("class",obj.remindDateStatus);
}

//TODO store data in jQuery Data
AK.providedServices = [];
AK.backUpServiceAttr = function () {
    var table = document.getElementById('table-provided-services');
    var rows = table.children;
    rows = rows[1].children;
    var rowsLength = rows.length;
    for(var i = 0; i < rowsLength; i++) {
        var providedService = AK.getProvidedServiceAttr(rows[i]);
        console.log(rows[i].childNodes[0].textContent);
        AK.providedServices[rows[i].childNodes[0].textContent] = providedService;
    }
}
AK.restoreServicesAttr = function(){
    var table = document.getElementById('table-provided-services');
    var rows = table.children;
    rows = rows[1].children;
    var rowsLength = rows.length;
    for(var i = 0; i < rowsLength; i++) {
        var el = rows[i];
        var obj = AK.providedServices[el.childNodes[0].textContent] ;
        AK.setProvidedServiceAttr(el,obj);
    }
}