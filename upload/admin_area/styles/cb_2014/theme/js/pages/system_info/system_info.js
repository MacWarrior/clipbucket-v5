function display_tab(divId) {
    document.querySelectorAll('ul.nav-tabs li').forEach(li => li.classList.remove('active'));

    const activeLink = document.querySelector(`ul.nav-tabs li > a[href="${divId}"]`);
    if (activeLink) {
        activeLink.parentElement.classList.add('active');
    }

    document.querySelectorAll('div.tab-content div').forEach(div => div.classList.remove('active'));

    const activeTab = document.querySelector(divId);
    if (activeTab) {
        activeTab.classList.add('active');
    }

    setHash(divId);
}

function setHash(hash) {
    window.location.hash = hash;

    const mainForm = document.getElementById('main_form');
    if (mainForm) {
        mainForm.setAttribute('action', hash);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const firstTab = document.querySelector('ul.nav-tabs li:first-child a');

    if (window.location.hash === '') {
        if (firstTab) {
            setHash(firstTab.getAttribute('href'));
        }
    } else {
        display_tab(window.location.hash);
    }

    document.querySelectorAll('ul.nav-tabs li a').forEach(link => {
        link.addEventListener('click', function (e) {
            setHash(this.getAttribute('href'));
        });
    });
});
