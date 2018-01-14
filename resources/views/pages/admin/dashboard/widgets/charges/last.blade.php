@if($last_charges->isNotEmpty())
    <table class="table table-stripped small m-t-md">
        <tbody>
        @foreach($last_charges as $charge)
            <tr>
                <td class="no-borders">
                    <i class="fa fa-circle text-navy"></i>
                </td>
                <td class="no-borders">
                    {{ \Illuminate\Support\Carbon::createFromTimestamp($charge->created )->format('m-d-Y') }}
                </td>
                <td class="no-borders">
                    @if(!is_null($charge->customer))
                        <a href="{{action('UserController@show', $charge->customer)}}">
                            {{$charge->customer->name }}, {{$charge->customer->email}}
                        </a>
                    @else
                        <small>{{_i('removed customer')}}</small>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="p-sm text-muted">
        {{_i('No results')}}
    </div>
@endif