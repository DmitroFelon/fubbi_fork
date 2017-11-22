/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


$(document).ready(function () {
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
    var themes_order = [];
    var tag_themes_input = $('#themes');
    tag_themes_input.on('itemAdded', function (event) {
        $("#themes-order-list-wrapper").removeClass('hide');
        $('#themes-order-list').append('' +
            '<li class="list-group-item" data-value="' + event.item + '">' + event.item + '</li>'
        );
        var sorted = $("#themes-order-list").sortable("toArray", {attribute: 'data-value'});
        $("#themes_order").val(sorted.join());
    });
    tag_themes_input.on('itemRemoved', function (event) {
        $('.list-group-item[data-value="' + event.item + '"]').remove();
        var sorted = $("#themes-order-list").sortable("toArray", {attribute: 'data-value'});
        $("#themes_order").val(sorted.join());
        if (tag_themes_input.val() == '') {
            $("#themes-order-list-wrapper").addClass('hide');
        }
    });
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
    $(".has-error").on('click', function () {
        $(this).removeClass("has-error")
    });
    $("input").on('keydown', function (event) {
        if (event.keyCode == 13) {
            return false
        }
    })
});