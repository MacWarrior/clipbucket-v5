$(document).ready(function(){
    init_tags('profile_tags', available_tags);
    if ($('#profile_tags').prop('disabled')) {
        $('#list_tags').find('input').prop('disabled',true);
    }

    if( typeof format_date_js !== 'undefined' ){
        $('#dob').datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            changeMonth: true,
            dateFormat: format_date_js,
            changeYear: true,
            yearRange: "-99y:+0",
            regional: language
        });
    }

    if( mode === 'account' ) {
        $('#accountSettings').toggle();
        $('#accntSettingHead').toggleClass('accntSettingHeadarrowup')
    } else {
        $('#accntProfileSettings').toggle();
        $('#accntProfileSettingHead').toggleClass('accntSettingHeadarrowup')
    }

    $('#profile_desc').value = atob(user_profile_desc);
    $('#about_me').value = atob(user_about_me);

    if( typeof user_schools !== 'undefined' ){
        $('#schools').value = atob(user_schools);
    }
    if( typeof user_occupation !== 'undefined' ){
        $('#occupation').value = atob(user_occupation);
    }
    if( typeof user_companies !== 'undefined' ){
        $('#companies').value = atob(user_companies);
    }
    if( typeof user_hobbies !== 'undefined' ){
        $('#hobbies').value = atob(user_hobbies);
    }
    if( typeof user_movies !== 'undefined' ){
        $('#fav_movies').value = atob(user_movies);
    }
    if( typeof user_music !== 'undefined' ){
        $('#fav_music').value = atob(user_music);
    }
    if( typeof user_books !== 'undefined' ){
        $('#fav_boooks').value = atob(user_books);
    }

    $('[name="disabled_channel"]').on('change', function () {
        var inputs = $('.accountForm').find('input, textarea, select').not('#disabled_channel');
        inputs.each( (i,e)=> $(e).prop('disabled', ($(this).val() === 'yes')))
    });

    // Account deletion
    let dropButton = document.getElementById('drop_account');
    let modalElement = document.getElementById('confirmDropAccountModal');
    let confirmButton = document.getElementById('confirmDropAccountBtn');
    let target = null;

    dropButton.addEventListener('click', function (e) {
        e.preventDefault();
        target = this;
        modalElement.classList.add('in');
        modalElement.style.display = 'block';
        modalElement.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        let backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade in';
        document.body.appendChild(backdrop);
        modalElement.querySelectorAll('[data-dismiss="modal"]').forEach(function (btn) {
            btn.addEventListener('click', closeModal);
        });
    });

    confirmButton.addEventListener('click', function () {
        document.querySelector('input[type="hidden"][name="drop_account"]').removeAttribute('disabled');
        closeModal();
        document.querySelectorAll('.taskHandler').forEach(function(el) {
            el.style.display = '';
        });
        if (target) {
            target.form.submit();
        }
    });

    function closeModal() {
        modalElement.classList.remove('in');
        modalElement.style.display = 'none';
        modalElement.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        let backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }

    document.getElementById('confirmEmailBtn').addEventListener('click', function (e) {
        e.preventDefault();
        fetch(baseurl + 'actions/user_confirm_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.msg) {
                    const pageContent = document.querySelector('.manage-page');
                    if (pageContent) {
                        pageContent.insertAdjacentHTML('afterbegin', data.msg);
                    }
                }
            })
            .catch(error => console.error(error))
            .finally(hideSpinner);
    })
});
