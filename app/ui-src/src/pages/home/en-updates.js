export default {
  'beta-6.ac.v2.0054': [
    {
      key: '[Improvement]',
      desc: 'Updated background system of application user interface'
    },
    {
      key: '[Update]',
      desc: 'Updated period for 2023/2024 of school year'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed some bugs on Agenda, Parent and Student feature'
    },
  ],
  'beta-5.ac.v2.0051': [
    {
      key: '[New]',
      desc: 'Added "All students" display option on student list menu'
    },
    {
      key: '[New]',
      desc: 'App interface design base update'
    },
    {
      key: '[Improvements]',
      desc: 'Added homeroom teacher\'s name to the mobile version class list'
    },
    {
      key: '[Fix]',
      desc: 'Bug: class filter on student menu that doesn\'t match the data displayed after saving student data'
    },
    {
      key: '[Fix]',
      desc: 'Bug: student report menu cannot be accessed'
    },
    {
      key: '[Fix]',
      desc: 'Bug: Unable to change homeroom'
    },
  ],
  'beta-4.ac.v2.0050': [
    {
      key: '[New]',
      desc: 'Added invitation feature to Agenda'
    },
    {
      key: '[Improvement]',
      desc: 'Prevent access to login page for already logged in users'
    },
    {
      key: '[Improvement]',
      desc: 'Customizing the Agenda view for mobile devices'
    },
    {
      key: '[Improvement]',
      desc: 'Customize the appearance of the form for mobile devices'
    },
    {
      key: '[Fixes]',
      desc: 'Synchronization of language system between client-server'
    },
    {
      key: '[Fixes]',
      desc: 'Error displaying printable PDF of semester recap if data is not available'
    },
    {
      key: '[Fixes]',
      desc: 'Menu text that failed to load when user make a full reload'
    },
  ],
  'beta-3.ac.v2.0045': [
    {
      key: '[New]',
      desc: 'Login using NIK'
    },
    {
      key: '[New]',
      desc: 'App settings menu'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed the bug cannot load English on server side'
    },
    {
      key: '[Improvement]',
      desc: 'Added schedule details to the Schedule Attendance (Teacher) menu on the mobile display'
    },
    {
      key: '[Fixes]',
      desc: ' Fixed app drawer appearing by default on some smartphone screens'
    },
    {
      key: '[Fixes]',
      desc: 'Removed characters that are not allowed to input parent/employee username'
    },
    {
      key: '[Fixes]',
      desc: 'Prevent login access for parent account during login validation'
    },
  ],
  'beta-2.ac.v2.0044': [
    {
      key: '[Fixes]',
      desc: 'Fixed wrong journal icon on mobile display'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed an error message that still appears after saving data successfully on some forms'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed a color error and the background of the day name text in the event calendar when dark mode is active'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed error displaying date on some datepicker components (datepicker)'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed missing back button on student attendance recap page in admin panel'
    },
    {
      key: '[Internal-Improvement]',
      desc: 'Dynamically load year for month and period selector'
    },
    {
      key: '[Improvement]',
      desc: 'Fixed display of month and year selector for student attendance recap on tablet screen'
    },
    {
      key: '[Improvement]',
      desc: 'Adjusted the size of the attendance recap "Show" button with the month selector'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed the Delete agenda button still appearing on the Add Agenda Form'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed the pagination row count returning to default after saving data'
    },
    {
      key: '[Fixes]',
      desc: 'Fixed the bug that teachers couldn\'t access the agenda menu in other versions of Actudent (extensions)'
    },
    {
      key: '[Improvement]',
      desc: 'Fixed the notification of the process of saving data missing before the process ends'
    },
  ],
  'beta-1.ac.v2.0043': [
    {
      key: '[New] Agenda',
      desc: 'Added agenda feature'
    },
    {
      key: '[Improvement] Login page',
      desc: 'Match UI styling of login page on mobile and tablet devices'
    }
  ],
  'alpha-2.ac.v2.0040': [
    {
      key: '[New] Dedicated report menu for homeroom teacher',
      desc: 'Print report feature now has dedicated menu for teacher who set as homeroom teacher'
    },
    {
      key: '[Fix] Admin daily report menu',
      desc: 'Return missing daily report menu for admin'
    }
  ],
  'alpha-1.ac.v2.0038': [
    {
      key: '[New] Schedule and Presence for teacher',
      desc: 'Added teacher access along with student presence and teaching schedules'
    },
    {
      key: '[Fix] Bug on PDF print/download',
      desc: 'Fixed a bug when printing or downloading PDF report'
    },
    {
      key: '[Fix] Bug on dropdown component',
      desc: 'Fixed bug failed to load dropdown default option on edit form'
    }
  ],
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
}