var byte2Hex = function(n){
        var nybHexString = "0123456789ABCDEF";
        return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
}

/**
 * Converts an HSL color value to RGB. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
 * Assumes h, s, and l are contained in the set [0, 1] and
 * returns r, g, and b in the set [0, 255].
 *
 * @param   Number  h       The hue
 * @param   Number  s       The saturation
 * @param   Number  l       The lightness
 * @return  Array           The RGB representation
 */
function hslToRgb(h, s, l) {
  var r, g, b;

  if (s == 0) {
    r = g = b = l; // achromatic
  } else {
    function hue2rgb(p, q, t) {
      if (t < 0) t += 1;
      if (t > 1) t -= 1;
      if (t < 1/6) return p + (q - p) * 6 * t;
      if (t < 1/2) return q;
      if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
      return p;
    }

    var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
    var p = 2 * l - q;

    r = hue2rgb(p, q, h + 1/3);
    g = hue2rgb(p, q, h);
    b = hue2rgb(p, q, h - 1/3);
  }

  //console.log('r = ' + r);
  //console.log('g = ' + g);
  //console.log('b = ' + b);
  //return [ r * 255, g * 255, b * 255 ];
  return byte2Hex(r*255) + byte2Hex(g*255) + byte2Hex(b*255);
}

    var mapLat = 0.0;
    var mapLon = 0.0;

    //console.log(lastmeasurment.length);

    var locationcounter = 0;
    for (i = 0; i < lastmeasurment.length; i++) 
    { 
	if (lastmeasurment[i][3] != '0' && lastmeasurment[i][4] != '0')
	{
        	mapLat += parseFloat(lastmeasurment[i][3]);
		mapLon += parseFloat(lastmeasurment[i][4]);
		locationcounter++;
	}	
    }
	console.log(mapLat);
	console.log(mapLon);
    
	mapLat = mapLat / locationcounter;
    	mapLon = mapLon / locationcounter;

	console.log(mapLat);
	console.log(mapLon);



    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      //center: new google.maps.LatLng( 52.16114, 5.02915),
      center: new google.maps.LatLng( mapLat, mapLon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	
		
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    var flightPlanCoordinates = [];
    var bounds = new google.maps.LatLngBounds();

    var d = new Date();
    var offset = d.getTimezoneOffset();

    for (i = 0; i < lastmeasurment.length; i++) 
    {  
	if (lastmeasurment[i][3] != '0' && lastmeasurment[i][4] != '0')
	{
		var temp = Math.round(parseFloat(lastmeasurment[i][5]));
    		//console.log("temp = " + temp);
		var colortemp = (1 / 50) * (temp + 15);	
    		//console.log("colortemp = " + colortemp);
		if (colortemp > 1) colortemp = 1;
		if (colortemp < 0.15) colortemp = 0.15;
		var color = hslToRgb(1 - colortemp, 1, 0.5);//"1A88AB";
    		//console.log("color = " + color);
		//var iconurl = 'http://www.googlemapsmarkers.com/v1/' + temp + '/' + color + '/';	
		var iconurl = 'ttnlora_env_marker.php?t=' + temp + '&c=' + color;	
      		marker = new google.maps.Marker({
        		position: new google.maps.LatLng(lastmeasurment[i][3], lastmeasurment[i][4]),
			icon: iconurl,
			//label: (lastmeasurment[i][0]),
        		map: map,
      		});
		bounds.extend(marker.position);
      		flightPlanCoordinates.push(marker.position);

      		google.maps.event.addListener(marker, 'click', (function(marker, i) {
        		return function() {
          		var date = new Date(lastmeasurment[i][1]);	// UTC
			date.setSeconds(date.getSeconds() + offset*-60);	// UTC > Local
          		infowindow.setContent('<div><strong>' + 
				'DevUID : ' + lastmeasurment[i][0] + '<br/> ' +
				date.toLocaleDateString() + ' ' + date.toLocaleTimeString() + '<br/> ' +
				'RSSI : ' + lastmeasurment[i][2]+ '<br/> ' +
				' Temp : ' + lastmeasurment[i][5]+ ' C<br/> ' +
				' Humidity : ' + lastmeasurment[i][6]+ ' %<br/> ' +
				' Pressure : ' + lastmeasurment[i][7]+ ' mBar<br/> ' +
				' Voltage : ' + lastmeasurment[i][8]+ ' V<br/>' + 
			        '<a href="./ttnlora_env_chart.php?id=' + lastmeasurment[i][0] + '">chart link</a><br/>' +
				'</strong></div>');
          	infowindow.open(map, marker);
        	}
      		})(marker, i));
	}
    }

    map.setCenter(bounds.getCenter()); //or use custom center
    map.fitBounds(bounds);

    var min = -10;
    var max = 35;

    var div = document.createElement("div");
    div.style.width = "50px";
    div.style.height = "13px";
    div.style.background = "white"
    div.style.color = "black";
    div.innerHTML = "<small>Temp</small>";
    document.getElementById("colormap").appendChild(div);

    for (i = max; i>=min; i--)
    {
        temp = i;
        //console.log("temp = " + temp);
        var colortemp = (1 / 50) * (temp + 15);
        //console.log("colortemp = " + colortemp);
        if (colortemp > 1) colortemp = 1;
        if (colortemp < 0.15) colortemp = 0.15;
        var color = hslToRgb(1 - colortemp, 1, 0.5);//"1A88AB";
        //console.log("color = " + color);

        var div = document.createElement("div");
        div.style.width = "50px";
        div.style.height = "13px";
        div.style.background = '#' + color;
        div.style.color = "black";
        div.innerHTML = "<small>" + temp + "</small>";
        document.getElementById("colormap").appendChild(div);
    }

