/* Funcion de Encapsulamiento */
(function() {
	var $ = id => { return document.getElementById(id) };
	// Menu Movil Ocultar o Mostrar
	var menu = $('menuIco');
	
	function eventoOcultar(evt) {
		// Alternamos Clases
		var lista = $('menu');
		console.log(lista);
		lista.classList.toggle('hidden');
		lista.classList.toggle('menu');
	}

	menu.addEventListener('click', eventoOcultar, false);

	/*var repl = document.getElementById('terminal') || null;
	if(repl !== null) {
		repl.addEventListener('click', function(event) {
			var target = event.target;
			var next = target.nextElementSibling;
			console.log(next);	
			if(next !== undefined) {
				target.setAttribute('src', 'assets/img/cross.svg')
				if(next.classList.contains('hidden')) {
					target.setAttribute('src', 'assets/img/terminal2.png');
				}
				target.classList.toggle('cross');
				next.classList.toggle('hidden');
				next.classList.toggle('python-repl');
			}
		}, false);
	}*/

})();
