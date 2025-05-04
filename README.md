# FiveM server player table
<p>PHP website to show an HTML table of online players on your server.</p>
<p>It uses both the FiveM fronted API to display the num of players online and the maximum slots of the server, and the server's players.json file to display every user. If you disabled the players.json feature for privacy reasons it won't work. It you limited the information shown on the players.json file it will only shows the ones available to the public.</p>

# Installation
<ol>
  <li>Clone the repository to your local machine and unzip the files</li>
  <li>Copy the files to your web server or to your local web server (Make sure you have PHP installed on your system)</li>
  <li>Fill out the the IP address and FiveM CFX code line with your server's informations.</li>
</ol>

# In case of an error
<ol>
  <li>Check the information you set as the IP&port and as the FiveM CFX code to your server. Make sure there are no unnecessary characters or a typo.</li>
  <li>If it shows the num of online players and all slot but not the players table, check the IP address and port you set. If it still does not work, most likely you disabled the players.json file to be viewable by the public. Paste the following line in the server.cfg file: "sv_endpointprivacy false" or set it from "true" to "false"!</li>
  <b>Warning! This will make players.json, dynamic.json and info.json file readable by the public.</b>
  <li>You can limit this by setting up a reverse proxy to make the file only available to your own webserver.</li>
</ol>
<b>Example code for Ngix</b>

```
server {
  listen 80;
  server_name your-webserver-name;
  
  location /fivem-players {
    proxy_pass http://your-fivem-ip:port/players.json;
    allow your-webserver-ip;
    deny all;
  }
}

