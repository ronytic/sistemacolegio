function checkPasswordStrength(password) {
    var number = /([0-9])/;
    var upperCase = /([A-Z])/;
    var lowerCase = /([a-z])/;
    var specialCharacters = /([~,!,@,#,$,%,^,&,*,\-,.,_,+,=,?,>,<])/;

    var characters = (password.length >= 5 && password.length <= 15);
    var capitalletters = password.match(upperCase) ? 1 : 0;
    var loweletters = password.match(lowerCase) ? 1 : 0;
    var numbers = password.match(number) ? 1 : 0;
    var special = password.match(specialCharacters) ? 1 : 0;

    this.update_info('length', password.length >= 6 && password.length <= 15);
    this.update_info('capital', capitalletters);
    this.update_info('small', loweletters);
    this.update_info('number', numbers);
    this.update_info('special', special);

    var total = characters + capitalletters + loweletters + numbers + special;
    this.password_meter(total);
    return total;
}

function update_info(criterion, isValid) {
    var $passwordCriteria = $('#passwordCriterion').find('li[data-criterion="' + criterion + '"]');
    if (isValid) {
        $passwordCriteria.removeClass('invalid').addClass('valid');
    } else {
        $passwordCriteria.removeClass('valid').addClass('invalid');
    }
}

function password_meter(total) {
    var meter = $('#password-strength-status');
    meter.removeClass();
    if (total === 0) {
        meter.html('');
    } else if (total === 1) {
        meter.addClass('veryweak-password').html(MuyDebilMensajeValidacion);
    } else if (total === 2) {
        meter.addClass('weak-password').html(DebilMensajeValidacion);
    } else if (total === 3) {
        meter.addClass('medium-password').html(MedioMensajeValidacion);
    } else if (total === 4) {
        meter.addClass('average-password').html(PromedioMensajeValidacion);
    } else {
        meter.addClass('strong-password').html(FuerteMensajeValidacion);
    }
}