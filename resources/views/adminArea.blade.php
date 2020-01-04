@extends('layouts.inside')

@section('content')
<!--
<div class="offset-md-2">
        <p class="text-dark h6"><strong><em>Modify Settings and Database</em></strong></p>
</div>
<hr>-->

<div>
    <label for="operations" class="col-sm-2 d-inline">Select operation:</label>
    <select name="operations" class="col-sm-4 d-inline" id="operations" onchange="selectOperationDiv()">
        <option value="0"></option>
        @foreach($operations as $operation)
            <option value="{{$operation->id}}">{{$operation->name}}</option>
        @endforeach
    </select>
</div>
<br>
<hr>


@include('inc.admin.adminInsertEmployee')

@include('inc.admin.adminInsertRoom')

@include('inc.admin.adminUpdateEmployee')

@include('inc.admin.adminUpdateRoom')

@include('inc.admin.adminDeleteEmployee')

@include('inc.admin.adminDeleteRoom')


@if ($errors->any())
    <div class="row justify-content-center" id="admin_errors">
        <div class="col-md-8">
            <div class="alert alert-danger">
                <ul>
                    <em>ERRORS: The operation could not be done!</em>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif


<script type="application/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function selectOperationDiv() {
                var operation_selected = document.getElementById('operations');
                var operation_string = operation_selected.options[operation_selected.selectedIndex].text;
                allFormsNone();
                allInputsAsBefore();
                var operation_string_formatted = operation_string.replace(" ", "_");
                $('#' + operation_string_formatted).removeClass('d-none');
            }

function allFormsNone () {
    $("#insert_room").addClass('d-none');
    $("#insert_employee").addClass('d-none');
    $("#edit_room").addClass('d-none');
    $("#edit_employee").addClass('d-none');
    $("#delete_room").addClass('d-none');
    $("#delete_employee").addClass('d-none');
    document.getElementById("form_delete_employee").reset();
    document.getElementById("form_delete_room").reset();
    document.getElementById("form_update_employee").reset();
    document.getElementById("form_update_room").reset();
    document.getElementById("form_insert_employee").reset();
    document.getElementById("form_insert_room").reset();
    $("#admin_errors").addClass('d-none');
    allInputsAsBefore();
}

function allInputsAsBefore() {
    $("#update_name_room").prop("readonly", true);
    $("#update_name_employee").prop("readonly", true);
    $("#update_surname_employee").prop("readonly", true);
    $("#update_email_employee").prop("readonly", true);
    $("#update_pwd_employee").prop("readonly", true);
    $("#update_permission_employee").prop("disabled", true);
}

function fillRoomUpdate(room_id) {
                var room_selected = room_id.value;
                $("#update_name_room").prop("readonly", false);
                if (room_selected != 0) {

                  $.ajax({
                            method: "POST",
                            url:  "{{ route('adminAreaPostRoom') }}",
                            data: 'room_selected=' + room_selected,
                            success: function(data){
                                var room_data = JSON.parse(data);
                                document.getElementById('update_name_room').value = room_data['name'];
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                            }
                          });
                } else {
                    document.getElementById('update_name_room').value = "";
                }
            };

function fillRoomDelete(room_id) {
                var room_selected = room_id.value;
                if (room_selected != 0) {

                  $.ajax({
                            method: "POST",
                            url:  "{{ route('adminAreaPostRoom') }}",
                            data: 'room_selected=' + room_selected,
                            success: function(data){
                                var room_data = JSON.parse(data);
                                document.getElementById('delete_name_room').value = room_data['name'];
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                            }
                          });
                } else {
                    document.getElementById('delete_name_room').value = "";
                }
            };

function fillEmployeeDelete(emp_id) {
    var emp_selected = emp_id.value;
    if (emp_selected != 0) {
        $.ajax({
                method: "POST",
                url:  "{{ route('adminAreaPostEmployee') }}",
                data: 'emp_selected=' + emp_selected,
                success: function(data){
                    var emp_data = JSON.parse(data);
                    document.getElementById('delete_name_employee').value = emp_data['name'];
                    document.getElementById('delete_surname_employee').value = emp_data['surname'];
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
                });
    } else {
        document.getElementById('delete_name_employee').value = "";
        document.getElementById('delete_surname_employee').value = "";
    }
};

function fillEmployeeUpdate(emp_id) {
                var emp_selected = emp_id.value;
                $("#update_name_employee").prop("readonly", false);
                $("#update_surname_employee").prop("readonly", false);
                $("#update_email_employee").prop("readonly", false);
                $("#update_pwd_employee").prop("readonly", false);
                $("#update_permission_employee").prop("disabled", false);
                if (emp_selected != 0) {
                  $.ajax({
                            method: "POST",
                            url:  "{{ route('adminAreaPostEmployee') }}",
                            data: 'emp_selected=' + emp_selected,
                            success: function(data){
                                var emp_data = JSON.parse(data);
                                document.getElementById('update_name_employee').value = emp_data['name'];
                                document.getElementById('update_surname_employee').value = emp_data['surname'];
                                document.getElementById('update_email_employee').value = emp_data['email'];
                                document.getElementById('update_pwd_employee').value = emp_data['pwd'];
                                document.getElementById('update_permission_employee').value = emp_data['permission'];
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                            }
                          });
                } else {
                    document.getElementById('update_name_employee').value = "";
                    document.getElementById('update_surname_employee').value = "";
                    document.getElementById('update_email_employee').value = "";
                    document.getElementById('update_pwd_employee').value = "";
                    document.getElementById('update_permission_employee').value = 0;
                }
            };

</script>

@endsection