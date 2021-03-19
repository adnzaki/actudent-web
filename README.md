# Actudent v2.0 Development
<i>A brand new version of Actudent, comes with Progressive Web Apps, one-for-all API, mobile-first UI,  etc. </i>

## Description
This branch contains source code of Actudent v2.0. If you want to contribute to this project, please read the contribution guide first in this repository.

## How-to-run
<i>Before running Actudent on development, make sure that [NPM](https://www.npmjs.com/get-npm) has been installed on your machine.</i>
- Install dependencies first:
```
cd public/ui

npm install
```
Run on development server with hot-reload and live lint:
```
quasar dev -m pwa
```
- The app wil run on localhost:8080
- To build user interface for production:
```
quasar build -m pwa
```
- Above command assumes you are using internal terminal like VSCode
- Run production UI from CodeIgniter4 by open up http://localhost/actudent-v2/public/ui/dist/pwa/build
