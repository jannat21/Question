  
var $modal = $('#change_password');
$('.change_password').on('click', function(){
	$modal.load('change_password_view', '', function(){
      $modal.modal('show');
	  });   
});





