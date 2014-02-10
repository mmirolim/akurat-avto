{{ form('/providedservices/delete', 'method':'post', 'class':'form-delete-provided-service') }}
    <h3>Delete Provided Service with id = {{ id }}</h3>
    {{ hidden_field("id", "value":id) }}
    {{ submit_button("class":"button small alert","Delete") }}
    {{ this.elements.getCancelButton() }}
</form>