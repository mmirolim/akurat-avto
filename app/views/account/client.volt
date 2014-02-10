<div id="content" class="account-view-content row">
    <div class="large-9 columns services-block">
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
            </tr>
            </thead>
            <tbody>
            {% for car in client.cars %}
            {# Get all provided services by car ordered by start date #}
                {% for providedService in car.getProvidedServices() %}
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
                    </tr>
                {% endfor %}
            {% endfor %}
            </tbody>
        </table>
    </div>
    <div class="large-3 columns analytics-block">
        <div class="analytics-board">
            {% for key, car in client.cars %}
                {# Create div block per car #}
                <div class="analytic-data">
                    <h5 class="label radius secondary car-regnum">{{ car.getRegNumber() }} - {{ car.carModels.getName() }}</h5>
                    <div class="total-health">
                        <h5>Total Health</h5>
                        <span id="car-health" class="label radius success">{{ car.getHealth() }}</span>
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
            {# Escape all user provided data #}
            {% autoescape true %}
                <div class="client-data">
                    <ul class="client-info" data-id="{{ client.getId() }}" data-update-url="/clients/updateOwn">
                        <li><h5 class="label radius secondary">{{ client.getFullname() }}</h5></li>
                        <li><span>Phone:</span><span class="contact_phone">{{ client.getPhone() }}</span></li>
                        <li> <span>Email:</span><span class="contact_email">{{ client.getEmail() }}</span></li>
                        <li> <span>Signup date:</span><span class="date-registration">{{ client.getRegDate() }}</span></li>
                        <li> <span>Add info:</span><span class="more_info">{{ client.getInfo() }}</span></li>
                        <li> <span>Username:</span>{{ client.getUsername() }}</li>
                        <li>
                            <span>Notify me :</span>
                            <span class="notify"><?= $client->getNotify() ? 'Yes' : 'No'?></span>
                        </li>
                        <li><span class="password">Change password</span></li>
                    </ul>
                </div>
                <div class="car-data">
                {% for car in client.cars %}
                    <ul class="car-info" data-id="{{ car.getId() }}" data-update-url="/cars/updateOwn">
                    <li><h5 class="label radius secondary">{{ car.carModels.getName() }}</h5></li>
                    <li><span>Number:</span>{{ car.getRegNumber() }}</li>
                    <li><span>Year:</span>{{ car.getYear() }}</li>
                    <li><span>First service date:</span>{{ car.getRegDate() }}</li>
                    <li><span>Current KM:</span><span class="milage" data-milage_date="{{ car.getMilageDate() }}">{{ car.getMilage() }}</span></li>
                    <li><span>Milage KM/day:</span><span class="daily_milage">{{ car.getDailyMilage() }}</span></li>
                    <li><span>Car VIN:</span>{{ car.getVin() }}</li>
                    <li><span>Add info:</span>{{ car.getInfo() }}</li>
                    </ul>
                {% endfor %}
                </div>
            {% endautoescape %}
        </div>

    </div>

