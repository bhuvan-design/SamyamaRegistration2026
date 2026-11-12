
$(document).ready(function () {

    const form = $('#eventForm');

    if (!form.length) {
        return;
    }

    // Field validation rules

    const validators = {

        name: value =>
            value.trim().length >= 2
                ? ''
                : 'Please enter your full name.',

        usn: value =>
            value.trim() !== ''
                ? ''
                : 'Please enter your USN / Student ID.',

        department: value =>
            value !== ''
                ? ''
                : 'Please select your department.',

        year: value =>
            value !== ''
                ? ''
                : 'Please select your year of study.',

        email: value =>
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
                ? ''
                : 'Enter a valid email address.',

        phone: value =>
            /^[0-9+\-\s()]{8,16}$/.test(value)
                ? ''
                : 'Enter a valid contact number.'

    };


    // Validate individual fields

    function validateField(id) {

        const field = $('#' + id);

        const message = validators[id](
            field.val() || ''
        );

        field.toggleClass('invalid', !!message);

        field.closest('.field')
            .find('.field-error')
            .text(message);

        return !message;
    }


    // Validate when user leaves a field

    Object.keys(validators).forEach(function (id) {

        $('#' + id).on('blur change', function () {

            validateField(id);

        });

    });


    // Individual / Team selection

    function toggleTeamFields() {

        const selectedType =
            $('input[name="type"]:checked').val();

        const isTeam = selectedType === 'Team';

        $('#teamFields').stop(true, true).slideToggle(
            180,
            isTeam
        );

        $('#team_name, #team_size').prop(
            'required',
            isTeam
        );
    }


    $('input[name="type"]').on(
        'change',
        toggleTeamFields
    );

    toggleTeamFields();


    // Form submission validation

    form.on('submit', function (event) {

        let valid = true;


        // Validate all normal fields

        Object.keys(validators).forEach(function (id) {

            if (!validateField(id)) {
                valid = false;
            }

        });


        // Activity selection validation

        if (!$('input[name="activity[]"]:checked').length) {

            valid = false;

            if (!$('#activityError').length) {

                $('.activity-grid').after(
                    '<small id="activityError" class="field-error">' +
                    'Select at least one activity.' +
                    '</small>'
                );

            }

        } else {

            $('#activityError').remove();

        }


        // Team validation

        const isTeam =
            $('input[name="type"]:checked').val() === 'Team';

        if (isTeam) {

            const teamName = $('#team_name').val().trim();

            const teamSize = $('#team_size').val();

            if (!teamName) {

                valid = false;

                $('#team_name').css(
                    'border-color',
                    '#c72d2c'
                );

            } else {

                $('#team_name').css(
                    'border-color',
                    ''
                );

            }


            if (!/^(?:[2-9]|[12][0-9]|30)$/.test(teamSize)) {

                valid = false;

                $('#team_size').css(
                    'border-color',
                    '#c72d2c'
                );

            } else {

                $('#team_size').css(
                    'border-color',
                    ''
                );

            }

        }


        // Declaration checkbox

        const declaration =
            $('input[name="declaration"]').is(':checked');

        $('#declarationError').text(
            declaration
                ? ''
                : 'Please confirm your details.'
        );

        if (!declaration) {
            valid = false;
        }


        // Stop submission if validation fails

        if (!valid) {

            event.preventDefault();

            const firstInvalid =
                $('.invalid').first();

            if (firstInvalid.length) {

                firstInvalid.trigger('focus');

            }

            return;

        }


        // Disable button to prevent multiple submissions

        form.find('button[type="submit"]')
            .prop('disabled', true)
            .html(
                'Submitting registration <span>…</span>'
            );

    });

});
