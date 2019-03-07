(function() {
	// ---------------------- Sistema de Insercion Links -----------------------
	
	function getRowLink(link) {
		var tr = $(`<tr data-id="${ link.id }"></tr>`);
		
		var td = $(`<td class="w60"></td>`);
		td.append($('<input type="checkbox" name="ids[]" form="fBorrar"/>').val(link.id));
		tr.append(td);
		tr.append($(`<td data-type="url" data-name="href"></td>`).text(link.href));
		tr.append($(`<td data-type="text" data-name="comment"></td>`).text(link.comment));
		tr.append($(`<td data-type="text" data-name="category"></td>`).text(link.category.name));
		
		var check = link.visible ? '<i class="fas fa-check-circle"></i>':'<i class="fas fa-times-circle"></i>';
		tr.append($(`<td data-type="checkbox" data-name="visible"></td>`).html(check));
		tr.append($(`<td scope="row"><a class="btn btn-round btn-danger btDeleteL" href="" data-ajax="ajax/dodelete/type/link" data-id="${ link.id }">Borrar</a></td>`));
		return tr;
	}
	
	function startEvents(data) {
		deleteButtons('.btDeleteL', args);
		//deleteForm('fBorrar');
		updateValues('#tablaLinks td', args);
		
		if(data) {
			$('#pag-link').data('total', data.pagination.ultimo);	
			console.log(data.pagination.ultimo);
		}
	}
	
	// -- Argumentos para los links --
	var args = {
		url: 'ajax/action/type/link/',
		tbody: '#tablaLinks tbody',
		data: null, 
		callback: getRowLink,
		endcallback: startEvents,
	}
	var orderLink = 'id';
	var filterLink = '';
	
	// Paginacion
	var total = $('#pag-link').data('total');
	//console.log(total);
	var paginationLinks = paginate(function(pag) {
		//console.log(pag);
		var dataPag = {
			page: pag,
			order: orderLink,
			filter: filterLink
		};
		args.data = dataPag;
		actualizarTabla(args);
	}, total);
	
	
	function eventOrderTh(evt) {
		evt.preventDefault();
		if($(this).data('order')) {
			orderLink = $(this).data('order');	
		}
		
		var dataPag = {
			page: 1,
			order: orderLink,
			filter: filterLink
		};
		args.data = dataPag;
		actualizarTabla(args);
		paginationLinks.reset();
	}
	
	function eventFilter(evt) {
		evt.preventDefault();
		var data = getDataFromForm('#form-search');
		if( data.s) {
			console.log(filterLink);
			filterLink = data.s;
		}
		var dataPag = {
			page: 1,
			order: orderLink,
			filter: filterLink
		};
		args.data = dataPag;
		console.log(args.data);
		actualizarTabla(args);
		
		var total = $('#pag-link').data('total');
		console.log(total);
		paginationLinks = paginate(function(pag) {
			//console.log(pag);
			var dataPag = {
				page: pag,
				order: orderLink,
				filter: filterLink
			};
			args.data = dataPag;
			actualizarTabla(args);
		}, total);
	}
	
	// Inicializamos escuchadores de eventos
	$('#tablaLinks thead th').click(eventOrderTh);
	$('#form-search').submit(eventFilter);
	insertFormSend('#formInsertLink', args);
	startEvents();
	
	
	
	// ---------------------- Sistema de Insercion Categories -----------------------
	function getRowCategory(category) {
		var tr = $(`<tr data-id="${ category.id }"></tr>`);
		tr.append($(`<td data-type="text" data-name="name"></td>`).text(category.name));
		tr.append($(`<td scope="row"><a class="btn btn-round btn-danger btDeleteC" href="" data-ajax="ajax/dodelete/type/category" data-id="${ category.id }">Borrar</a></td>`));
		return tr;
	}
	
	function startEventsCategory(json) {
		deleteButtons('.btDeleteC', args2);
		updateValues('#tablaCategories td', args2);
	}
	
	var args2 = {
		url: 'ajax/action/type/category/',
		tbody: '#tablaCategories tbody',
		callback: getRowCategory,
		endcallback: startEventsCategory,
	}
	
	insertFormSend('#formInsertCategory', args2);
	startEventsCategory();
	
	
	$('#updateCategories').click(function(evt) {
		evt.preventDefault();
		console.log('Categories');
		actualizarTabla(args2);
	});
	
	$('#updateLinks').click(function(evt) {
		evt.preventDefault();
		console.log('Links');
		actualizarTabla(args);
	});
	
})();