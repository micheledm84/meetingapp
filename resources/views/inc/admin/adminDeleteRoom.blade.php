<div class="container d-none offset-md-1 pl-4 p-1 m-1 col-sm-6" id="delete_room">
    
        <p class="text-danger"><strong><em>Delete a Room</em></strong></p>
        <br>
        
            <form action=" {{ route('adminAreaDeleteRoom') }}" method="POST" id="form_delete_room">
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
                <label for="rooms" class="col-sm-4 "><strong>Select a room:</strong></label>
                <select name="rooms" onchange="fillRoomDelete(this)" class="form-control col-sm-6" id="rooms">
                    <option value="0"></option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                    
                </select>
            </div>
            <br>
            <div class="form-group form-row">
                <label for="name_room" class="col-sm-2">Name:</label>
                <input type="text" class="form-control col-sm-6" readonly id="delete_name_room" name="name_room">
            </div>
            <button type="submit" class="btn btn-danger" id="room_delete">Delete</button>
        </form>
    
</div>