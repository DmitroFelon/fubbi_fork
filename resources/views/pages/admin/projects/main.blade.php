@extends('master')

@section('content')


    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Client</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{$project->id}}</td>
                <td>{{$project->name}}</td>
                <td>{{$project->client->name}}</td>
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