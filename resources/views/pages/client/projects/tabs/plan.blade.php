<div class="row">
    @each('partials.client.project.form.plan.card', $plans, 'plan')
</div>

<div id="stripe-form-wrapper" style="display: none">
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
                <input class='form-control' size='4' type='text'
                       value="{{\Illuminate\Support\Facades\Auth::user()->first_name . ' ' . \Illuminate\Support\Facades\Auth::user()->last_name}}">
            </div>
        </div>
        <div class='form-row'>
            <div class='col-xs-12 form-group card required'>
                <label class='control-label'>Card Number</label>
                <input value="4242424242424242"
                        maxlength="16" minlength="16" autocomplete='off' class='form-control card-number' size='20' type='text'>
            </div>
        </div>
        <div class='form-row'>
            <div class='col-xs-4 form-group cvc required'>
                <label class='control-label'>CVC</label>
                <input value="333" autocomplete='off'  class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
            </div>
            <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'> </label>
                <input value="2020" maxlength="4" minlength="4" class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
            </div>
            <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'>Expiration</label>
                <input value="12" maxlength="2" minlength="1" class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
            </div>
        </div>
        <div class='form-row'>
            <div class='col-md-12'>
                <div class='form-control total btn btn-info'>
                    Total: <span class='amount'></span><span>$</span>
                </div>
            </div>
        </div>
        <div class='form-row'>
            <div class='col-md-12 form-group'>
                <button class='form-control btn btn-primary submit-button'
                        type='submit' style="margin-top: 10px;">Subscribe »
                </button>
            </div>
        </div>
        <div class='form-row'>
            <div class='col-md-12 error form-group hide'>
                <div class='alert-danger alert'>Please correct the errors and try
                    again.
                </div>
            </div>
        </div>
    </form>
</div>
