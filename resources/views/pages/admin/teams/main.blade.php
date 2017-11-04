@extends('master')

@section('content')


    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>

        </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td>{{$team->id}}</td>
                <td>{{$team->name}}</td>
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