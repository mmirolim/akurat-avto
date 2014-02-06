<div class="large-4 large-centered columns">
    {{ form('/cars/create', 'method':'post', 'class':'form-create-car') }}
        <h1>Add New Car</h1>
        <table>
        <tr>
            <td >
                <label for="vin">VIN</label>
                {{ text_field("vin", "type":40)}}
            </td>
        </tr>
        <tr>
            <td >
                <label for="registration_number">Registration Number</label>
                {{ text_field("registration_number", "type":30) }}
            </td>
        </tr>
        <tr>
            <td >
                <label for="username">Owner's username</label>
                {{ text_field("username", "type":"number") }}
            </td>
        </tr>
        <tr>
            <td >
                <label for="model_id">Model</label>
                {{ select("model_id",carModels, 'using':['id','name']) }}
            </td>
        </tr>
        <tr>
            <td >
                <label for="year">Year of the car in XXXX format</label>
                {{ text_field("year", "type":30) }}
            </td>
        </tr>
        <tr>
            <td >
                <label for="milage">Milage in km</label>
                {{ text_field("milage", "type":"number") }}
            </td>
        </tr>
        <tr>
            <td >
                <label for="daily_milage">Dailymilage in km</label>
                {{ text_field("daily_milage", "type":"number") }}
            </td>
        </tr>
        <tr class="optional-field">
            <td >
                <label for="more_info">Moreinfo</label>
                {{ text_field("more_info", "type":"date") }}
            </td>
        </tr>
        <tr>
            <td>{{ submit_button("class":"button small","Сохранить") }}</td>
        </tr>
    </table>
    </form>
</div>