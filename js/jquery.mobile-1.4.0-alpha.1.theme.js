url = 'php/horario_temp_all.html';
$(function() {
      $(document).on('change','#sede',function() {
		   cambiarSede();
    });
}); 
$(function() {
	  $(document).on('change','#edificio',function() {
		   cambiarEdificio();
    });
});

 function cambiarSede() {
     if ($('#radio-choice-t-6b').is(':checked')==true){
		  url = 'php/horario_temp_v.html';
		  buses ='buses_v.html'
		  $.cookie('radio-choice-t-6b',"true", { expires: 1000, path: '/'});
		  $.cookie('radio-choice-t-6a',"false", { expires: 1000, path: '/'});
		  $('#pre').prop('disabled',true).prop('checked',false).checkboxradio("refresh");
		  $('#post').prop('disabled',true).prop('checked',false).checkboxradio("refresh");
		  $('#bus').prop('href',buses);
	 }
	 else {
		  buses ='buses.html'
		  $.cookie('radio-choice-t-6a',"true", { expires: 1000, path: '/'});
		  $.cookie('radio-choice-t-6b',"false", { expires: 1000, path: '/'});
		  $('#pre').prop('checked',true).prop('disabled',false).checkboxradio("refresh");
		  $('#talleres').prop('checked',true).prop('disabled',false).checkboxradio("refresh");
		  $('#post').prop('checked',true).prop('disabled',false).checkboxradio("refresh");
		  $('#bus').prop('href',buses);
		 cambiarEdificio();	  
	 } 
	 cargarHorario();
 }
 function cambiarEdificio() {
	 if ($('#pre').is(':checked') == true && $('#talleres').is(':checked') == true && $('#post').is(':checked') == true){
	 	  $.cookie('pre',"true", { expires: 1000, path: '/'});
		  $.cookie('talleres',"true", { expires: 1000, path: '/'});
		  $.cookie('post',"true", { expires: 1000, path: '/'});
		  url = 'php/horario_temp_all.html';
	 }
	 else if ($('#pre').is(':checked') == true && $('#talleres').is(':checked') == false && $('#post').is(':checked') == false){
	 	  $.cookie('pre',"true", { expires: 1000, path: '/'});
		  $.cookie('talleres',"false", { expires: 1000, path: '/'});
		  $.cookie('post',"false", { expires: 1000, path: '/'});
		  url = 'php/horario_temp_pre.html';
	 }
	 else if ($('#pre').is(':checked') == false && $('#talleres').is(':checked') == false && $('#post').is(':checked') == true){
	 	  $.cookie('pre',"false", { expires: 1000, path: '/'});
		  $.cookie('talleres',"false", { expires: 1000, path: '/'});
		  $.cookie('post',"true", { expires: 1000, path: '/'});
		  url = 'php/horario_temp_post.html';
	 }
	  else if ($('#pre').is(':checked') == false && $('#talleres').is(':checked') == true && $('#post').is(':checked') == false){
	 	  $.cookie('pre',"false", { expires: 1000, path: '/'});
		  $.cookie('talleres',"true", { expires: 1000, path: '/'});
		  $.cookie('post',"false", { expires: 1000, path: '/'});
		  url = 'php/horario_temp_talleres.html';
	 }
	 else  {
		  url = 'php/horario_temp_all.html';
	 	  $.cookie('pre',"true", { expires: 1000, path: '/'});
		  $.cookie('talleres',"true", { expires: 1000, path: '/'});
		  $.cookie('post',"true", { expires: 1000, path: '/'});
		  ;}
	 cargarHorario()
	 }
 function cargarHorario() {
 $.ajax({
 url: url,
 cache: false}).done(function(html) {
 $('#horario').empty();
 $("#horario").append(html+'</li><li id="no-results">No se encontraron resultados.</li>').listview("refresh");
 });
 }
$(document).delegate('[data-role="page"]', 'pageinit', function () {
	$("#foot").on("swipeleft",function(){
		$("#nav-options").panel("open");
	});
	$("#foot").on("swiperight",function(){
		$("#nav-panel").panel( "open");
	});
if($.cookie('radio-choice-t-6a') == 'true'){
	//Stgo
	$("#radio-choice-t-6a").prop('checked',true).checkboxradio("refresh");
	$("#radio-choice-t-6b").prop('checked',false).checkboxradio("refresh");
	if ($.cookie('pre') == 'true' && $.cookie('post') == 'false' && $.cookie('talleres') == 'false') {
			$("#pre").prop('checked',true).checkboxradio("refresh");
			$("#talleres").prop('checked',false).checkboxradio("refresh");
			$("#post").prop('checked',false).checkboxradio("refresh");
	}
	else if ($.cookie('pre') == 'true' && $.cookie('post') == 'true' && $.cookie('talleres') == 'true') {
			$("#pre").prop('checked',true).checkboxradio("refresh");
			$("#talleres").prop('checked',true).checkboxradio("refresh");
			$("#post").prop('checked',true).checkboxradio("refresh");
	}
	else if ($.cookie('pre') == 'false' && $.cookie('post') == 'true' && $.cookie('talleres') == 'false') {
			$("#pre").prop('checked',false).checkboxradio("refresh");
			$("#talleres").prop('checked',false).checkboxradio("refresh");
			$("#post").prop('checked',true).checkboxradio("refresh");
	}
	else if ($.cookie('pre') == 'false' && $.cookie('post') == 'false' && $.cookie('talleres') == 'false') {
			$("#pre").prop('checked',false).checkboxradio("refresh");
			$("#talleres").prop('checked',false).checkboxradio("refresh");
			$("#post").prop('checked',false).checkboxradio("refresh");
	}
	else if ($.cookie('pre') == 'false' && $.cookie('post') == 'false' && $.cookie('talleres') == 'true') {
			$("#pre").prop('checked',false).checkboxradio("refresh");
			$("#talleres").prop('checked',true).checkboxradio("refresh");
			$("#post").prop('checked',false).checkboxradio("refresh");
	}
	cambiarEdificio();
}
else if ($.cookie('radio-choice-t-6a') == 'false') {
	$("#radio-choice-t-6a").prop('checked',false).checkboxradio("refresh");
	$("#radio-choice-t-6b").prop('checked',true).checkboxradio("refresh");
    cambiarSede();
}
else {
	$.jGrowl("Puedes cambiar de sede y edificio apretando la tuerca o deslizando el dedo desde la tuerca hacia la izquierda.", { life: 4000});
	  $.cookie('radio-choice-t-6a',"true", { expires: 1000, path: '/'});
		  $.cookie('radio-choice-t-6b',"false", { expires: 1000, path: '/'});
}
cargarHorario();
setInterval(function() {cargarHorario();},60000);
    var $listview = $('#horario');
    $(this).delegate('input[data-type="search"]', 'keyup', function () {
        if ($listview.children(':visible').not('#no-results').length === 0) {
            $('#no-results').fadeIn(500);
        } else {
            $('#no-results').fadeOut(250);
        }
    });
});