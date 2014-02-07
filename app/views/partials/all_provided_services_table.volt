<table id="table-provided-services">
    <thead>
    <tr>
        <th>ID</th>
        <th width="85" data-tooltip class="has-tip prs-th" title="Номер Машины">#</th>
        <th width="100" data-tooltip class="has-tip prs-th" title="Дата проведения тех. обслуживания">Когда</th>
        <th data-tooltip class="has-tip prs-th" title="Тип технического облуживания">Tex. услуга</th>
        <th data-tooltip class="has-tip prs-th" title="Пробег машины в километрах на момент тех. обслуживания">Пробег</th>
        <th width="100" data-tooltip class="has-tip prs-th" title="Мастер выполнявший тех. обслуживани">Мастер</th>
        <th data-tooltip class="has-tip prs-th" title="Дополнительная информация">Заметка</th>
        <th data-tooltip class="has-tip prs-th" title="Напоминание о необходимости провести тех. осмотр после КМ">КМ</th>
        <th width="120" data-tooltip class="has-tip prs-th" title="Напоминание о необходимости провести тех. осмотр после Даты">Дата</th>
        <th class="remind-status-th prs-th">Статус напоминания</th>
        <th data-tooltip class="has-tip prs-th" title="Входит в технический регламент по обслуживанию автомобиля">Тех.рег.</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    {# Get all provided services by car ordered by start date #}
    {% for providedService in providedServices %}
        {% set car = providedService.Cars %}
        <tr class="in-regulation-{{ providedService.inMs }}">
            <td>{{ providedService.id }}</td>
            <td>{{ car.regNumber }}</td>
            <td class="date-when">{{ providedService.startDate }}</td>
            <td>{{ carServices[providedService.serviceId]['service'] }}</td>
            <td>{{ providedService.milage }}</td>
            <td>{{ employees[providedService.masterId]['fullname'] }}</td>
            <td>{{ providedService.moreInfo }}</td>
            <td class="km-{{ providedService.getRemindKmStatus(car.milage, car.dailyMilage, car.milageDate) }}">{{ providedService.getMilageRemind() }}</td>
            <td class="date-{{ providedService.getRemindDateStatus() }}">{{ providedService.remindDate }}</td>
            <td class="remind-status">{{ providedService.remindStatus }}</td>
            <td><?= $providedService->inMs ? 'Да': '-' ?></td>
            <td>
                {{  this.elements.getEditLinks(providedService.id,'providedservices') }}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>