$(document).ready(function(){

  tinymce.init({selector: '#creation'});

  $('select').change(function(){
    this.form.submit();
  });
  // Alertes
  $('.feedback').click(function() {
    alert("L'action a été effectué.");
  });
  $('.confirm').click(function() {
      if (!confirm( "Êtes-vous sur de vouloir effectuer cette action ?")) event.preventDefault();
  });
  $('.confirm-feedback').click(function() {
      if (confirm( "Êtes-vous sur de vouloir effectuer cette action ?")) {
          alert("L'action a été effectué.")
      }
      else {
          event.preventDefault();
      }
  });
  // Ajax
  $('.random-name').click(function(){
    $.ajax({
      url: 'https://randomuser.me/api/', // API qui permet de choisir un pseudonyme aléatoire lors de la création d'un compte.
      dataType: 'json',
      success: function(data) {
        $('#pseudo:text').val(data.results[0].login.username);
      },
      error: function() {
        alert("Erreur : La fonction n'a pas pu être effectué.");
      }
    });
  });
  $('.report').click(function(){
    var t = $(this);
    $.ajax({
      type: 'GET',
      url: 'index.php',
      data: { action: 'reportComment', id: t.data('id') },
      dataType: 'html',
      success: function() {
        t.hide();
      },
      error: function() {
        alert("Erreur : La fonction n'a pas pu être effectué.");
      }
    });
  });
  $('.approve').click(function(){
    var t = $(this);
    $.ajax({
      type: 'GET',
      url: 'index.php',
      data: { action: 'approveComment', token: t.data('token'), id: t.data('id') },
      dataType: 'html',
      success: function() {
        t.hide();
      },
      error: function() {
        alert("Erreur : La fonction n'a pas pu être effectué.");
      }
    });
  });
  $('.delete').click(function(){
    var t = $(this);
    $.ajax({
      type: 'GET',
      url: 'index.php',
      data: { action: 'deleteComment', token: t.data('token'), id: t.data('id') },
      dataType: 'html',
      success: function() {
        $('#' + t.data('id')).hide();
      },
      error: function() {
        alert("Erreur : La fonction n'a pas pu être effectué.");
      }
    });
  });
});