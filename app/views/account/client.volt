<div id="content" class="account-view-content row">
    <div class="large-8 columns services-block">
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
            </tr>
            </thead>
            <tbody>
            {% for car in client.cars %}
            {# Get all provided services by car ordered by start date #}
                {% for providedService in car.getProvidedServices() %}
                    <tr>
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
                    </tr>
                {% endfor %}
            {% endfor %}
            </tbody>
        </table>
    </div>
    <div class="large-4 columns analytics-block">
        <div class="analytics-board">
            {% for key, car in client.cars %}
                {# Create div block per car #}
                <div class="analytic-data">
                    <h5 class="label radius secondary car-regnum">{{ car.regNumber }} - {{ car.carModels.name }}</h5>
                    <div class="total-health">
                        <h5>Total Health</h5>
                        <span id="car-health" class="label radius success">{{ car.getHealth() }}%</span>
                    </div>
                    <div class="show-issues">
                        <h5>Issues</h5>
                        <span id="issue-status" class="label radius alert">{{ car.countIssues() }}</span>
                    </div>
                    <div class="days-in-maintenance">
                        <h5>Days in Maintenance</h5>
                        <span id="days-in-maintenance" class="label radius secondary">{{ car.getMaintenanceDays() }}</span>
                    </div>
                     {# Close tag for per car block #}
                </div>
            {% endfor %}
            </div>
            <div class="client-data">
                <ul class="client-info" data-id="{{ client.id }}" data-update-url="/clients/updateOwn">
                    <li><h5 class="label radius secondary">{{ client.fullname }}</h5></li>
                    <li><span>Phone:</span><span class="contact_phone">{{ client.contactPhone }}</span></li>
                    <li> <span>Email:</span><span class="contact_email">{{ client.contactEmail }}</span></li>
                    <li> <span>Signup date:</span><span class="date-registration">{{ client.regDate }}</span></li>
                    <li> <span>Add info:</span><span class="more_info">{{ client.moreInfo }}</span></li>
                    <li> <span>Username:</span>{{ client.username }}</li>
                    <li>
                        <span>Notify me :</span>
                        <span class="notify"><?= $client->notify ? 'Yes' : 'No'?></span>
                    </li>
                    <li><span class="password">Change password</span></li>
                </ul>
            </div>
            <div class="car-data">
            {% for car in client.cars %}
                <ul class="car-info" data-id="{{ car.id }}" data-update-url="/cars/updateOwn">
                <li><h5 class="label radius secondary">{{ car.carModels.name }}</h5></li>
                <li><span>RegNumber</span>{{ car.regNumber }}</li>
                <li><span>Year:</span>{{ car.year }}</li>
                <li><span>First service date:</span>{{ car.regDate }}</li>
                <li><span>Current KM:</span><span class="milage" data-milage_date="{{ car.milageDate }}">{{ car.milage }}</span></li>
                <li><span>Milage KM/day:</span><span class="daily_milage">{{ car.dailyMilage }}</span></li>
                <li><span>Car VIN:</span>{{ car.vin }}</li>
                <li><span>Add info:</span>{{ car.moreInfo }}</li>
                </ul>
            {% endfor %}
            </div>
        </div>

    </div>

