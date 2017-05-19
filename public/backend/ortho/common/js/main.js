
function setGreen(objNew, serviceIdNew, value, text, group) {
	tdNewCls = objNew.attr('class');
	objNew.removeClass(tdNewCls);
	objNew.addClass('col-green');
	// objNew.children().attr('class', 'td-content');
	objNew.find('.td-content').html(' ');
	objNew.find('.td-content').append('');
	// set service id
	objNew.find('.td-content').attr('data-service-id', serviceIdNew);
	// set group
	objNew.find('.td-content').addClass(group);
	objNew.find('.td-content').attr('data-group', group);
	// set value for hidden iput
	objNew.find('.td-content').html(text);
	objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
}

function setBlue(objNew, serviceIdNew, value, text, group) {
	tdNewCls = objNew.attr('class');
	objNew.removeClass(tdNewCls);
	objNew.addClass('col-blue');
	// objNew.children().attr('class', 'td-content');
	objNew.find('.td-content').html('');
	objNew.find('.td-content').append('');
	// set service id
	objNew.find('.td-content').attr('data-service-id', serviceIdNew);
	// get group
	objNew.find('.td-content').addClass(group);
	objNew.find('.td-content').attr('data-group', group);
	// set value for hidden iput
	objNew.find('.td-content').html(text);
	objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
}

function setBrow(objNew, serviceIdNew, value, group) {
	tdNewCls = objNew.attr('class');
	if ( tdNewCls != 'col-brown' ) {
	  objNew.removeClass(tdNewCls);
	  objNew.addClass('col-brown');
	  objNew.find('.td-content').html('');
	  objNew.find('.td-content').append('../image/img-col-shift-set.png" />');
	// set service id
	objNew.find('.td-content').attr('data-service-id', serviceIdNew);
	// set group
	objNew.find('.td-content').attr('data-group', group);
	// set value for hidden iput
	objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
	}
}

function setClear(objNew, serviceIdNew) {
	tdNewCls = objNew.attr('class');
	if ( tdNewCls != 'col-brown' ) {
	  objNew.removeClass(tdNewCls);
	  objNew.addClass('col-brown');
	  objNew.find('.td-content').html('');
	  objNew.find('.td-content').append('../image/img-col-shift-set.png" />');
	  // set service id
	  objNew.find('.td-content').attr('data-service-id', serviceIdNew);
	  // set group
	  objNew.find('.td-content').attr('data-group', '');
	  objNew.find('.td-content').attr('data-booking-id', '');
	  objNew.find('.td-content > .input').val('');
	  objNew.find('.td-content > .input').attr('name', '');
	}
}

function getUrlParameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	  	sURLVariables = sPageURL.split('&'),
	  	sParameterName,
	  	i;

	for (i = 0; i < sURLVariables.length; i++) {
	  	sParameterName = sURLVariables[i].split('=');

	  	if (sParameterName[0] === sParam) {
	      	return sParameterName[1] === undefined ? true : sParameterName[1];
	  	}
	}
}
