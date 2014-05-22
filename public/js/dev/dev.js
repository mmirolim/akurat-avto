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

AK.styleDynatableControls = function() {
    //TODO make it work with many tables per page
    var targets = [];
    targets[".dynatable-search"] = "large-4 columns";
    targets[".dynatable-per-page"] = "large-2 columns";
    $('.dynatable-search')[0].children('input').attr('placeholder','Искать в таблицы ...' );
    for(key in targets) {
        $(key).addClass(targets[key]);
    }

}

AK.formatDates = function(lang){
    moment.lang(lang);
    //Select in once all date elements
    var els = document.querySelectorAll('[class^=date-],[id=table-provided-services] td:nth-child(3)');
    var elsTotal = els.length;
    for (var i = 0; i < elsTotal; i++) {
        var date = els[i].textContent;
        var localDate = moment(date).format('ll');
        els[i].textContent = localDate;
    }
}

