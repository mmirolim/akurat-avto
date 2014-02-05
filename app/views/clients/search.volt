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
<table class="browse" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Contactemail</th>
            <th>Contactphone</th>
            <th>Regdate</th>
            <th>Moreinfo</th>
         </tr>
    </thead>
    <tbody>
    {% for client in page.items %}
        <tr>
            <td>{{ client.id }}</td>
            <td>{{ client.username }}</td>
            <td>{{ client.fullname }}</td>
            <td>{{ client.contactEmail }}</td>
            <td>{{ client.contactPhone }}</td>
            <td>{{ client.regDate }}</td>
            <td>{{ client.moreInfo }}</td>
            <td>
                <ul>
                    {% for car in client.cars %}
                        <li>{{ car.regNumber}} - {{ link_to("/cars/vin/"~car.vin, car.vin) }}</li>
                    {% endfor %}
                </ul>
            </td>
            <td>{% if editAllowed %}
                    {{link_to("/clients/edit/" ~ client.id, "Edit") }}
                {% endif %}
            </td>
            <td>{% if deleteAllowed %}
                    {{link_to("/clients/delete/" ~ client.id, "Delete") }}
                {% endif %}
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{link_to("/clients/search", "First") }}</td>
                        <td>{{link_to("/clients/search?page=" ~ page.before, "Previous") }}</td>
                        <td>{{link_to("/clients/search?page=" ~ page.next, "Next") }}</td>
                        <td>{{link_to("/clients/search?page=" ~ page.last, "Last") }}</td>
                        <td>{{ page.current ~ "/" ~ page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    <tbody>
</table>
