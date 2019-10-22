var regExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var button = document.getElementById('form-button');


button.addEventListener("click", function () {

    if (button.classList.contains("contact-me")) {
        $(".collapse").collapse("show");
        button.innerHTML = 'Send !';
        button.classList.remove("contact-me");
        button.classList.add("send");
        button.classList.add("disabled");
        button.setAttribute("data-original-title", "The required fields are incomplete");
        // noinspection JSUnresolvedFunction
        $('[data-toggle="tooltip"]').tooltip();
    }

    else if (button.classList.contains("send")) {
        if ((regExp.test(document.form1.email.value)) && !(document.form1.bmessage.value === '')) {
            $.post("css_js/contact_me.php", {email: document.form1.email.value, bmessage: document.form1.bmessage.value});
            document.form1.reset();
            button.classList.add("contact-me");
            button.classList.remove("send");
            $(".collapse").collapse("hide");
            button.innerHTML = 'Contact me';
            $("#thank-you").modal("show");
            document.getElementById('email').classList.remove('valid-input');
            document.getElementById('bmessage').classList.remove('valid-input');
        }
    }
});



document.form1.email.addEventListener('keyup', function () {

    activate_button();

    if(!regExp.test(document.form1.email.value)) {
        document.getElementById('invalid-feedback-email').innerHTML = 'Please fill out this field with an email address';
        document.getElementById('email').classList.add('invalid-input');
        document.getElementById('email').classList.remove('valid-input');
    }
    else {
        document.getElementById('invalid-feedback-email').innerHTML = '';
        document.getElementById('email').classList.add('valid-input');
        document.getElementById('email').classList.remove('invalid-input');
    }
});



document.form1.email.addEventListener('blur', function () {

    activate_button();

    if((document.form1.email.value === "") || (!regExp.test(document.form1.email.value))){
        document.getElementById('invalid-feedback-email').innerHTML = 'Please fill out this field with an email address';
        document.getElementById('email').classList.add('invalid-input');
        document.getElementById('email').classList.remove('valid-input');
        button.classList.add("disabled");
        button.setAttribute("title", "The required fields are incomplete");

    }
    if(regExp.test(document.form1.email.value)) {
        document.getElementById('invalid-feedback-email').innerHTML = '';
        document.getElementById('email').classList.add('valid-input');
        document.getElementById('email').classList.remove('invalid-input');
    }
});



document.form1.bmessage.addEventListener('blur', function () {

    activate_button();

    if (document.form1.bmessage.value === '') {
        document.getElementById('invalid-feedback-message').innerHTML = 'Please fill out this field';
        document.getElementById('bmessage').classList.add('invalid-input');
        document.getElementById('bmessage').classList.remove('valid-input');
        button.classList.add("disabled");
        button.setAttribute("title", "The required fields are incomplete");
    }
    else {
        document.getElementById('invalid-feedback-message').innerHTML = '';
        document.getElementById('bmessage').classList.add('valid-input');
        document.getElementById('bmessage').classList.remove('invalid-input');
    }
});

document.form1.bmessage.addEventListener('keyup', function() {
    activate_button();
});


function activate_button() {
    if ((regExp.test(document.form1.email.value)) && !(document.form1.bmessage.value === '')) {
        button.classList.remove("disabled");
        button.setAttribute("data-original-title", "");
        button.setAttribute("title", "");

    }
    else {
        button.classList.add("disabled");
        button.setAttribute("data-original-title", "The required fields are incomplete");
    }
}

document.addEventListener('keydown', function (event) {

    if (event.code === 'Escape') {
        button.classList.remove("disabled");
        button.setAttribute("data-original-title", "");
        button.setAttribute("title", "");
        button.classList.add("contact-me");
        button.classList.remove("send");
        $(".collapse").collapse("hide");
        button.innerHTML = 'Contact me';
        $("#thank-you").modal("hide");
    }
});