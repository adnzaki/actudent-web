/**
 * Global Configuration is like a magic file that changes everything in Actudent
 * Incorrect setting in this configuration will cause Actudent does not run as expected
 * globalConfig is a JS file that will never be compiled by Quasar framework, it acts
 * as a bridge for core Actudent app and its user interface.
 * Please read the instruction in order to set up this configuration correctly.
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech DevTeam (c) 2021
 * @since       March 2021
 * @package     Configuration
 */

// There are 3 modes available to run Actudent:
// -----------------------------------------------------------------------------------
// "development" mode means you are in truly development environment,
// you are using a dev server from node.js, non-minified UI files, etc.
// -----------------------------------------------------------------------------------
// "build" mode means you are using minified/build version of UI files. It still runs
// on your local web server, but it can be called as "production mode on local server"
// -----------------------------------------------------------------------------------
// "production" mode means you have deployed Actudent in cloud hosting or
// production server, etc. It will use different URL from your local development
// and of course using HTTPS.
const mode = 'production' // development, build, production

// ------ WARNING! Do not touch below this line ------
// const baseUrl = () => {
//     return (mode === 'production')
//             ? `https://${window.location.hostname}/public/`
//             : `http://${window.location.hostname}/actudent/public/`
// }

// Base URL for production server
const baseUrl = `https://${window.location.hostname}/public/`

// Base URL for local server
// const baseUrl = `http://${window.location.hostname}/actudent/public/`

export { mode, baseUrl }