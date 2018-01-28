'use strict';

$('#deleteRecord').on('show.bs.modal',function(event) {
  var button = $(event.relatedTarget);
  var itemId = button.data('id');
});

function deleteRecord() {
  var token = $('#sdRecDelete').data('token');
  $.ajax({
    url: $('#sdRecDelete').attr('value'),
    type: "post",
    data: {
      _method : 'DELETE',
      _token : token,
    },
    success: function(data){
      if(data['process'] == 'success') {
        window.location.href = data['url']+'/confirmDelete';
      }
      else {
        window.location.href = data['url']+'/failDelete';
      }
    },
  });
}
