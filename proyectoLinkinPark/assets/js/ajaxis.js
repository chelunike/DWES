//(function() {
	
	console.log('Projectos JS - Todo aqui es por ajax');
	console.log('... hasta los buenos dias :)');
	
	// ---------------------- Mis funciones -----------------------
	
	/**
	 * Funcion para el sistema de paginacion
	 * 
	 */
	function paginate(callback, total=5, start=true) {
		var pr = document.querySelector( '.paginate.left' );
		var pl = document.querySelector( '.paginate.right' );
		var pfirst = document.querySelector( '.paginate-first' );
		var plast = document.querySelector( '.paginate-last' );
		
		 $(pr).off('click');
		 $(pl).off('click');
		 $(pfirst).off('click');
		 $(plast).off('click');
		
		var index = 0;
		pr.addEventListener('click', function(evt) {
			var i = slide.bind( this, -1 )() + 1;
			if(callback) {
				callback(i);
			}
		}, false);
		pl.addEventListener('click', function(evt) {
			var i = slide.bind( this, 1 )() + 1;
			if(callback) {
				callback(i);
			}
		}, false);
		
		pfirst.addEventListener('click', function(evt) {
			evt.preventDefault();
			goto.bind( this, 0 )();
			if(callback) {
				callback(1);
			}
		}, false);
		
		plast.addEventListener('click', function(evt) {
			evt.preventDefault();
			goto.bind( this, total-1 )();
			if(callback) {
				callback(total);
			}
		}, false);
		
		function slide(offset) {
		  index = Math.min( Math.max( index + offset, 0 ), total - 1 );
		  document.querySelector( '.counter' ).innerHTML = ( index + 1 ) + ' / ' + total;
		  pr.setAttribute( 'data-state', index === 0 ? 'disabled' : '' );
		  pl.setAttribute( 'data-state', index === total - 1 ? 'disabled' : '' );
		  return index;
		}
		
		function goto(i) {
			index = i;
			document.querySelector( '.counter' ).innerHTML = ( index+1 ) + ' / ' + total;
			pr.setAttribute( 'data-state', index === 0 ? 'disabled' : '' );
			pl.setAttribute( 'data-state', index === total - 1 ? 'disabled' : '' );
			return index;
		}
		
		slide(0);
		return {
			goto: goto,
			reset: () => goto(0)
		};
	}
	
	/**
	 * Funcion para el sistema de paginacion 2
	 * En proceso
	 */
	function paginateNumber(callback, total=5, start=true) {
		/*var pr = document.querySelector( '.paginate.left' );
		var pl = document.querySelector( '.paginate.right' );
	
		var index = 0;
		pr.addEventListener('click', function(evt) {
			var i = slide.bind( this, -1 )() + 1;
			if(callback) {
				callback(i);
			}
		}, false);
		pl.addEventListener('click', function(evt) {
			var i = slide.bind( this, 1 )() + 1;
			if(callback) {
				callback(i);
			}
		}, false);
	
		function slide(offset) {
		  index = Math.min( Math.max( index + offset, 0 ), total - 1 );
		  document.querySelector( '.counter' ).innerHTML = ( index + 1 ) + ' / ' + total;
		  pr.setAttribute( 'data-state', index === 0 ? 'disabled' : '' );
		  pl.setAttribute( 'data-state', index === total - 1 ? 'disabled' : '' );
		  return index;
		}
		slide(0);*/
	}
	
	function ajaxConnect(url, data, type, callBack) {
        $.ajax({
            url: url,
            data: data,
            type: type,
            dataType : 'json',
        }).done(function( json ) {
            console.log('Ajax conectado: '+url);
            callBack(json);
        }).fail(function( xhr, status, errorThrown ) {
            console.error('Error al conectar ajax '+url);
        });
	}
    
    function ajaxConnectFile(url, data, callBack) {
        var formData = new FormData();
        
        $.each( data, function(index, value) {
        	formData.append(index, value);
        });
        
        $.ajax({
            url: url,
            data: formData,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            dataType : 'json',
        })
        .done(function( json ) {
            console.log('Ajax conectado: '+url);
            callBack(json);
        })
        .fail(function( xhr, status, errorThrown ) {
            console.error('Error al conectar: '+url);
            console.log(xhr);
        });
    }
    
    function getDataFromForm(formID) {
    	var inputs = $(formID).find(':input');
    	var data = {};
    	for (let input of inputs) {
    		let name = input.getAttribute('name');
    		let type = input.getAttribute('type');
    		if(type === 'file') {
    			data[name] = input.files[0];
    		} else if(type === 'checkbox') {
    			data[name] = input.checked;
    		} else {
    			if(name !== null)
    				data[name] = input.value;
    		}
    	}
    	return data;
    }
	
	function actualizarTabla(args) {
		var data = args.data ? args.data : null;
		ajaxConnect(args.url, data,'POST', function(json) {
			//console.log(json);
			var tbody = $(args.tbody).first();
			tbody.text('');
			if(json.list) {
				for (let obj of json.list) {
					var row = args.callback(obj);
					tbody.append(row);
				}
				if(args.endcallback) {
					args.endcallback(json);
				}	
			}
		});
	}
	
	/**
	 * 
	 * 
	 */
	function insertFormSend(formID, args) {
		var form = $(formID);
		
		// Cojemos url donde enviar
		var url = form.data('ajax');
		
		// Submit para enviar los datos
		form.submit(function(evt) {
			evt.preventDefault();
			// Recojer datos: 
			//console.log(form.serializeArray());
			var data = getDataFromForm(formID);
			
			console.log(data);
			// Enviar por ajax a la direccion
			ajaxConnectFile(url, data, function(response) {
				//Recojer la respuesta e imprimirla
				if(response.action) {
					console.log('Insertado Correctamente');
					//form.reset();
					actualizarTabla(args);
				} else {
					console.error('No se ha insertado');
				}
			});
		});
		
		// Evento reset del formulario, solo el formulario :)
		/*form.on('reset', function(evt) {
			if (!confirm('Estas seguro??')) {
				evt.preventDefault();
			}
		});*/
	}
	
	function deleteButtons(btClass, args) {
		var buttons = $(btClass);
		/* formID = $(btClass).attr('form');
		var form = document.getElementById(formID);
		var url  = $(form).attr('ajax');*/
		
		var url = $(btClass).data('ajax');
		$.each(buttons, function(index, value) {
			$(this).on('click', function(evt) {
				evt.preventDefault();
				var data = {'id': $(this).data('id')};
				ajaxConnect(url, data, 'POST', function(response) {
					if(response.action) {
						console.log('Borrado Correcto');
						actualizarTabla(args);
					} else {
						console.error('Borrado incorrecto');
					}
				});
			});
		});
	}
	
	function deleteForm(formID, args) {
		var form = document.getElementById(formID);
		var url = form.getAttribute('ajax');
		$(form).on('submit', function(evt) {
			evt.preventDefault();
			var data = [];
			$.each(form, function(index, value) {
				if($(value).is('input') && value.checked) {
					data.push(value.value);
				}
			});
			ajaxConnect(url, {'ids':data}, 'POST', function(response) {
				if(response.action) {
					console.log('Borrado Correcto');
					actualizarTabla(args);
				} else {
					console.error('Borrado incorrecto');
				}
			});
		});
	}
	
	function updateData(id, name, input, type, url, args) {
		var data = { 'id': id };
		var value = $(input).val();
		if(type === 'file') {
			value = input[0].files[0];
		} else if (type === 'checkbox') {
			value = input[0].checked ? 1 : 0;
		} else if ( type == 'select') {
			
		}
		data[name] = value;
		console.log(url);
		ajaxConnectFile(url, data, function(response) {
			if(response.action) {
				console.log('Upload Correcto');
				actualizarTabla(args);
			} else {
				console.error('Upload incorrecto');
			}
		});
	}
	
	function changeCell(cell, value, args) {
		var id = $(cell).parent().data('id');
		var url = $(cell).closest('table').data('update');
		var type = $(cell).data('type');
		var name = $(cell).data('name');
		console.log(cell);
		if (type !== undefined && name !== undefined) {
			// Creamos el input
			var html = `<input type="${type}" name="${name}" value="${value}" class="edit" data-id="${id}" />`;
			// y se añade
			$(cell).html(html);
			var input = $('.edit');
			input.focus();
			input.keyup(function(evt) {
				if (evt.keyCode == 13) {
					console.log('Updating');
					updateData(id, name, input, type, url,args);
					$(cell).text(input.val());
				}
			});
			input.focusout(function() {
				console.log('Updating');
				updateData(id, name, input, type, url, args);
				$(cell).text(input.val().trim());
			});
		}
	}
	
	function updateValues(td, args) {
		$(td).off('dblclick');
		$(td).on('dblclick', function(evt) {
        	var cell = $(this);
			changeCell(cell[0], cell.text(), args);
		});
	}
	
