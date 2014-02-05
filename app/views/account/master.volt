<div class="large-9 large-centered columns">
    <!-- redirect to 8080 for mobile -->
    <h1><a class="button" href="zxing://scan/?ret=http%3A%2F%2Fakurat.auto:8080%2Fcars%2Fvin%2F%7BCODE%7D%2F">Find car by QR Code</a></h1>
</div>
<div class="large-9 large-centered columns">
    {{ form('/cars/vin', 'method':'post', 'class':'form-search-by-vin') }}
    <label for="car-identity">VIN or Registration number</label>
    {{ text_field("car-identity","size":32) }}
    {{ submit_button('Search','class':'button small') }}
    </form>
</div>