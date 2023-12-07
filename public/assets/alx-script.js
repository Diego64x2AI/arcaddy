$( document ).ready(function() {
    ANA.init();
});

var ANA = new (function(){
    
    this.init = function(){

    	$('.btn-seccion').on('click', function(){

            $('#ana-ul-menu').removeClass('abrir');
            //$('#btn-menu-mobile').removeClass('cerrar');

            var p = $( '#cont-'+$(this).data('seccion'));
            var pos = p.offset().top - 50;
            $("html, body").stop(true, true).animate(
                {scrollTop: pos },
                1000
            );
            return false;
        });
    	

    	$('#ana-h-btn-menu').on("click", function(){ 
    			
    		if(!$('#ana-ul-menu').hasClass('abrir')){
    			$('#ana-ul-menu').addClass('abrir');
    			
    		}
    		else{
    			$('#ana-ul-menu').removeClass('abrir');
    			
    		}
    	
    	});
        
        $('.owl-carousel').owlCarousel({
		    loop:true,
		    margin:0,
		    nav:true,
		    responsive:{
		        0:{
		            items:1
		        },
		        550:{
		            items:1
		        },
		        650:{
		            items:2
		        },
		        800:{
		            items:3
		        },
		        992:{
		            items:4
		        },
		        1200:{
		            items:5
		        },
		        2000:{
		            items:6
		        }
		    }
		});
        
        
       
    };

})();