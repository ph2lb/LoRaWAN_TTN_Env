# LoRaWAN_TTN_Env
Back and frontend for a enviromental beacon system which can be used with the TTNDHT22Beacon, LoRaWAN_TTN_Enschede_LMIC_ABP and LoRaWAN_TTN_Enschede. 

The node I use for this project is : https://github.com/ph2lb/LoRaWAN_TTN_Env_Node

TODO : add more info


Files : 

db_create_script.sql > sql script containing db layout

db_demodata_script.sql > sql script to add basic demo data

httpintegration_example.png > example how to configure ttn http integration

payloadfunction.txt > payload function example used by this system (modify js to reflect your payload)

ttnlora_env.php > TTN HTTP handler (don't forget the apikey)

ttnlora_env_alarmwarning.php > php script to create alarms and warnings.

ttnlora_env_areas.php > php script used to create array used by the area combobox

ttnlora_env_chart.php > php script used to create chart page with 24 hour data of specific node

ttnlora_env_chart_embedded.js > js script used to create chart on page

ttnlora_env_chartdata.php > php script to get 24 hour data dataset for chart page. but can be used to get clean data for a deviceid and for a periode (add ?id=<you're deviceid>&from=YYYY-MM-DD%20HH:mm:ss&to=YYYY-MM-DD%20HH:mm:ss)

ttnlora_env_chartdata.php > php script to get 24 hour raw data dataset. but can be used to get raw data for a deviceid and for a periode (add ?id=<you're deviceid>&from=YYYY-MM-DD%20HH:mm:ss&to=YYYY-MM-DD%20HH:mm:ss)

ttnlora_env_last.php > php script used to create array of last measurements plotted on the map.

ttnlora_env_last_aw.php > php script used to create array of last alarms warnings used on the map and chart

ttnlora_env_mailer.php > php script to send emails when a alarm or warning is triggerd.

ttnlora_env_map.php > main php file. Used to create map page with last measurements on it (click on measurement to get link to 24 
hour chart)

ttnlora_env_map_code.js > js script used to create map on page

ttnlora_env_map_table.js > js script used to last measurement table on page

ttnlora_env_map_table_aw.js > js script used to last alarm warning table on page

ttnlora_env_telegram.php > php script used to send bot messages when a alarm or warning is triggerd.

ttnlora_env_vars.js > variables used by the variouse js scripts (MUST EDIT)

ttnlora_env_vars.php > variables used by the variouse php scripts (MUST EDIT)



Installation steps : 

1. create database with db_createscript.sql
2. add demo data with db_demodata_script.sql
3. edit ttnlora_env_vars.js to reflect your enviroment
4. edit ttnlora_env_vars.php to reflect your database enviroment and other settings
5. configure TTN HTTP handler (used payload function as described in https://github.com/ph2lb/LoRaWAN_TTN_Env_Node
6. when needed setup telegram bot system
