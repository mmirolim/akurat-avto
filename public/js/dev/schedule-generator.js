getServices = function () {
    $select = document.createElement('select');
    for (var i = 0; i < carServices.length; i++) {
        var option = document.createElement('option');
        option.setAttribute('value',carServices[i].id);
        option.textContent = carServices[i].name;
        $select.appendChild(option);
    }
    return $select;
}
setClassFirstInterval = function () {
    var el = document.getElementById('first-interval');
    var data = document.getElementById('first-interval-value').value;
    data = data.split('/');
    console.log(data);
    el.setAttribute('class','interval-'+data[0]+'-'+data[1]);
}

genIntervals = function () {

    var el = document.getElementById('interval-row');
    el.remove();
    el = document.createElement('tr');
    el.setAttribute('id','interval-row');
    var thead = document.getElementsByClassName('thead-table-schedule')[0];
    thead.appendChild(el);
    var intervalKm = document.getElementById('interval-km').value;
    var intervalMonth = document.getElementById('interval-month').value;
    var intervalNumber = document.getElementById('interval-number').value;
    //Check input type should be integers
    intervalKm = parseInt(intervalKm);
    intervalMonth = parseInt(intervalMonth);
    intervalNumber = parseInt(intervalNumber)
    var km = intervalKm;
    var mon = intervalMonth;
    var $thService = document.createElement('th');
    $thService.setAttribute('id','th-service');
    $thService.textContent = 'Services';
    var $th = document.createElement('th');
    $th.setAttribute('id','first-interval');
    var input = document.createElement('input');
    /* function setAttributes(el, attrs) {
        for(var key in attrs) {
        el.setAttribute(key, attrs[key]);
      }
    }
    setAttributes(elem, {"src": "http://example.com/something.jpeg", "height": "100%", ...});
    */
    input.setAttribute('type','text');
    input.setAttribute('id', 'first-interval-value');
    $th.appendChild(input);
    el.appendChild($thService);
    el.appendChild($th);
    for (var i = 0; i < intervalNumber; i++) {
        $th = document.createElement('th');
        $th.setAttribute('class','interval-'+km+'-'+ mon);
        $th.textContent = km + 'км/' + mon +'мес';
        km += intervalKm;
        mon += intervalMonth;
        el.appendChild($th);
    }
    input.setAttribute('onChange',"this.parentNode.setAttribute('class','interval-'+this.value.split('/')[0]+'-'+this.value.split('/')[1]);");

}
addService = function () {
    console.log('Clicked');
    var table = document.getElementsByClassName('table-schedule')[0];
    var tr = document.getElementById('interval-row');
    var count = tr.childElementCount - 1;
    var $span = document.createElement('span');
    $span.setAttribute('class','remove-row');
    $span.addEventListener('click', function (event) {
        event.target.parentNode.parentNode.remove();
    });
    $span.textContent = 'Del';
    var $select = getServices();
    var $td = document.createElement('td');
    var $tr = document.createElement('tr');
    $td.appendChild($span);
    $td.appendChild($select);
    $tr.appendChild($td);
    var selectTask = '<select><option value="N"></option><option value="I">I</option><option value="R">R</option></select>';
    for (var i = 0; i < count; i++) {
        $td = document.createElement('td');
        $td.innerHTML = selectTask;
        $tr.appendChild($td);
    }
    table.appendChild($tr);
}
var addServiceBtn = document.getElementById('add-service-button');
addServiceBtn.addEventListener('click',addService);
var el = document.getElementById('generate-intervals');
el.addEventListener('click', genIntervals);