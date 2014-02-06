{{ form('/providedservices/delete/'~id, 'method':'post', 'class':'form-delete-provided-service') }}
    <h3>Delete Provided Service with id = {{ id }}</h3>
    {{ submit_button("class":"button small alert","Delete") }}
</form>