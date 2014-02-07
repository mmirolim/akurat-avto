<div class="large-4 large-centered columns">
    {{ form('/carbrands/create', 'method':'post', 'class':'form-create-car-brand') }}
    <h1>Add New Car brand</h1>
    <label for="brand_id">Car Brands in DB</label>
    {{ select("brand_id",carBrands, 'using':['id','name'], 'required':'required') }}
    <label for="brand">New car brand name*</label>
    {{ text_field("brand", "size":40, 'required':'required')}}
    {{ submit_button("class":"button small","Сохранить") }}
    {{ this.elements.getCancelButton() }}
    </form>
</div>