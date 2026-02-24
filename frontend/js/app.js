/**
 * Investment Knowledge Club — Frontend Assessment
 * Handles: membership toggles, menu (Bootstrap), modal, form validation
 */

document.addEventListener('DOMContentLoaded', function () {
    initMembershipToggleIcons();
    initContactFormValidation();
    initMembershipDetailsLink();
});

/**
 * Sync chevron icon rotation with Bootstrap collapse state (Foundation / Economy membership)
 */
function initMembershipToggleIcons() {
    document.querySelectorAll('.membership-desc').forEach(function (el) {
        el.addEventListener('show.bs.collapse', function () {
            const btn = document.querySelector('.membership-header[aria-controls="' + this.id + '"]');
            if (btn) btn.setAttribute('aria-expanded', 'true');
        });
        el.addEventListener('hide.bs.collapse', function () {
            const btn = document.querySelector('.membership-header[aria-controls="' + this.id + '"]');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        });
    });
}

/**
 * Contact form: simple validation (required fields, email format)
 */
function initContactFormValidation() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateContactForm()) return;

        // Success feedback (in real app would send to server)
        const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
        if (modal) modal.hide();
        form.reset();
        form.classList.remove('was-validated');
        alert('Thank you! Your message has been sent.');
    });
}

function validateContactForm() {
    const form = document.getElementById('contactForm');
    const name = document.getElementById('contactName');
    const email = document.getElementById('contactEmail');
    const message = document.getElementById('contactMessage');

    let valid = true;
    [name, email, message].forEach(function (field) {
        if (!field.value.trim()) {
            field.setCustomValidity(field === email ? 'Please enter a valid email.' : 'This field is required.');
            valid = false;
        } else if (field === email && !isValidEmail(field.value)) {
            field.setCustomValidity('Please enter a valid email address.');
            valid = false;
        } else {
            field.setCustomValidity('');
        }
    });

    form.classList.add('was-validated');
    return valid;
}

function isValidEmail(str) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(str);
}

/**
 * "A closer look at the membership details" link: smooth scroll to memberships and optionally expand first block
 */
function initMembershipDetailsLink() {
    const link = document.getElementById('membershipDetailsLink');
    if (!link) return;

    link.addEventListener('click', function (e) {
        e.preventDefault();
        const section = document.getElementById('memberships');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
}
