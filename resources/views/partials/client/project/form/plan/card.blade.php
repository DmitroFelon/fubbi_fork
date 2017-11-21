<div style="height: 150px;" class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <h4 class="text-center">{{$plan->name}}</h4>


    <div class="stripe-checkout-wrapper">
        <form action="{{url('subscribe')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="plan_id" value="{{$plan->id}}">
            <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{config('services.stripe.key')}}"
                    data-amount="{{$plan->amount}}"
                    data-email="{{\Illuminate\Support\Facades\Auth::user()->email}}"
                    data-name="{{$plan->name}}"
                    data-description="Widget"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-allow-remember-me="false"
                    data-zip-code="false"
                    data-label="Subscribe"
                    data-currency="aud">
            </script>
        </form>
    </div>
</div>