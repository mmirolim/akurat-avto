<div class="large-4 large-centered columns">
    {{ form('/carmodels/create', 'method':'post', 'class':'form-create-car-model') }}
        <h1>Add New Car model</h1>
        <label for="saved_models">Models in DB</label>
        {{ select("saved_models",carModels, 'using':['id','name'], 'required':'required') }}
        <label for="brand_id">Car Brand*</label>
        {{ select("brand_id",carBrands, 'using':['id','name'], 'required':'required') }}
        <label for="model">New Model name and year*</label>
        {{ text_field("model", "size":40, 'required':'required')}}
        {{ submit_button("class":"button small","Сохранить") }}
    </form>
</div>