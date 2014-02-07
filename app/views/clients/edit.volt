<div class="large-4 large-centered columns">
    {{ form('/clients/save', 'method':'post', 'class':'form-edit-client') }}
        <h1>Add New Client</h1>
        <table>
            <tr>
                <td>
                    <label for="username">Username*</label>
                    {{ text_field("username", "size":30, 'required':'required') }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">Password*</label>
                    {{ password_field("password", "size":30, 'required':'required') }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="fullname">Fullname*</label>
                    {{ text_field("fullname", "size":30, 'required':'required') }}
                </td>
            </tr>
            <tr>
                <td>
                    <label for="contact_phone">Contact phone*</label>
                    {{ text_field("contact_phone","required":"required") }}
                </td>
            </tr>
            <tr class="optional-field">
                <td>
                    <label for="contact_email">Contact email</label>
                    {{ text_field("contact_email") }}
                </td>
            </tr>
            <tr class="optional-field">
                <td>
                    <label for="more_info">More info</label>
                    {{ text_field("more_info", "size":60) }}
                </td>
            </tr>
           <tr>
                <td>
                    {{  hidden_field("id") }}
                    {{ submit_button('class':'button small',"Сохранить") }}
                    {{ this.elements.getCancelButton() }}
                </td>
            </tr>
        </table>
    </form>
</div>
