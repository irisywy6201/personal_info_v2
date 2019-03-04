'use strict';

$('#updateCategory').on('show.bs.modal',function(event) {
  var button = $(event.relatedTarget);
  var value = button.data('value');
  $('#adminUpdateCategory').val(value['name']);
  $('#updateCategoryForm').attr('action', 'sdCategory/updateCategory/'+value['id']);
});

$('#updateUserCategory').on('show.bs.modal',function(event) {
  var button = $(event.relatedTarget);
  var value = button.data('value');
  $('#adminUpdateUserCategory').val(value['user']);
  $('#updateUserCategoryForm').attr('action', 'sdCategory/updateUserCategory/'+value['id']);
});

$('#updateSolCategory').on('show.bs.modal',function(event) {
  var button = $(event.relatedTarget);
  var value = button.data('value');
  $('#adminUpdateSolCategory').val(value['method']);
  $('#updateSolCategoryForm').attr('action', 'sdCategory/updateSolCategory/'+value['id']);
});

//visibility filter toggle
$(function() {
  $('#visibility-toggle1').change(function() {
    perform($(this),'1');
  });
  $('#visibility-toggle2').change(function() {
    perform($(this),'2');
  });
  $('#visibility-toggle3').change(function() {
    perform($(this),'3');
  });

  function perform($toggle,$id) {
    var oriUrl = window.location.href;
    if($toggle.prop('checked')) {
      window.location.href =oriUrl + '/visToggle/on/'+$id;
    }
    else {
      window.location.href =oriUrl + '/visToggle/off/'+$id;
    }
  }
});

//input text field keypress limiter
var limitKeyPress = [false,false,false,false,false,false];
//detect input change
// create adminCategory ,limitKeyPress key 0
$('#adminCategory').each(function() {
  var elem = $(this);
  performChange(elem,'adminCategory',0);
  // Look for changes in the value
  elem.bind("propertychange change input paste", function(event){
    // If value has changed...
    performChange(elem,'adminCategory',0);
  });
});
// create adminUserCategory ,limitKeyPress key 1
$('#adminUserCategory').each(function() {
  var elem = $(this);
  performChange(elem,'adminUserCategory',1);
  // Look for changes in the value
  elem.bind("propertychange change input paste", function(event){
    // If value has changed...
    performChange(elem,'adminUserCategory',1);
  });
});
// create adminSolCategory ,limitKeyPress key 2
$('#adminSolCategory').each(function() {
  var elem = $(this);
  performChange(elem,'adminSolCategory',2);
  // Look for changes in the value
  elem.bind("propertychange change input paste", function(event){
    // If value has changed...
    performChange(elem,'adminSolCategory',2);
  });
});
// update adminUpdateCategory ,limitKeyPress key 3
$('#adminUpdateCategory').each(function() {
  var elem = $(this);
  performChange(elem,'adminUpdateCategory',3);
  // Look for changes in the value
  elem.bind("propertychange change input paste", function(event){
    // If value has changed...
    performChange(elem,'adminUpdateCategory',3);
  });
});
// update adminUpdateUserCategory ,limitKeyPress key 4
$('#adminUpdateUserCategory').each(function() {
  var elem = $(this);
  performChange(elem,'adminUpdateUserCategory',4);
  // Look for changes in the value
  elem.bind("propertychange change input paste", function(event){
    // If value has changed...
    performChange(elem,'adminUpdateUserCategory',4);
  });
});
// update adminUpdateSolCategory ,limitKeyPress key 5
$('#adminUpdateSolCategory').each(function() {
  var elem = $(this);
  performChange(elem,'adminUpdateSolCategory',5);
  // Look for changes in the value
  elem.bind("propertychange change input paste", function(event){
    // If value has changed...
    performChange(elem,'adminUpdateSolCategory',5);
  });
});

//perform disable button and show warning text
function performChange(elem, id, key) {
  if(elem.val() == "" || elem.val().search(/^ .*/) != -1) {
    limitKeyPress[key] = true;
    $('button.'+id).addClass('disabled');
    $('label.'+id).show();
    console.log('show label '+elem.val());
  }
  else {
    limitKeyPress[key] = false;
    $('button.'+id).removeClass('disabled');
    $('label.'+id).hide();
    console.log('hide label '+elem.val());
  }
}

//control create submit by enter of input text
$('#adminCategory').on('keyup keypress', function(e){
  var keyCode = e.keyCode || e.which;
  if(keyCode === 13) {
    if(limitKeyPress[0]){
        e.preventDefault();
        console.log('prevent click');
        return false;
    }
    else {
      $('#adminCategory').unbind('on');
    }
  }
});
$('#adminUserCategory').on('keyup keypress', function(e){
  var keyCode = e.keyCode || e.which;
  if(keyCode === 13) {
    if(limitKeyPress[1]){
        e.preventDefault();
        console.log('prevent click');
        return false;
    }
    else {
      $('#adminUserCategory').unbind('on');
    }
  }
});
$('#adminSolCategory').on('keyup keypress', function(e){
  var keyCode = e.keyCode || e.which;
  if(keyCode === 13) {
    if(limitKeyPress[2]){
        e.preventDefault();
        console.log('prevent click');
        return false;
    }
    else {
      $('#adminSolCategory').unbind('on');
    }
  }
});
//control update submit by enter key of input text
$('#adminUpdateCategory').on('keyup keypress', function(e){
  var keyCode = e.keyCode || e.which;
  if(keyCode === 13) {
    if(limitKeyPress[3]){
        e.preventDefault();
        console.log('prevent click');
        return false;
    }
    else {
      $('#adminUpdateCategory').unbind('on');
    }
  }
});
$('#adminUpdateUserCategory').on('keyup keypress', function(e){
  var keyCode = e.keyCode || e.which;
  if(keyCode === 13) {
    if(limitKeyPress[4]){
        e.preventDefault();
        console.log('prevent click');
        return false;
    }
    else {
      $('#adminUpdateUserCategory').unbind('on');
    }
  }
});
$('#adminUpdateSolCategory').on('keyup keypress', function(e){
  var keyCode = e.keyCode || e.which;
  if(keyCode === 13) {
    if(limitKeyPress[5]){
        e.preventDefault();
        console.log('prevent click');
        return false;
    }
    else {
      $('#adminUpdateSolCategory').unbind('on');
    }
  }
});
