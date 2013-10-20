$(document).ready(function() {
    initForm();
    loadOpinions();
})

/**
 * Initializes the form.
 *
 */
function initForm() {
    $('.submitButton').button();

    $('.addOpinionForm').submit(function(e) {
        e.preventDefault();
        addOpinion();
    });

}

/**
 * Adds an opinion basing on the form data.
 *
 */
function addOpinion() {
    var nick = $('#inputName').val();
    var text = $('#inputText').val();
    var language = $('#inputLanguage').val();

    if(nick == '' || text == '' || language == '') {
        return ;
    }

    $('.submitButton').button('loading');
    removeMessage();


    $.ajax({
        type: "POST",
        url: 'addOpinion.php',
        data: {nick: nick, text: text, language: language},
        complete: function() {
            resetForm();
        },
        success: function(data) {
            var text = (data == '1') ? 'Your opinion has been added.' : 'An error occurred: ' + data;
            showMessage(text, data);
            loadOpinions();
        },
        error: function(data) {
            showMessage('An error occurred.', 0);
        }
    });

}

/**
 * Shows a message on the page.
 *
 * @param message
 * @param success
 */
function showMessage(message, success) {
    removeMessage();
    $('.addOpinion').after('<div class="message alert">' + message + '</div>');

    var msg = $('.message');
    msg.prepend('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>');
    msg.addClass((success == '1') ? 'alert-success' : 'alert-danger');
    msg.alert();
}

/**
 * Removes the message from the page.
 */
function removeMessage() {
    $('.message').remove();
}

/**
 * Resets the submit button state and clears the inputs.
 *
 */
function resetForm() {
    $('#inputName').val('');
    $('#inputText').val('');
    $('.submitButton').button('reset');
}

/**
 * Loads the opinions list.
 *
 */
function loadOpinions() {
    $.get('opinionList.php', function(data) {
        $('.opinionList').remove();
        $('#content').append('<div class="opinionList">' + data + '</div>');

        $('.opinionRadio').change(function() {
            var id = $(this).attr('data-id');
            var language = $(this).attr('data-language');
            var machine = $(this).attr('data-machine');

            $('.opinionText[data-id=' + id + ']').hide();
            $('.opinionText[data-id=' + id + '][data-language=' + language + ']').show();


            if(machine == '1') {
                $('.opinionMachine[data-id=' + id + ']').show();
            }
            else {
                $('.opinionMachine[data-id=' + id + ']').hide();
            }
        })
    })
}
