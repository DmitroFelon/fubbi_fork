
<div class="row">
    @each('partials.client.project.form.plan.card', $plans, 'plan')
</div>

<style>
    .stripe-checkout-wrapper{
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        width: 100px;
    }
</style>
