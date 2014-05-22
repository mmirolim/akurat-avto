<div class="large-9 columns services-block">
    {% include "partials/all_provided_services_table.volt" %}
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
</div>
