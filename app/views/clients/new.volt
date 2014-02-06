<div class="large-4 large-centered columns">
    {{ form('/clients/create', 'method':'post', 'class':'form-create-client') }}
        <h1>Add New Client</h1>
        <table>
            <tr>
                <td>
                    <label for="username">Username*</label>
                    {{ text_field("username", "size":30) }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">Password*</label>
                    {{ text_field("password", "size":30) }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="fullname">Fullname*</label>
                    {{ text_field("fullname", "size":30) }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="contact_phone">Contactphone*</label>
                    {{ text_field("contact_phone", "size":30) }}
                </td>
            </tr>
            <tr class="optional-field">
                <td>
                    <label for="contact_email">Contactemail</label>
                    {{ text_field("contact_email", "size":30) }}
                </td>
            </tr>
            <tr class="optional-field">
                <td>
                    <label for="more_info">Moreinfo</label>
                    {{ text_field("more_info", "size":60) }}
                </td>
            </tr>
            <tr>
                <td>{{ submit_button("class":"button small",'Сохранить') }}</td>
            </tr>
        </table>
    </form>
</div>
