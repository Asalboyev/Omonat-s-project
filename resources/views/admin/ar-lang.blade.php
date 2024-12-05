<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('a[data-bs-toggle="tab"]');
        const extraFields = document.getElementById('extra-arabic-fields');

        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (event) {
                const lang = event.target.getAttribute('data-lang');
                const formElements = document.querySelectorAll(`#${lang} input, #${lang} textarea`);

                if (lang === 'ar') {
                    extraFields.style.display = 'block';
                    formElements.forEach(element => {
                        element.style.direction = 'rtl';
                        element.style.textAlign = 'right';

                        if (element.classList.contains('ckeditor')) {
                            CKEDITOR.instances[element.name].destroy();
                            CKEDITOR.replace(element.name, {
                                contentsLangDirection: 'rtl'
                            });
                        }
                    });
                } else {
                    extraFields.style.display = 'none';
                    formElements.forEach(element => {
                        element.style.direction = 'ltr';
                        element.style.textAlign = 'left';

                        if (element.classList.contains('ckeditor')) {
                            CKEDITOR.instances[element.name].destroy();
                            CKEDITOR.replace(element.name, {
                                contentsLangDirection: 'ltr'
                            });
                        }
                    });
                }
            });
        });

        // Initial check in case Arabic is the first active tab
        const activeTab = document.querySelector('a.nav-link.active');
        if (activeTab && activeTab.getAttribute('data-lang') === 'ar') {
            extraFields.style.display = 'block';
            const formElements = document.querySelectorAll('#ar input, #ar textarea');
            formElements.forEach(element => {
                element.style.direction = 'rtl';
                element.style.textAlign = 'right';

                if (element.classList.contains('ckeditor')) {
                    CKEDITOR.instances[element.name].destroy();
                    CKEDITOR.replace(element.name, {
                        contentsLangDirection: 'rtl'
                    });
                }
            });
        }
    });

</script>
