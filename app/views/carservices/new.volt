<div class="large-4 large-centered columns">
    {{ form('/carservices/create', 'method':'post', 'class':'form-create-car-service') }}
    <h1>Add New Car model</h1>
    <label for="saved_services">Services in DB</label>
    {{ select("saved_services",carServices, 'using':['_id','_service']) }}
    <label for="service">New Service name*</label>
    {{ text_field("service", "size":40, 'required':'required')}}
    <label for="more_info">More info</label>
    {{ text_field("more_info", "size":40)}}
    {{ submit_button("class":"button small","Сохранить") }}
    {{ this.elements.getCancelButton() }}
    </form>
</div>