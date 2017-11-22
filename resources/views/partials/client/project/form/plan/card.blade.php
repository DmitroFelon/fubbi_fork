<div style="height: 150px;" class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <h4 class="text-center">{{$plan->name}}</h4>

    <div class="stripe-checkout-wrapper">
        <button class="subscribe-btn btn btn-success" data-amount="{{$plan->amount/100}}" data-plan="{{$plan->id}}">Subscribe {{$plan->amount/100}}$</button>
    </div>
</div>