<div class="row">
    <div class="large-4 columns large-centered">
        {{ form('/cars/vin', 'method':'post','class':'form-search-by-vin') }}
            <label for="car-identity">VIN or Registration number</label>
            {{ text_field("car-identity","size":32) }}
            {{ submit_button('Search','class':'button small') }}
        </form>
    </div>
</div>
<div class="row">
    {% if car is defined %}
        <h4>VIN {{ car.getVin() }}</h4>
    {# Move to separate partial and enable 'compileAlways' => true for Volt #}
    <div class="large-9 columns services-block">
       {%  include "partials/all_provided_services_table.volt" %}
    </div>
    {% endif %}
    {# Check if client is defined #}
    <div class="large-3 columns analytics-block">
    {# Check if car is found #}
    {% if car is defined %}
        <div class="car-data">
            <ul class="car-info">
                <li><h5 class="label radius secondary">{{ car.carModels.getName() }}</h5></li>
                <li><span>RegNumber</span>{{ car.getRegNumber() }}</li>
                <li><span>Year:</span>{{ car.getYear() }}</li>
                <li><span>First service date:</span>{{ car.getRegDate() }}</li>
                <li><span>Current KM:</span>{{ car.getMilage() }}</li>
                <li><span>Milage KM/day:</span>{{ car.getDailyMilage() }}</li>
                <li><span>VIN:</span>{{ car.getVin() }}</li>
                <li><span>Add info:</span>{{ car.getMoreInfo() }}</li>
                <li>
                    {{  this.elements.getEditLinks(car.getId()) }}
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
</div>
