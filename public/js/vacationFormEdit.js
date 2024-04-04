document.addEventListener('DOMContentLoaded', function() {
    var selectElement = document.querySelector('.form-select');
    selectElement.disabled = false;
    selectElement.addEventListener('change', function() {
        var selectedOptionId = this.value;
        var leForm = null;

        //desactivation du selector le temps 
        //de la requete pour eviter les requetes multiples
        this.disabled = true;
        // Cacher tous les formulaires ayant la classe 'form-of-menu'
        var forms = document.querySelectorAll('.form-of-menu');
        forms.forEach(function(form) {
            form.style.display = 'none';
            if (form.id === selectedOptionId) {
                leForm = form;
            }
        });

        // Si le formulaire existe déjà, affichez-le
        if (leForm !== null) {
            leForm.style.display = 'block';
        } else {
            // Sinon, charger le formulaire
            fetch('/gestion/editVacation/' + selectedOptionId)
                .then(response => response.text())
                .then(html => {
                    // L'inserer dans le dom la ou se trouve tout les forms et l'afficher
                    var formContainer = document.querySelector('#list-vacation-form');
                    formContainer.insertAdjacentHTML('beforeend', html);
                    leForm = formContainer.lastElementChild;
                    leForm.style.display = 'block';
                })
                .catch(error => console.error(error));
        }
        this.disabled = true;
    });
});