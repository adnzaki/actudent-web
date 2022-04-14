export default {
  'ac.v2.0033': [
    {
      key: '[Improvement] Dropdown Component',
      desc: `Dropdown search now uses asynchronous method that faster and less buggy`
    },
    {
      key: '[Improvement] Monthly summary table',
      desc: 'Monthly summary table now has been suited for mobile users'
    },
    {
      key: '[Fix] User access privilage bug (Admin or Teacher)',
      desc: 'Fixed bug unable to load schedules on student presence'
    },
    {
      key: '[Fix] Dropdown component bug',
      desc: 'Fixed missing dropdown component default selected value when entering a new page'
    }
  ],
  'ac.v2.0030': [
    {
      key: '[Fix] Fix bug unable to login in Chromium-based browser',
      desc: `Fix bug unable to login using Chromium-based browser like Chrome, Edge, etc. on build ac.v2.0029`
    },
    {
      key: '[New] Presence',
      desc: `Presence feature now able to used that comes with additional monthly and period report which have not been in the previous version of Actudent`
    },
    {
      key: '[New] Login Page',
      desc: `Login page now uses new interface dan has been integrated with PWA mode like the app's core`
    },
    {
      key: '[Improvement] Pagination',
      desc: `Data rows numbering on pagination has currently been matched with
             with whole data`
    },
    {
      key: '[Improvement] Internationalization (Language)',
      desc: `Improved language loading mechanism - now is fully running on client side to improve
             app performance`
    },
    {
      key: '[Improvement] Sub-page back button',
      desc: `Sub-page back button now becomes more simple and uses less space`
    },
    {
      key: '[Fix] Authentication',
      desc: `Fixed token validation and redirect mechanism of pages that are not allowed to be accessed`
    },
    {
      key: '[Fix] Student class selector',
      desc: `Fixed bug class selector cannot update the student table`
    },
    {
      key: '[Fix] Multiple delete button',
      desc: `Fixed bug multiple delete button not working`
    }
  ],
  'ac.v2.0027': [
    {
      key: '[New] Lesson Schedule',
      desc: `Lesson schedule management has been added`
    },
    {
      key: '[New] Sync API',
      desc: `Actudent now has been completed with Sync API to import data from 
            Dapodik`
    },
    {
      key: 'Pagination',
      desc: `SSPaging now loads latest selected page for initial load`
    },
    {
      key: 'Parent data display fixes',
      desc: `Default display of number of rows per page in SSPaging now is 25 rows
             per page`
    },
    {
      key: 'Fix add new class form',
      desc: `Search teacher dropdown now uses new simple component`
    },
    {
      key: 'Fix teacher search',
      desc: `Fix teacher list dropdown that still shows other employee (staff)`
    },
    {
      key: 'Form size change',
      desc: `Modal form has no loger use full screen size on mobile device`
    }
  ],
  'ac.v2.0024': [
    {
      key: 'Service Status',
      desc: `Fixed multi-line text display that unable to read on service status warning`
    },
    {
      key: 'Lesson',
      desc: `Added Lesson feature for managing lessons available at school`
    },
    {
      key: 'Pagination Fixes',
      desc: `Fixed bug current page does not updated after deleting data`
    },
    {
      key: 'Home',
      desc: `Added older update history information`
    },
    {
      key: 'Update Information',
      desc: `Update information now available in Indonesian and English`
    },
  ],
  'ac.v2.0023': [
    {
      key: 'Room Menu',
      desc: `In this latest build we have added room menu for managing room data`
    },
    {
      key: 'Room addition algorithm fixes',
      desc: `In Actudent-v2, users able to add new room using room code from rooms
             that previously deleted`
    },
    {
      key: 'Pagination fixes',
      desc: `Fixed pagination bug that unable to display data range when user reloading full page`
    },
    {
      key: 'System updates',
      desc: `Updated CodeIgniter framework to version 4.1.4`
    },
    {
      key: 'App fixes and improvements',
      desc: `Actudent-v2 code base fixes to improve app performance and fixed 
             some small mistakes on system`
    }
  ]
}