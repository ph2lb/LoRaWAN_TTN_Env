var holder = document.getElementById('datatable');
var table = document.createElement("table");
holder.appendChild(table);
var tr, td, th;


tr = document.createElement("tr");
table.appendChild(tr);
var columns = ['DevUID', 'Area', 'Date', 'Temp', 'Humidity', 'Pressure', 'Voltage', 'RSSI', 'Description'];
for(j=0; j<columns.length; j++)
{
	th = document.createElement('th');
       	th.innerHTML = columns[j];
       	tr.appendChild(th);	
}

var span = 3600*1000;
var nowInMs = Date.now();
var d = new Date();
var offset = d.getTimezoneOffset();

for (i = 0; i < lastmeasurment.length; i++) 
{ 
	if (lastmeasurment[i][3] != '0' && lastmeasurment[i][4] != '0')
	{
		tr = document.createElement("tr");
    		table.appendChild(tr);
		var date = new Date(lastmeasurment[i][1]);		// UTC
		date.setSeconds(date.getSeconds() + offset*-60);	// UTC > Local
		var dateInMs = date.getTime();			
		console.log("nowInMs - dateInMs : " + nowInMs + " - " + dateInMs + " = " + (nowInMs - dateInMs));

		// DevUID (with link)
    		td = document.createElement("td");
    		td.innerHTML = '<a href="./ttnlora_env_chart.php?id=' + lastmeasurment[i][0] + '">' + lastmeasurment[i][0] + '</a>';
    		tr.appendChild(td);

		// Area
    		td = document.createElement("td");
    		td.innerHTML = lastmeasurment[i][9];
    		td.innerHTML = '<a href="./ttnlora_env_map.php?area=' + lastmeasurment[i][9] + '">' + lastmeasurment[i][9] + '</a>';
    		tr.appendChild(td);

		// Date
    		td = document.createElement("td");
		if ((nowInMs - dateInMs) > span)
    			td.innerHTML = '<font color="red">' + date.toLocaleDateString() + ' ' + date.toLocaleTimeString() + ' </font>';
		else
    			td.innerHTML = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    		tr.appendChild(td);

		// Temp
    		td = document.createElement("td");
    		td.innerHTML = lastmeasurment[i][5] + ' C';
    		tr.appendChild(td);

		// Humidity
    		td = document.createElement("td");
		if (lastmeasurment[i][6] > 0)
    			td.innerHTML = lastmeasurment[i][6] + ' %';
		else
    			td.innerHTML = '---';
    		tr.appendChild(td);

		// Pressure
    		td = document.createElement("td");
		if (lastmeasurment[i][7] > 0)
    			td.innerHTML = lastmeasurment[i][7] + ' mBar';
		else
    			td.innerHTML = '---';
    		tr.appendChild(td);

		// Voltage
    		td = document.createElement("td");
		if (lastmeasurment[i][8] > 0)
    			td.innerHTML = lastmeasurment[i][8] + ' V';
		else
    			td.innerHTML = '---';
    		tr.appendChild(td);

		// RSSI
    		td = document.createElement("td");
    		td.innerHTML = lastmeasurment[i][2];
    		tr.appendChild(td);
	
		// Description
    		td = document.createElement("td");
    		td.innerHTML = lastmeasurment[i][10];
    		tr.appendChild(td);
	
	}
}

