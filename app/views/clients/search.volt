<div class="large-3 large-centered columns">
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
            <th>Email</th>
            <th>Phone</th>
            <th>Reg. date</th>
            <th>Info</th>
         </tr>
    </thead>
    <tbody>
    {% for client in page.items %}
        <tr>
            <td>{{ client.getId() }}</td>
            <td>{{ client.getUsername() }}</td>
            <td>{{ client.getFullname() }}</td>
            <td>{{ client.getEmail() }}</td>
            <td>{{ client.getPhone() }}</td>
            <td>{{ client.getRegDate() }}</td>
            <td>{{ client.getInfo() }}</td>
            <td>
                <ul>
                    {% for car in client.cars %}
                        <li>{{ car.getRegNumber()}} - {{ link_to("/cars/vin/"~car.getVin(), car.getVin()) }}</li>
                    {% endfor %}
                </ul>
            </td>
            <td>
                {{  this.elements.getEditLinks(client.getId()) }}
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
