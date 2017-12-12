<form method="get" class="input-group">
    <input type="hidden"
           name="r"
           id="user-role"
           value="{{(request()->input('r'))?request()->input('r'):''}}">
    <input type="text"
           value="{{(request()->input('s'))?request()->input('s'):''}}"
           name="s"
           data-provide="typeahead"
           data-source='{{$search_suggestions}}'
           placeholder="{{__('Search user')}}"
           class="input form-control">
    <span class="input-group-btn">
        <button type="submit" class="btn btn btn-primary">
            <i class="fa fa-search"></i>{{__('Search')}}
        </button>
    </span>
</form>