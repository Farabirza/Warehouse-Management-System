const domain = 'http://localhost:8000/';
// const domain = 'https://cvkreatif.com/';

/**
* Main Javascript
*/

$(window).resize(function() {
  if($(window).width() < 992) {
      $('.flex-remove-md').removeClass('d-flex');
  } else {
      $('.flex-remove-md').removeClass('d-flex').addClass('d-flex');
  }
});

const confirmDelete = (message) => {
  Swal.fire({
      title: 'Are you sure?',
      icon: 'info',
      text: message,
      showCancelButton: true,
      cancelButtonColor: '#666',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#d9534f',
      confirmButtonText: "Delete"
      }).then((result) => {
      if(result.isConfirmed) {
          return true;  
      } else { return false; }
  });
};

$(document).ready(function(){

  $('.btn-warn').click(function(e){
      e.preventDefault();
      var url = $(this).attr('href');
      Swal.fire({
          title: 'Are you sure?',
          icon: 'info',
          text: $(this).attr('data-warning'),
          showCancelButton: true,
          cancelButtonColor: '#666',
          cancelButtonText: 'Cancel',
          confirmButtonColor: '#0d6efd',
          confirmButtonText: "Continue"
          }).then((result) => {
          if(!result.isConfirmed) {
              return false;
          }
          return window.location.href = url;
      })
  });

  // window size
  if($(window).width() < 992) {
      $('.flex-remove-md').removeClass('d-flex');
  } else {
      $('.flex-remove-md').removeClass('d-flex').addClass('d-flex');
  }
});