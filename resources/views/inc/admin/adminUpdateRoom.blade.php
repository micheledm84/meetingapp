<div class="container d-none offset-md-1 pl-4 p-1 m-1 col-sm-6" id="edit_room">
    
        <p class="text-primary"><strong><em>Edit a Room</em></strong></p>
        <br>
        
    <form action=" {{ route('adminAreaUpdateRoom') }}" method="POST" id="form_update_room">
        @csrf
        {{ method_field('PUT') }}
        <div class="row">
            <label for="rooms" class="col-sm-4"><strong>Select a room:</strong></label>
            <select name="rooms" onchange="fillRoomUpdate(this)" class="form-control col-sm-6" id="admin_rooms">
                <option value=""></option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
                
            </select>
        </div>
        <br>

            
            <div class="form-group form-row">
                <label for="name_room" class="col-sm-2">Name:</label>
                <input type="text" class="form-control col-sm-6" readonly id="update_name_room" name="name_room">
            </div>
            <button type="submit" class="btn btn-primary" id="room_edit">Edit</button>
        </form>
    
</div>