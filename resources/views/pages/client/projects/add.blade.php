@extends('master')

@section('content')
    <form method="post" class="row">
        {{ csrf_field() }}
        <div class="row">
            <h3>Keywords</h3>
            @foreach($keywords as $keyword)
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <label>
                        <input name="keywords[]" type="checkbox" value="{{$keyword->text}}">
                        {{ucfirst($keyword->text)}}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <input class="form-control btn btn-primary" value="Create Project" type="submit">
        </div>
    </form>
@endsection