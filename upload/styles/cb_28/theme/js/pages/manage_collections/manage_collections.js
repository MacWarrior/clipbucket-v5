document.addEventListener('DOMContentLoaded', function () {
    init_tags('collection_tags', available_tags);

    document.querySelectorAll('.formSection h4').forEach(function (header) {
        header.addEventListener('click', function (e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            const nextElement = this.nextElementSibling;

            if (icon.classList.contains('glyphicon-chevron-down')) {
                icon.classList.remove('glyphicon-chevron-down');
                icon.classList.add('glyphicon-chevron-up');
            } else {
                icon.classList.remove('glyphicon-chevron-up');
                icon.classList.add('glyphicon-chevron-down');
            }

            nextElement.classList.toggle('hidden');
        });
    });

    const typeSelect = document.querySelector('select#type');
    if (typeSelect) {
        typeSelect.addEventListener('change', function () {
            showSpinner();

            const type = this.value;
            const id = document.querySelector('#collection_id').value;

            fetch(baseurl + 'actions/get_collection_update.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ type, id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.msg) {
                    const pageContent = document.querySelector('.page-content');
                    if (pageContent) {
                        pageContent.insertAdjacentHTML('afterbegin', data.msg);
                    }
                }

                if (data.sort_types && Object.keys(data.sort_types).length > 0) {
                    const sortTypeSelect = document.querySelector('#sort_type');
                    sortTypeSelect.innerHTML = '';
                    for (const key in data.sort_types) {
                        const option = document.createElement('option');
                        option.value = key;
                        option.textContent = data.sort_types[key];
                        sortTypeSelect.appendChild(option);
                    }
                }

                if (Array.isArray(data.parents)) {
                    const parentSelect = document.querySelector('#collection_id_parent');
                    parentSelect.innerHTML = '';
                    data.parents.forEach(function (parent) {
                        const option = document.createElement('option');
                        option.value = parent.id;
                        option.innerHTML = parent.name;
                        if (parent.id === null || parent.id === 'null') {
                            parentSelect.insertBefore(option, parentSelect.firstChild);
                        } else {
                            parentSelect.appendChild(option);
                        }
                    });
                    const firstOption = parentSelect.querySelector('option');
                    if (firstOption) parentSelect.value = firstOption.value;
                }
            })
            .catch(error => console.error(error))
            .finally(hideSpinner);
        });
    }

    $('#collection_id_parent').select2({
        width: '100%'
    });
});
