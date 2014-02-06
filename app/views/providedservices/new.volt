<div class="large-4 large-centered columns">
    {{ form('/providedservices/create', 'method':'post', 'class':'form-create-provided-service') }}
        <h1>Add Provided Service</h1>
        <table class="basic-form">
            <tr>
                <td>
                    <label for="vin">Car VIN*</label>
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
                    <input name="milage" id="milage" type="number" required="required">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="in_ms">In tech regulation</label>
                    {{  check_field("in_ms", 'value':1) }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="remind">Remind</label>
                    {{  check_field("remind", 'value':1) }}
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
                    <label for="start_date">Start date*</label>
                    <input name="start_date" id="start_date" type="date" required="required">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="finish_date">Finish date</label>
                    <input name="finish_date" id="finish_date" type="date">
                </td>
            </tr>
            <tr class="in_ms-dependent remind-dependent optional-field">
                <td>
                    <label for="remind_date">Remind after date</label>
                    <input name="remind_date" id="remind_date" type="date">
                </td>
            </tr>
            <tr class="in_ms-dependent remind-dependent optional-field">
                <td>
                    <label for="remind_km">Remind after km</label>
                    <input name="remind_km" id="remind_km" type="number">
                </td>
            </tr>
            <tr class="optional-field">
                <td>
                    <label for="more_info">More info</label>
                    {{  text_field("more_info", "type":"date") }}
                </td>
            </tr>
            <tr>
                <td>{{ submit_button("class":"button small","Сохранить") }}</td>
            </tr>
        </table>
    </form>
</div>