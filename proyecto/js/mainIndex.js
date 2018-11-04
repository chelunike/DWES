(function (){
    // Cojemos los nodos necesarios
    var tabla = document.getElementById('tablaProducto');
    var checkbox = document.getElementById('checkForAll');
    var btConfirmDelete = document.getElementById('btConfirmDelete');
    var fBorrar = document.getElementById('fBorrar');
    
    if(btConfirmDelete) {
        btConfirmDelete.addEventListener('click', function() {
            $('#confirm').modal('hide'); //jquery
            fBorrar.submit();
        });
    }
    
    
    // Eventos
    function eventsTable(evt) {
        var target = evt.target;
        // Get de element
        if(target.tagName === 'A' && target.classList.contains('borrar')){
            eventDelete(evt);
        }else if(evt.target.tagName === 'A' && evt.target.classList.contains('borrar')){
            console.log('Edit');
            evt.preventDefault();
        }else if(evt.target.tagName === 'A' && evt.target.classList.contains('editar2')){
            evt.preventDefault();
            //Recojemos nodos
            var form = document.getElementById('fEditar2');
            var inputId = document.getElementById('id');
            var id = evt.target.getAttribute('data-id');
            
            inputId.value = id;
            
            form.submit();
        }
    }
    
    function eventDelete(evt) {
        // Check confirm
        if(!confirm('Sure about that?')){
            evt.preventDefault();
        }
    }
    
    tabla.addEventListener('click', eventsTable);
    
    function eventCheck(evt){
        var checks = tabla.querySelectorAll('input[type=checkbox]');
        for(let i = 0; i<checks.length; i++) {
            checks[i].checked  = evt.target.checked;
        }
    }
    checkbox.addEventListener('click', eventCheck);
    
})();