# LoRaWAN_TTN_Env
Back and frontend for a enviromental beacon system which can be used with the TTNDHT22Beacon, LoRaWAN_TTN_Enschede_LMIC_ABP and LoRaWAN_TTN_Enschede. 

The node I use for this project is : https://github.com/ph2lb/LoRaWAN_TTN_Env_Node

TODO : add more info


Files : 

db_create_script.sql > sql script containing db layout

ttnlora_env_areas.php > php script used to create array used by the area combobox

ttnlora_env_chartdata.php > php script to get 24 hour data dataset for chart page.

ttnlora_env_chart_embedded.js > js script used to create chart on page

ttnlora_env_chart.php > php script used to create chart page with 24 hour data of specific node

ttnlora_env_last.php > php script used to create array of last measurements plotted on the map.

ttnlora_env_map_code.js > js script used to create map on page

ttnlora_env_map.php > main php file. Used to create map page with last measurements on it (click on measurement to get link to 24 
hour chart)

ttnlora_env.php > TTN HTTP handler (don't forget the apikey)

ttnlora_env_vars.js > variables used by the variouse js scripts (MUST EDIT)

ttnlora_env_vars.php > variables used by the variouse php scripts (MUST EDIT)

httpintegration_example.png > example how to configure ttn http integration

payloadfunction.txt > payload function example used by this system (modify js to reflect your payload)


Installation steps : 

1. create database with db_createscript.sql
2. edit ttnlora_env_vars.js to reflect your enviroment
3. edit ttnlora_env_vars.php to reflect your database enviroment
4. configure TTN HTTP handler (used payload function as described in https://github.com/ph2lb/LoRaWAN_TTN_Enschede_LMIC_ABP

