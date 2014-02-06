<div class="large-9 columns services-block">
    {% include "partials/employee_provided_services.volt" %}
</div>
<div class="large-3 columns">
    <!-- redirect to 8080 for mobile -->
    {{ this.elements.getBarcodeLink() }}

    <div class="large-12 columns">
        {% include "partials/form_cars_by_vin.volt" %}
    </div>
    <div class="large-12 columns">
        {% include "partials/form_clients_by_username.volt" %}
    </div>
    <div class="large-12 columns">
        <ul>
            <li>{{ link_to("/clients/new","Add Client") }}</li>
            <li>{{ link_to("/cars/new","Add Car") }}</li>
            <li>{{ link_to("/providedservices/new","Add Provided service") }}</li>
            <li>{{ link_to("/providedservices/new","Add new Model") }}</li>
        </ul>
    </div>

</div>