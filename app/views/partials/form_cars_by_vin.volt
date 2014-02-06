{{ form('/cars/vin', 'method':'post', 'class':'form-search-by-vin') }}
<label for="car-identity">VIN or Registration number</label>
{{ text_field("car-identity","size":32) }}
{{ submit_button('Search','class':'button small') }}
</form>