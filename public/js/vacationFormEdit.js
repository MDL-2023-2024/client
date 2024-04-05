document.addEventListener("DOMContentLoaded", function () {
	var selectElement = document.querySelector("#select-atelier");

	selectElement.disabled = false;

    //active tout les bouton dans le formulaire
    document.querySelectorAll(".form-list-vacation button").forEach(function (button) {
        button.disabled = false;
    });



	selectElement.addEventListener("change", function () {
		var selectedOptionId = this.value;

		//desactivation du selector le temps
		//de la requete pour eviter les requetes multiple
		// Cacher tous les formulaires ayant la classe 'form-of-menu'
		var vacationSelect = document.querySelectorAll(".form-list-vacation");
		vacationSelect.forEach(function (selectBox) {
			selectBox.classList.add("d-none");
			if (selectBox.id === "vacation-list-" + selectedOptionId) {
				selectBox.classList.remove("d-none");
			}
		});
	});

	document.querySelectorAll(".form-list-vacation").forEach(function (form) {
		form.addEventListener("submit", function (event) {
            console.log(form);
			// Trouver le bouton de soumission dans le formulaire
			var submitButton = form.querySelector(
				'button[type="submit"], input[type="submit"]'
			);

            //annule le submit
            event.preventDefault();

            //Recupere la valeur du select
            var selectValue = form.querySelector("select").value;

            //redirige vers la page de modification
            window.location.href = "/gestion/editVacation/" + selectValue;

			// Désactiver le bouton de soumission
			if (submitButton) {
				submitButton.disabled = true;
			}
		});
	});
});
