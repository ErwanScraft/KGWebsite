# KGSMP Website

Static Minecraft server landing page built with modular HTML, CSS, and JavaScript.

## Structure

```text
.
├── index.html
├── assets/
│   ├── css/
│   │   ├── base.css
│   │   ├── components.css
│   │   └── sections.css
│   └── js/
│       ├── main.js
│       └── modules/
│           ├── clipboard.js
│           ├── faq.js
│           ├── navigation.js
│           └── server.js
└── README.md
```

## Deployment

No build step is required. Upload the project directly to Apache/Nginx/static hosting.

## Server status

`assets/js/modules/server.js` currently contains static demo data. Replace `DEFAULT_STATUS` with a fetch to the future KGSMP server/API endpoint when the backend is available.

## Design

The visual direction is an original dark, cinematic Minecraft gaming aesthetic inspired by the supplied Shadow landing-page reference. It is not a copy of Shadow's branding or assets.
