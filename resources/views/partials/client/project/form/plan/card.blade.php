<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <div class="ibox">
        <div class="ibox-content product-box active">
            <div class="product-imitation">
                {{$plan->name}}
            </div>
            <div class="product-desc">
                <span class="product-price">{{$plan->amount/100}} $</span>
                <small class="text-muted">Category</small>
                <a href="#" class="product-name">Plan</a>
                <div class="small m-t-xs">Some plan description</div>
                <div class="m-t text-righ">
                    <a data-amount="{{$plan->amount/100}}"
                       data-plan="{{$plan->id}}"
                       href="#"
                       class="btn btn-sm btn-outline btn-primary subscribe-btn">
                        Subscribe <i class="fa fa-long-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



