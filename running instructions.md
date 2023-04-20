CoRA exists  in essence as 2 things, server side (defaults to running on localhost:7000) and 'client' side (defaults to running on localhost:8080).
Note that


Running server side requires:
`cd [location of server folder]`
`docker-compose up`

Running client side, because it was build 5 years ago, requires you to install and select npm 10
`nvm install`
`nvm use 10`
This can be checked by the
`nvm current`
command. which shoudl result in
`v10.24.1`

Once done correctly, one can run the client side through
`cd [location of client side folder]`
`npm run start`
Note that the code for this client side is the cmod folder, so cd to that
