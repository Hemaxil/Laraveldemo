<tr><td><a class='remove btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a></td><td><form method='post' action='{{route('product_attributes.store')}}' id='create'><input name='_token' type='hidden' value={{csrf_token()}}><input type='text' id='name' name='name' class='form-control' ></td><td><input type='submit' value='Create' form='create' class='btn btn-primary'></td></form></tr>