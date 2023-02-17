# Tekku

## Connecting to Database
1. Copy `.env.example` as `.env`.
2. Edit `.env` with database connection details
3. ...
4. Use it to set environment variables: `export $(xargs < .env)`

### Tunneling in from Student CSCI Account
Command: `ssh -N -L 3306:dolphin.csci.viu.ca:3306 exstu@otter.csci.viu.ca`


`mysql -h marie -u csci311h/<password>`


`ssh -N -L 3306:dolphin.csci.viu.ca:3306 exstu@otter.csci.viu.ca`
