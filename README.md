
# Tekku

## Git/Gitlab
### Workflow
Please ensure that all changes are done on forks, and that any changes to the upstream repo are made through merge requests. This ensures that new code is reviewed by others, and that we don't accidentally destroy each other's work (git is hard to get right!).

Here is what it should look like when you make changes:
1. Send a message in the group chat saying what you are going to start working on!
2. Make sure you are currently up to date with the upstream repository: `git pull upstream main --rebase`
3. Optionally, for even better code management (especially when working on multiple features at the same time), start your work from a new branch: `git checkout -b my-feature`
    - Change back and forth with `git checkout main` and `git checkout my-feature`
4. Write code
5. Make a commit with a detailed message: `git add <files to commit> && git commit -m "detailed message"`
6. Make sure you're up to date again: `git pull upstream main --rebase`
7. Go to your fork on the Gitlab webpage, create a merge request for your branch into upstream main, write a detailed message for it, and publish the merge request.
8. Let another team member know about your merge request, then make any changes as necessary.
    - Any new commits pushed to the same branch will automatically be put into the merge request while it's open.
    - To change the last commit (if a small mistake was made and an entirely new commit isn't necessary), make your changes, stage them, then run `git amend --no-edit` to add your changes to the previous commit. You'll also have to do a force push after this with `git push origin <branch> -f`, so make sure you know exactly what you're doing!

- If you run into issues at any point, check out this choose your own adventure for resolving issues with git: [sethrobertson.github.io - On undoing, fixing, or removing commits in git](https://sethrobertson.github.io/GitFixUm/fixup.html).
- [Youtube - Resolving merge conflicts](https://www.youtube.com/watch?v=QmKdodJU-js).

### Accessing from Off-Campus
Using SSH tunnels into your CSCI account, you can access the Gitlab repos and webpage from anywhere. I'm doing this so that I can have my own setup away from the CSCI computers, since they cause me constant issues, such as with my quota. Here's how I do it.

#### Gitlab Webpage
1. `ssh -N -L 127.0.0.1:8080:gitlab.csci.viu.ca:80 exstu@pup10.csci.viu.ca -J exstu@csci.viu.ca`
2. Access `127.0.0.1:8080` in your web browser.

#### Gitlab Repository Access
1. Put your Gitlab SSH key in your `~/.ssh` directory in your personal machine.
2. Add your ssh key to your ssh agent e.g. `eval $(ssh-agent) && ssh-add ~/.ssh/gitlab-ed25519`
3. Setup tunnel with proxyjump to pup server: `ssh -N -L 127.0.0.1:22:gitlab.csci.viu.ca:22 exstu@pup10.csci.viu.ca -J exstu@csci.viu.ca`

Now you can do normal git commands, but you have to use `127.0.0.1` to access them. For example, cloning a repo:
-  `git clone git@127.0.0.1:<username>/tekku.git`
- Add remote to upstream: `git remote add git@127.0.0.1:oleander/tekku.git`

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
2. Now it should be accessible through localhost, since 127.0.0.1 is the IPv4 localhost address. This means that you can access it as if the database is running on your own computer.

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


