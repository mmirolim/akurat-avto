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