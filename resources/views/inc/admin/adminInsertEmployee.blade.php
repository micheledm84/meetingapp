<div class="container d-none offset-md-1 p-1 m-1 col-sm-6 pl-4" id="insert_employee">
        <p class="text-success"><strong><em>Insert a new Employee</em></strong></p>
        <br>
        <form action="{{ route('adminAreaInsertUser') }}" method="POST" id="form_insert_employee">
            @csrf
            <div class="form-group form-row">
                <label for="name" class="col-sm-2">Name:</label>
                <input type="text" class="form-control col-sm-6" id="name" name="name">
            </div>
            <div class="form-group form-row">
                <label for="surname" class="col-sm-2">Surname:</label>
                <input type="text" class="form-control col-sm-6" id="surname" name="surname">
            </div>
            <div class="form-group form-row">
                <label for="email" class="col-sm-2">Email address:</label>
                <input type="email" class="form-control col-sm-6" id="email" name="email">
            </div>
            <div class="form-group form-row">
                <label for="pwd" class="col-sm-2">Password:</label>
                <input type="password" class="form-control col-sm-6" id="pwd" name="pwd">
            </div>
            <div class="form-group form-row">
                <label for="permission" class="col-sm-2">Permission:</label>
                <select name="permission" class="form-control col-sm-6" id="permission">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Insert</button>
        </form>
</div>