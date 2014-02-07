<div class="large-4 large-centered columns">
    {{ form('/cars/create', 'method':'post', 'class':'form-create-car') }}
        <h1>Add New Car</h1>
        <table>
        <tr>
            <td >
                <label for="vin">VIN*</label>
                {{ text_field("vin", "size":40, 'required':'required')}}
            </td>
        </tr>
        <tr>
            <td >
                <label for="registration_number">Registration Number*</label>
                {{ text_field("registration_number", "size":30, 'required':'required') }}
            </td>
        </tr>
        <tr>
            <td >
                <label for="username">Owner's username</label>
                {{ text_field("username", 'required':'required') }}
            </td>
        </tr>
        <tr>
            <td >
                <div class="large-6 small-12 columns">
                    <label for="model_id">Model*</label>
                    {{ select("model_id",carModels, 'using':['_id','_name'], 'required':'required') }}
                </div>
                <div class="large-6 small-12 columns">
                    <label for="year">Year of the car*</label>
                    <input name="year" id="year" type="date" required="required"/>
                </div>
            </td>
        </tr>
        <tr>
            <td >
                <div class="large-6 small-12 columns">
                    <label for="milage">Milage in km*</label>
                    <input name="milage" id="milage" type="number" required="required"/>
                </div>
                <div class="large-6 small-12 columns">
                    <label for="daily_milage">Dailymilage in km*</label>
                    <input name="daily_milage" id="daily_milage" type="number" required="required"/>
                </div>

            </td>
        </tr>
        <tr class="optional-field">
            <td >
                <label for="more_info">Moreinfo</label>
                {{ text_field("more_info") }}
            </td>
        </tr>
        <tr>
            <td>
                {{ submit_button("class":"button small","Сохранить") }}
                {{ this.elements.getCancelButton() }}
            </td>
        </tr>
    </table>
    </form>
</div>