<div class="large-4 large-centered columns">
    {{ form('/providedservices/save', 'method':'post', 'class':'form-edit-provided-service') }}
        <h1>Edit Provided Service</h1>
        <table class="basic-form">
            <tr>
                <td>
                    <label for="vin">{{ link_to('/cars/vin/'~car.vin,'Car VIN*') }}</label>
                    {{  text_field("vin", "size":"40", 'required':'required') }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="service_id">Type of service*</label>
                    {{ select("service_id", carServices, "using" : ["id", "service"], 'required':'required') }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="milage">Car milage in km*</label>
                    <input name="milage" id="milage" type="number" required="required" value="{{ providedService.milage }}">
                </td>
            </tr>
            <tr>
                <td>
                    <div class="large-6 small-12 columns">
                        <label for="in_ms">In tech regulation</label>
                        {{  check_field("in_ms", 'value':1) }}
                    </div>
                    <div class="large-6 small-12 columns">
                        <label for="remind">Remind</label>
                        {{  check_field("remind", 'value':1) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="master_id">Master who done the work*</label>
                    {{ select("master_id", employees, "using" : ["id", "fullname"], 'required':'required') }}
                </td>
            </tr>
            <tr>
                <td>
                    <div class="large-6 small-12 columns">
                        <label for="start_date">Start date*</label>
                        <input name="start_date" id="start_date" type="date" required="required" value="{{ providedService.startDate }}">
                    </div>
                    <div class="large-6 small-12 columns">
                        <label for="finish_date">Finish date</label>
                        <input name="finish_date" id="finish_date" type="date" value="{{ providedService.finishDate }}">
                    </div>
                </td>
            </tr>
            <tr class="in_ms-dependent remind-dependent optional-field">
                <td>
                    <div class="large-6 small-12 columns">
                        <label for="remind_date">Remind after date</label>
                        <input name="remind_date" id="remind_date" type="date" value="{{ providedService.remindDate }}">
                    </div>
                    <div class="large-6 small-12 columns">
                        <label for="remind_km">Remind after km</label>
                        <input name="remind_km" id="remind_km" type="number" value="{{ providedService.remindKm }}">
                    </div>
                </td>
            </tr>
            <tr class="optional-field">
                <td>
                    <label for="more_info">More info</label>
                    {{  text_field("more_info") }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ hidden_field("id") }}
                    {{ submit_button('class':'button small',"Сохранить") }}
                    {{ this.elements.getCancelButton() }}
                </td>
            </tr>
        </table>
    </form>
</div>
