<div class="large-4 columns large-centered">
    {{ form('/cars/vin', 'method':'post','class':'form-search-by-vin') }}
        <label for="car-identity">VIN or Registration number</label>
        {{ text_field("car-identity","size":32) }}
        {{ submit_button('Search','class':'button small') }}
    </form>
</div>
{% if car is defined %}
    <h4>VIN {{ car.vin }}</h4>
{% endif %}
{# Move to separate partial and enable 'compileAlways' => true for Volt #}
<div class="large-9 columns services-block">
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
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        {# Check if car is found #}
        {% if car is defined %}
            {# Get all provided services for a car ordered by start date #}
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
                    <td>
                        {{  this.elements.getEditLinks(providedService.id,'providedservices') }}
                    </td>
                </tr>
            {% endfor %}
        {% endif %}
        </tbody>
    </table>
</div>
{# Check if client is defined #}
<div class="large-3 columns analytics-block">
{# Check if car is found #}
{% if car is defined %}
    <div class="car-data">
        <ul class="car-info">
            <li><h5 class="label radius secondary">{{ car.carModels.name }}</h5></li>
            <li><span>RegNumber</span>{{ car.regNumber }}</li>
            <li><span>Year:</span>{{ car.year }}</li>
            <li><span>First service date:</span>{{ car.regDate }}</li>
            <li><span>Current KM:</span>{{ car.milage }}</li>
            <li><span>Milage KM/day:</span>{{ car.dailyMilage }}</li>
            <li><span>VIN:</span>{{ car.vin }}</li>
            <li><span>Add info:</span>{{ car.moreInfo }}</li>
            <li>
                {{  this.elements.getEditLinks(car.id) }}
            </li>
        </ul>
    </div>
{% endif %}
{% if client is defined %}
    <div class="client-data">
        <ul class="client-info">
            <li><h5 class="label radius secondary">{{ client.fullname }}</h5></li>
            <li><span>Phone:</span>{{ client.contactPhone }}</li>
            <li> <span>Email:</span>{{ client.contactEmail }}</li>
            <li> <span>Signup date:</span>{{ client.regDate }}</li>
            <li> <span>Add info:</span>{{ client.moreInfo }}</li>
            <li> <span>Username:</span>{{ client.username }}</li>
            <li>
                <span>Notify me :</span><?= $client->notify ? 'Yes' : 'No'?>
            </li>
            <li>
                {{  this.elements.getEditLinks(client.id,'clients') }}
            </li>
        </ul>
    </div>
{% endif %}
</div>
