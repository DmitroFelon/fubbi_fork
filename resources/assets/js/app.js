jQuery(document).ready(function ($) {

    /*
     * Init subscriptions form
     * */
    $(".subscribe-btn").on('click', function () {
        var amount = $(this).attr('data-amount');
        var plan_id = $(this).attr('data-plan');

        $("#plan_id").val(plan_id);
        $(".amount").html(amount);

        $("#stripe-form-wrapper").show();
    });
    var $form = $("#payment-form");
    $form.on('submit', function (e) {
        e.preventDefault();
        Stripe.setPublishableKey(stripe_pub);
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, function (status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        });
    });

    /*
     * Init quiz form with steps
     * */
    $("#quiz-form").steps({
        bodyTag: "fieldset",
        enableAllSteps: true,
        showFinishButtonAlways: true, //todo make true only if admin or manager
        autoFocus: false,
        onInit: function (event, currentIndex) {
            //todo restore state
        },
        onStepChanging: function (event, currentIndex) {
            //todo add validation
        },
        onStepChanged: function (event, currentIndex) {
            //todo save data to server, save current step
        },
        onFinishing: function (event, currentIndex) {
            //todo add validation
        },
        onFinished: function (event, currentIndex) {
            var form = $(this);
            form.submit();
        },

    });

    /*
     * Init keywords form with steps
     * */
    $("#keywords-form").steps({
        bodyTag: "fieldset",
        enableAllSteps: true,
        showFinishButtonAlways: true, //todo make true only if admin or manager
        autoFocus: false,
        onInit: function (event, currentIndex) {
            //todo restore state with jQuery("#keywords-form-t-0").click();
            if (typeof(Storage) !== "undefined") {
                if (typeof(localStorage.getItem("keywords-form-step")) !== "undefined") {
                    jQuery("#keywords-form-t-"+localStorage.getItem("keywords-form-step")).click();
                }

            } else {}
        },
        onStepChanged: function (event, currentIndex) {
            //todo save data to server
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem("keywords-form-step", currentIndex);
            } else {}
        },
        onFinishing: function (event, currentIndex) {
            return true;
            //todo add validation
        },
        onFinished: function (event, currentIndex) {
            var form = $(this);
            form.submit();
        },
    });


    /*
     * Init tags inputs
     * */

    $('.tagsinput').tagsinput({
        tagClass: 'label label-primary'
    });
    var themes_order = [];
    var tag_themes_input = $('#themes');

    /*
     * Add item to from tags input to sortable list
     * */

    tag_themes_input.on('itemAdded', function (event) {
        $("#themes-order-list-wrapper").removeClass('hide');
        $('#themes-order-list').append('' +
            '<li class="list-group-item" data-value="' + event.item + '">' + event.item + '</li>'
        );
        var sorted = $("#themes-order-list").sortable("toArray", {attribute: 'data-value'});
        $("#themes_order").val(sorted.join());
    });
    /*
     * Remove item from sortable list if removed from tags input
     * */
    tag_themes_input.on('itemRemoved', function (event) {
        $('.list-group-item[data-value="' + event.item + '"]').remove();
        var sorted = $("#themes-order-list").sortable("toArray", {attribute: 'data-value'});
        $("#themes_order").val(sorted.join());
        if (tag_themes_input.val() == '') {
            $("#themes-order-list-wrapper").addClass('hide');
        }
    });
    /*
     * Init sortable
     * */
    $("#themes-order-list").sortable({
        axis: "y",
        cursor: "move",
        placeholder: "sortable-placeholder",
        forcePlaceholderSize: true,
        opacity: 0.8,
        stop: function (event, ui) {
            var sorted = $("#themes-order-list").sortable("toArray", {attribute: 'data-value'});
            $("#themes_order").val(sorted.join());
        }
    });
});

