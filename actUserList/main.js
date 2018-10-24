// Funciion para encapsular
(function () {
    // Cojemos los nodos necesarios
    var editUsers = document.querySelector('header img');
    
    // Eventos
    function eventEditUsers(evt) {
        // Cojemos el formulario
        var form = document.getElementById('form');
        form.classList.toggle('hidden');
    }
    editUsers.addEventListener('click', eventEditUsers);
    
    
    function ocultarISA(evt) {
        var mensajes = document.getElementsByClassName('isa');
        for (var i = 0; i<mensajes.length; i++) {
            mensajes[i].classList.add('hidden');
        }
    }
    // Ocultamos los mensajes despues de 10seg
    setTimeout(ocultarISA, 10000);
    
    
})();