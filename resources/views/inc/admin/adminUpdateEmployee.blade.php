<div class="container d-none offset-md-1 pl-4 p-1 m-1 col-sm-6" id="edit_employee">
        <p class="text-primary"><strong><em>Edit an Employee</em></strong></p>
        <br>
        
        <form action="{{ route('adminAreaUpdateUser') }}" method="POST" id="form_update_employee">
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
            <label for="employees" class="col-sm-4"><strong>Select an employee:</strong></label>
            <select name="employees" onchange="fillEmployeeUpdate(this)" class="form-control col-sm-6" id="delete_employees">
                <option value=""></option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->surname . ' ' . $user->name }}</option>
                @endforeach  
            </select>
        </div>
        <br>
            <div class="form-group form-row">
                <label for="name" class="col-sm-2">Name:</label>
                <input type="text" class="form-control col-sm-6" readonly id="update_name_employee" name="name">
            </div>
            <div class="form-group form-row">
                <label for="surname" class="col-sm-2">Surname:</label>
                <input type="text" class="form-control col-sm-6" readonly id="update_surname_employee" name="surname">
            </div>
            <div class="form-group form-row">
                <label for="email" class="col-sm-2">Email address:</label>
                <input type="email" class="form-control col-sm-6" readonly id="update_email_employee" name="email">
            </div>
            <div class="form-group form-row">
                <label for="pwd" class="col-sm-2">Password:</label>
                <input type="password" class="form-control col-sm-6" readonly id="update_pwd_employee" name="pwd">
            </div>
            <div class="form-group form-row">
                <label for="permission" class="col-sm-2">Permission:</label>
                <select name="permission" class="form-control col-sm-6" disabled id="update_permission_employee">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
</div>