//==================================================================================================================================

	// ---------------------- Sistema de Paginacion ----------------------
	/*var total = $('.counter').first().data('total');
	paginate(function(a){
		console.log(a);
	}, total);*/
	
	// ---------------------- Sistema de Insercion -----------------------
	/*
	
	function getRowProject(project) {
		return $(`<tr data-id="${ project.id }">
					<td class="w60" data-type="file"  data-name="fichero">
						<input type="checkbox" name="ids[]" value="${ project.id }" form="fBorrar"/>
						<img src="data:image/png;base64,${project.image}" data-toggle="tooltip" data-placement="top" title="Project image" alt="Project" class="w35 rounded">
					</td>
					<td data-type="text" data-name="title">${ project.title }</td>
					<td data-type="text" data-name="author">${ project.author }</td>
					<td data-type="date" data-name="date">${ project.date }</td>
					<td data-type="text" data-name="excerpt">${ project.excerpt }</td>
					<td data-type="checkbox" data-name="active">${ project.active ? '<i class="fas fa-check-circle"></i>':'<i class="fas fa-times-circle"></i>'}</td>
					<td scope="row"><a class="btn btn-round btn-danger btDelete" href="dashboard/dodelete?id=${ project.id }" data-id="${ project.id }">Borrar</a></td>
				</tr>`);
	}
	
	
	function startEvents() {
		deleteButtons('.btDelete');
		deleteForm('fBorrar');
		updateValues($('#tablaProject tbody td'));
	}
	
	insertFormSend('#formInsert', getRowProject, startEvents);
	
	startEvents();
	*/
//})();