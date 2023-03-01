
# Tekku

## View Dolphin Webpages from Off Campus
### User Account
1. Start SSH tunnel to your CSCI account: `$ ssh -N -L 8080:wwwstu.csci.viu.ca:80 exstu@pup10.csci.viu.ca -J exstu@csci.viu.ca
2. In browser, go to http://localhost:8080/~exstu/csci311/tekku/
### Shared Account
??

## Connecting PHP Backend to Database
1. Copy `.env.example` as `.env`.
2. Edit `.env` with database connection details
3. If necessary, start SSH tunnel to database.
4. Test the server by visiting one of its pages.

### Connecting to Shared Account on CSCI Server
1. Connect to a school server e.g. pup10: `ssh -J exstu@otter.csci.viu.ca exstu@pup10.csci.viu.ca`
2. Connect to shared account with pup10 as proxy: `ssh -J csci311h@dolphin.csci.viu.ca pup10`

Now that you're connected, you should be able to access the database with the following command:
`mysql -h marie -u csci311h -p`

### Creating Off-Campus Tunnel to MySQL Database from Student CSCI Account
1. `ssh -N -L 127.0.0.1:3306:dolphin.csci.viu.ca:3306 csci311h@otter.csci.viu.ca`

### Using Docker
1. Start containers: `docker-compose up --build -d`
2. Start an SSH tunnel to the MySQL server: `docker-compose exec tekku_php_apache ssh -N -L 127.0.0.1:3306:marie.csci.viu.ca:3306 csci311h@csci.viu.ca`
3. Visit a webpage. Type `localhost` into your browser.

- Bring down the containers: `docker-compose down`


### Access PHP Server Logs
```
For an example CSCI student with the username "exstu":
$ ssh exstu@wwwstu.csci.viu.ca
- if prompted to continue connecting, type 'yes' and press enter
- Note: you will not get a bash prompt on the web server. 
Instead a custom script is run remotely the gathers all the relevant log entries and presents them in the output.
 
The output will look similar to the following
------------------------------------------------------------
Linux dolphin 4.9.0-16-amd64 #1 SMP Debian 4.9.272-2 (2021-07-19) x86_64
 
The programs included with the Debian GNU/Linux system are free software;
the exact distribution terms for each program are described in the
individual files in /usr/share/doc/*/copyright.
 
Debian GNU/Linux comes with ABSOLUTELY NO WARRANTY, to the extent
permitted by applicable law.
Last login: Thu Jan 20 12:45:25 2022 from 192.168.18.156
 
********************
**** access.log ****
********************
 
********************
**** error.log  ****
********************
 
********************
**** suexec.log ****
********************
 
********************
**** suphp.log  ****
********************
Connection to wwwstu.csci.viu.ca closed.
------------------------------------------------------------
 
If there are any log entries related to accessing any files in the "public_html" folder for the student those entries
will be included in the output under the appropriate header. 
In the above the example student has no recent log entries so each log file section is empty.
```


