# Investment Knowledge Club — Frontend Assessment

Mobile-first UI for the investment knowledge club (Fourfront Management). Built with **HTML**, **CSS**, **JavaScript**, and **Bootstrap 5**.

## Features

- **Layout**: Header with profile and welcome text, 2×2 account/wallet cards, recommendation section, toggleable membership sections, CTA link, footer with WhatsApp.
- **Responsive**: Mobile-first; works on phone, tablet, and desktop. Bootstrap grid and breakpoints used throughout.
- **Interactivity**:
  - **Menu toggle**: Navbar collapses to a hamburger menu on small screens (Bootstrap navbar).
  - **Membership toggles**: Click “FOUNDATION MEMBERSHIP” or “ECONOMY MEMBERSHIP” to show/hide their descriptions.
  - **Modal**: “Contact” in the menu opens a contact modal.
  - **Validation**: Contact form checks required fields and email format before submit.

## How to run

Open `index.html` in a browser (double-click or use “Open with” your browser). No build step required; Bootstrap and Bootstrap Icons are loaded from CDN.

For local development with a simple server (optional):

```bash
# From project root (e.g. fourfront-assesment)
cd frontend
npx serve .
# Or: php -S 8080 (then open http://localhost:8080)
```

## Structure

```
frontend/
├── index.html      # Single page markup
├── css/
│   └── style.css   # Custom styles (cards, header, membership, footer)
├── js/
│   └── app.js      # Toggle icons, form validation, CTA link
└── README.md
```

## Tech stack

- HTML5
- CSS3 (custom + Bootstrap 5)
- JavaScript (vanilla)
- Bootstrap 5.3.2 (grid, components, collapse, modal, navbar)
- Bootstrap Icons 1.11
