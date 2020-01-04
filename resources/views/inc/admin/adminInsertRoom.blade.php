<div class="container d-none offset-md-1 pl-4 p-1 m-1 col-sm-6" id="insert_room">
    
        <p class="text-success"><strong><em>Insert a new Room</em></strong></p>
        <br>
            <form action=" {{ route('adminAreaInsertRoom') }}" method="POST" id="form_insert_room">
            @csrf
            <div class="form-group form-row">
                <label for="name_room" class="col-sm-2">Name:</label>
                <input type="text" class="form-control col-sm-6" id="name_room" name="name_room">
            </div>
            <button type="submit" class="btn btn-success" id="room_insert">Insert</button>
        </form>
    
</div>