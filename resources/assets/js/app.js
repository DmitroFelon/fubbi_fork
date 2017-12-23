jQuery(document).ready(function ($) {
    /*
     * Hide notifications
     * */
    $(".head-notification").show(0).delay(5000).hide(150);

    /*
     * Init subscriptions form
     * */
    $(".subscribe-btn").on('click', function () {
        var amount = $(this).attr('data-amount');
        var plan_id = $(this).attr('data-plan');

        $("#plan_id").val(plan_id);
        $(".amount").html(amount);

        $("#stripe-form-wrapper").show();
        $("html, body").animate({scrollTop: $(document).height() - $(window).height()});
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
     * Update billing info form
     * */
    var $update_card_form = $("#update-card-form");
    $update_card_form.on('submit', function (e) {
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
                $('#stripeToken').val(token);
                $update_card_form.unbind('submit');
                $update_card_form.submit();
            }
        });
    });

    /*
     * Init quiz form with steps
     * */
    $("#quiz-form").steps({
        bodyTag: "fieldset",
        enableAllSteps: user.role == 'client' ? false : true,
        showFinishButtonAlways: user.role == 'client' ? false : true,
        autoFocus: false,
        onInit: function (event, currentIndex) {
            if (typeof(Storage) !== "undefined") {
                if (typeof(localStorage.getItem("quiz-form-step")) !== "undefined") {
                    jQuery("#quiz-form-t-" + localStorage.getItem("quiz-form-step")).click();
                }
            } else {
            }
        },
        onStepChanging: function (event, currentIndex) {
            //todo add validation
            return true;
        },
        onStepChanged: function (event, currentIndex) {
            //todo save data to server
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem("quiz-form-step", currentIndex);
            } else {
            }
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
     * Init keywords form with steps
     * */
    $("#keywords-form").steps({
        bodyTag: "fieldset",
        enableAllSteps: true,
        showFinishButtonAlways: user.role == 'client' ? false : true,
        autoFocus: false,
        labels: {
            loading: "Loading related keywords..."
        },
        onInit: function (event, currentIndex) {
        },
        onStepChanging: function (event, currentIndex) {
            /*if (!validateKeywords(event, currentIndex)) {
             return false;
             }*/

            preUploadKeywords();

            return true;
        },
        onStepChanged: function (event, currentIndex) {
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem("keywords-form-step", currentIndex);
            } else {
            }
        },
        onFinishing: function (event, currentIndex) {
            /*if (!validateKeywords(event, currentIndex)) {
             return false;
             }*/

            preUploadKeywords();
            return true;
        },
        onContentLoaded: function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        },
        onFinished: function (event, currentIndex) {
            var form = $(this);
            form.submit();
        },
    });

    /*
    * Add manual keyword
    * todo save manual keyword alongside with keywords from keywordtool
    * */
    $(document).on("click", "button.keyword-input-submit", function (e) {
        e.preventDefault();
        var theme = $(this).attr('data-theme');
        var input = $('input[data-theme="' + theme + '"]').val();
        var wrapper = $('div[data-theme="' + theme + '"]');

        wrapper.append(
            '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">' +
            '<div class="i-checks">' +
            '<label><input class="keywords-checkbox" checked ' +
            'type="checkbox" name="keywords[' + theme + '][' + input + ']" ' +
            'value="true"> <i></i>' + input + '</label></div></div>'
        );

        $('input[data-theme="' + theme + '"]').val('');


        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });


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

    function showToastError(message, title = '') {

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }


        toastr.error(title, message);
    }

    function validateKeywords(event, currentIndex) {
        var section = $("#keywords-form-p-" + currentIndex);
        var theme = section.attr('data-theme');
        var total_keywords = jQuery('[name^="keywords[' + theme + ']"]').length;
        var checked_keywords = jQuery('[name^="keywords[' + theme + ']"]:checked').length;

        if (total_keywords >= 5 && checked_keywords < 5) {
            showToastError('Form filling error', 'Please, chose at least 5 keywords');
            return false;
        }

        return true;
    }

    function preUploadKeywords() {
        var formData = $("#keywords-form").serialize();
        var _project_id = $("input[name=_project_id]").val();

        jQuery.ajax('/projects/' + _project_id + '/prefill', {
            processData: false,
            contentType: false,
            data: formData
        });
    }

    /*
     * Article textarea
     * */
    $("#article-textarea").markdown(
        {
            autofocus: false,
            savable: false,
            resize: 'vertical',
            fullscreen: {enable: false},
            hiddenButtons: ['Image', 'Url']
        }
    );

    /*
     * Init footable table
     * */
    $('.footable').footable();

    /*
     * iChecks
     * */
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
});



