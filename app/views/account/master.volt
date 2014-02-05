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
<div class="large-9 large-centered columns">
    {{ form('/clients/search', 'method':'post', 'class':'form-search-client') }}
    <label for="username" id="search-field-label">Search client by</label>
    <select id="search-fields" class="hide">
        <option value="username">Username</option>
        <option value="fullname">Fullname</option>
        <option value="id">Id</option>
    </select>
    {{ text_field("username","size":32, "class":"search-input-field") }}
    {{ submit_button('Search','class':'button small') }}
    </form>
</div>