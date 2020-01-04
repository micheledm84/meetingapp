@extends('layouts.inside')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            <em>ERRORS: The operation could not be done!</em>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (\Session::has('success'))
                    <div class="alert alert-success">
                            <p>{!! \Session::get('success') !!}</p>
                    </div>
                @endif

                @if (\Session::has('mail_not_sent'))
                    <div class="alert alert-danger">
                            <p>{!! \Session::get('mail_not_sent') !!}</p>
                    </div>
                @endif
        </div>
    </div>
</div>
@endsection
