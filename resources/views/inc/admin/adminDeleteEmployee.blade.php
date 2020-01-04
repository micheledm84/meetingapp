<div class="container d-none offset-md-1 p-1 m-1 col-sm-6 pl-4" id="delete_employee">
        <p class="text-danger"><strong><em>Delete an Employee</em></strong></p>
        <br>
        
        <form action="{{ route('adminAreaDeleteUser') }}" method="POST" id="form_delete_employee">
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
            <label for="employees" class="col-sm-4"><strong>Select an employee:</strong></label>
            <select name="employees" onchange="fillEmployeeDelete(this)" class="form-control col-sm-6" id="admin_delete_employees">
                <option value=""></option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->surname . ' ' . $user->name }}</option>
                @endforeach  
            </select>
            </div>
            <br>
            <div class="form-group form-row">
                <label for="name" class="col-sm-2">Name:</label>
                <input type="text" class="form-control col-sm-6" readonly id="delete_name_employee" name="name">
            </div>
            <div class="form-group form-row">
                <label for="surname" class="col-sm-2">Surname:</label>
                <input type="text" class="form-control col-sm-6" readonly id="delete_surname_employee" name="surname">
            </div>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
</div>