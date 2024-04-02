document.addEventListener("DOMContentLoaded", function () {
	const menus = document.querySelectorAll('.radio-menu input[type="radio"]');
    const listMenu = document.querySelector('#list-menu');
	menus.forEach(function (menu) {
		menu.addEventListener("change", function () {
			const selectedMenuId = this.id;
			document.querySelectorAll(".form-of-menu").forEach(function (form) {
				if (form.getAttribute("form-for") === selectedMenuId) {
					form.classList.add("d-block");
                    form.classList.remove("d-none");
				} else {
                    form.classList.add("d-none");
					form.classList.remove("d-block");
				}
			});
            try {
                document.querySelector('#notif-info').classList.add('d-none');
            } catch (error) {
                null;
            }
		});
	});
});
