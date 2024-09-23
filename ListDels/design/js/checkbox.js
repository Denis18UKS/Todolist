document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const label = this.nextElementSibling;

            if (this.checked) {
                label.classList.add('strikethrough');
            } else {
                label.classList.remove('strikethrough');
            }
        });
    });
});