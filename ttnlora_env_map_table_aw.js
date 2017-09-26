var holder = document.getElementById('awdatatable');
var table = document.createElement("table");
holder.appendChild(table);
var tr, td, th;


tr = document.createElement("tr");
table.appendChild(tr);
var columns = ['DevUID', 'Area', 'Level', 'Type', 'Value', 'Start', 'End'];
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

for (i = 0; i < lastalarmwarnings.length; i++) 
{ 
//	if (lastalarmwarnings[i][3] != '0' && lastalarmwarnings[i][4] != '0')
	{
		var start = new Date(lastalarmwarnings[i][4]);		// UTC
		start.setSeconds(start.getSeconds() + offset*-60);	// UTC > Local

		var end = new Date(lastalarmwarnings[i][5]);		// UTC
		end.setSeconds(end.getSeconds() + offset*-60);	// UTC > Local

		hasEnded = (lastalarmwarnings[i][5] != "");

		tr = document.createElement("tr");
    		table.appendChild(tr);

		// DevUID (with link)
    		td = document.createElement("td");
    		td.innerHTML = '<a href="./ttnlora_env_chart.php?id=' + lastalarmwarnings[i][0] + '">' + lastalarmwarnings[i][0] + '</a>';
    		tr.appendChild(td);

		// Area
    		td = document.createElement("td");
    		td.innerHTML = lastalarmwarnings[i][6];
    		td.innerHTML = '<a href="./ttnlora_env_map.php?area=' + lastalarmwarnings[i][6] + '">' + lastalarmwarnings[i][6] + '</a>';
    		tr.appendChild(td);

		// Level 
    		td = document.createElement("td");
    		td.innerHTML = lastalarmwarnings[i][1];
    		tr.appendChild(td);

		// Type 
    		td = document.createElement("td");
    		td.innerHTML = lastalarmwarnings[i][2];
    		tr.appendChild(td);

		// Value // todo change type
    		td = document.createElement("td");
    		td.innerHTML = lastalarmwarnings[i][3];
    		tr.appendChild(td);

		// Start
    		td = document.createElement("td");
    		td.innerHTML = start.toLocaleDateString() + ' ' + start.toLocaleTimeString();
    		tr.appendChild(td);

		// End
    		td = document.createElement("td");
		if (hasEnded)
    			td.innerHTML = end.toLocaleDateString() + ' ' + end.toLocaleTimeString();
		else
			td.innerHTML = "---";
    		tr.appendChild(td);


		// Humidity
/*
    		td = document.createElement("td");
		if (lastalarmwarnings[i][6] > 0)
    			td.innerHTML = lastalarmwarnings[i][6] + ' %';
		else
    			td.innerHTML = '---';
    		tr.appendChild(td);
*/
	
	}
}

