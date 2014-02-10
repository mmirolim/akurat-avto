<table id="table-provided-services">
    <thead>
    <tr>
        <th>ID</th>
        <th width="85" data-tooltip class="has-tip prs-th" title="Номер Машины">#</th>
        <th data-tooltip class="has-tip prs-th" title="Пробег машины в километрах на момент тех. обслуживания">Пробег</th>
        <th width="100" data-tooltip class="has-tip prs-th" title="Дата проведения тех. обслуживания">Когда</th>
        <th data-tooltip class="has-tip prs-th" title="Тип технического облуживания">Tex. услуга</th>
        <th width="100" data-tooltip class="has-tip prs-th" title="Мастер выполнявший тех. обслуживани">Мастер</th>
        <th data-tooltip class="has-tip prs-th" title="Дополнительная информация">Доп.инф.</th>
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
        <tr class="in-regulation-{{ providedService.getInMs() }}">
            <td>{{ providedService.getId() }}</td>
            <td>{{ car.getRegNumber() }}</td>
            <td>{{ providedService.getMilage() }}</td>
            <td class="date-when">{{ providedService.getStartDate() }}</td>
            <td>{{ carServices[providedService.getServiceId()]['_service'] }}</td>
            <td>{{ employees[providedService.getMasterId()]['_fullname'] }}</td>
            <td>{{ providedService.getInfo() }}</td>
            <td class="km-{{ providedService.getRemindKmStatus(car.getMilage(), car.getDailyMilage(), car.getMilageDate()) }}">
                {{ providedService.getMilageRemind() }}
            </td>
            <td class="date-{{ providedService.getRemindDateStatus() }}">{{ providedService.getRemindDate() }}</td>
            <td class="remind-status">{{ providedService.getRemindStatus() }}</td>
            <td><?= $providedService->getInMs() ? 'Да': '-' ?></td>
            <td>
                {{  this.elements.getEditLinks(providedService.getId(),'providedservices') }}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>