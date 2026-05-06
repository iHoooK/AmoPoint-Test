(function () {
    var typeSelect = document.querySelector('select[name="type_val"]');

    if (!typeSelect) {
        return;
    }

    var controlledFields = Array.prototype.slice
        .call(document.querySelectorAll('[name]'))
        .filter(function (element) {
            return element !== typeSelect;
        })
        .map(function (element) {
            var container = element.closest('p') || element;

            return {
                element: element,
                container: container,
                initialDisplay: window.getComputedStyle(container).display === 'none'
                    ? ''
                    : window.getComputedStyle(container).display,
            };
        });

    var emptyParagraphs = Array.prototype.slice
        .call(document.querySelectorAll('p'))
        .filter(function (paragraph) {
            if (paragraph.querySelector('input, select, textarea, button')) {
                return false;
            }

            var normalizedText = paragraph.innerHTML
                .replace(/&nbsp;/gi, ' ')
                .replace(/\s+/g, '')
                .trim();

            return normalizedText === '';
        });

    function hideEmptyParagraphs() {
        emptyParagraphs.forEach(function (paragraph) {
            paragraph.style.display = 'none';
        });
    }

    function syncVisibleFields() {
        var selectedType = String(typeSelect.value);

        controlledFields.forEach(function (field) {
            var isVisible = field.element.name.indexOf(selectedType) !== -1;

            field.container.style.display = isVisible ? field.initialDisplay : 'none';
            field.element.disabled = !isVisible;
        });
    }

    typeSelect.addEventListener('change', syncVisibleFields);
    hideEmptyParagraphs();
    syncVisibleFields();
}());
