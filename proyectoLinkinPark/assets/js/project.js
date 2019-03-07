(function() {
    console.log('Projectos JS');
    
    /**
     * Funcion para el sistema de paginacion
     * 
     */
    function paginate(callback, total=5, start=true) {
    	var pr = document.querySelector( '.paginate.left' );
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
    	slide(0);	
    }
    
    paginate(function(a){
    	console.log(a);
    });

    
})();