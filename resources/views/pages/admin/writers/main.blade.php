@extends('master')

@section('content')


    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Rating</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{round($user->avgRating, 2)}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>



@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
@endsection