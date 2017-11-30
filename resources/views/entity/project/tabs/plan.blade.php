<div class="row">
    @each('entity.project.partials.form.plan.card', $plans, 'plan')
</div>
<div class="panel panel-default" id="stripe-form-wrapper" style="display: none">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Subscribe')}}</h3>
    </div>
    <div class="panel-body">
        <form accept-charset="UTF-8" action="/subscribe" class="require-validation"
              data-stripe-publishable-key="test_public_key"
              id="payment-form" method="post">
            {!! Form::hidden('_step', \App\Models\Project::PLAN_SELECTION) !!}

            <input type="hidden" name="plan_id" id="plan_id" value="">
            {{ csrf_field() }}
            <div class='form-row'>
                <div class='col-xs-12 form-group required'>
                    <label class='control-label'></label>
                    <input name="project_name" class='form-control' size='4' type='text'
                           value="some project name">
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-12 form-group required'>
                    <label class='control-label'></label>
                    <input class='form-control'
                           size='4' type='text'
                           value="{{\Illuminate\Support\Facades\Auth::user()->first_name . ' ' . \Illuminate\Support\Facades\Auth::user()->last_name}}">

                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-12 form-group card required'>
                    <label class='control-label'>{{__('Card Number')}}</label>
                    <input value="4242424242424242"
                           data-mask="9999-9999-9999-9999"
                           maxlength="16" minlength="16" autocomplete='off' class='form-control card-number' size='20'
                           type='text'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-4 form-group cvc required'>
                    <label class='control-label'>CVC</label>
                    <input value="333" autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4'
                           type='text'>
                </div>
                <div class='col-xs-4 form-group expiration required'>
                    <label class='control-label'>{{__('Expiration year')}}</label>
                    <input value="2020" maxlength="4" minlength="4" class='form-control card-expiry-year'
                           placeholder='YYYY' size='4' type='text'>
                </div>
                <div class='col-xs-4 form-group expiration required'>
                    <label class='control-label'>{{__('Expiration month')}}</label>
                    <input value="12" maxlength="2" minlength="1" class='form-control card-expiry-month'
                           placeholder='MM' size='2' type='text'>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-md-12 text-center'>
                    <strong>{{__('Total')}}: <span class='amount'></span><span>$</span></strong>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-md-12 form-group'>
                    <button class='form-control btn btn-primary submit-button'
                            type='submit' style="margin-top: 10px;"><strong>{{__('Subscribe')}}</strong>
                    </button>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-md-12 error form-group hide'>
                    <div class='alert-danger alert'>
                        {{__('Please correct the errors and try again.')}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



