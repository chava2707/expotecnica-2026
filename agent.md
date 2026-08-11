# Role: Full-Stack Developer Agent

## Context
You are a senior full-stack developer specialized in Laravel, Blade , and Bootstrap .
You are assisting Jean Carlos Chavarría Portugués with the development of web systems.

## Principles
- Always prefer clean, maintainable, and well-documented code.
- Follow Laravel best practices (Service Layer, Form Requests, DTOs).
- Use modern UI components (Bootstrap, dark mode preferred, rounded cards).
- Security first: validate all inputs and prevent SQL injections.

## Task Guidelines
- When debugging, analyze the full stack: Database, Controller, View/Component.
- For API integration, prioritize RESTful standards.
- Maintain code modularity to ensure easy scalability.

## Preferences
- Language: Spanish (unless technical terms are better in English).
- Tone: Professional, technical, and collaborative.
- UI Design: Minimalist SaaS style, dark mode enabled, 12px-16px border radius.

---
name: ExpoTÉCNICA 2026 Design System
colors:
  surface: '#f7f9fb'
  surface-dim: '#d8dadc'
  surface-bright: '#f7f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#eceef0'
  surface-container-high: '#e6e8ea'
  surface-container-highest: '#e0e3e5'
  on-surface: '#191c1e'
  on-surface-variant: '#564337'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#897365'
  outline-variant: '#dcc1b1'
  surface-tint: '#944a00'
  primary: '#944a00'
  on-primary: '#ffffff'
  primary-container: '#e67e22'
  on-primary-container: '#502600'
  inverse-primary: '#ffb783'
  secondary: '#4e6073'
  on-secondary: '#ffffff'
  secondary-container: '#cfe2f9'
  on-secondary-container: '#526478'
  tertiary: '#006d37'
  on-tertiary: '#ffffff'
  tertiary-container: '#29af61'
  on-tertiary-container: '#003a1a'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdcc5'
  primary-fixed-dim: '#ffb783'
  on-primary-fixed: '#301400'
  on-primary-fixed-variant: '#713700'
  secondary-fixed: '#d1e4fb'
  secondary-fixed-dim: '#b5c8df'
  on-secondary-fixed: '#091d2e'
  on-secondary-fixed-variant: '#36485b'
  tertiary-fixed: '#7efba4'
  tertiary-fixed-dim: '#61de8a'
  on-tertiary-fixed: '#00210c'
  on-tertiary-fixed-variant: '#005228'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: '1.2'
    letterSpacing: -0.02em
  display-sm:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: '1.3'
  headline-md:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: '1.4'
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: '1.5'
  label-bold:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: '1.2'
    letterSpacing: 0.05em
  data-mono:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '500'
    lineHeight: '1.0'
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: '1.2'
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 4px
  sm: 12px
  md: 16px
  lg: 24px
  xl: 40px
  gutter: 20px
  container-max: 1200px
---

## Brand & Style
The design system for ExpoTÉCNICA 2026 is built on the pillars of **Authority, Precision, and Technical Energy**. As a project management and grading platform, the UI must facilitate rapid data entry and objective assessment under high-pressure event conditions.

The aesthetic follows a **Modern Corporate** approach with a focus on high information density and functional clarity. By leveraging a neutral, deep-charcoal foundation punctuated by vibrant technical accents, the system evokes a sense of professional rigor suitable for academic and technical excellence. The interface prioritizes legibility and utility over decorative elements, ensuring that judges can navigate complex rubrics with minimal cognitive load.

## Colors
The palette is engineered for visual hierarchy and functional state signaling:

*   **Primary (Technical Energy):** Orange (#E67E22) is reserved for primary actions, active states, and critical paths. It provides a warm, energetic contrast against the professional charcoal base.
*   **Secondary (Structure):** Charcoal Grey (#2C3E50) serves as the foundation for headers, navigation, and text, establishing a sense of stability and authority.
*   **Tertiary (Achievement):** Success Green (#27AE60) is used exclusively for completed states, high-score indicators, and positive feedback loops.
*   **Neutral (Surface):** A cool Slate tint (#F8FAFC) is used for backgrounds to reduce eye strain, with secondary borders in a lighter grey (#E2E8F0) to define table structures without creating visual noise.

## Typography
**Inter** is the selected typeface for its exceptional legibility in data-heavy environments. 

*   **Systematic Scaling:** We utilize a modular scale to ensure clear hierarchy between project titles, rubric categories, and descriptions.
*   **Numerical Precision:** For grading tables and point tallies, use the `data-mono` role which enables tabular num features, ensuring digits align vertically for easy comparison.
*   **Emphasis:** Headlines use a semi-bold weight (600) to stand out against charcoal backgrounds, while labels use an uppercase bold style for secondary metadata.

## Layout & Spacing
The layout employs a **Fluid-Fixed Hybrid** model. Content is contained within a 1200px max-width wrapper on desktop but expands to fill 100% of the viewport on tablets and smaller devices.

*   **Grid:** A 12-column grid is used for the main dashboard. On tablet (vertical), components stack into 1 or 2 columns to accommodate touch targets for grading.
*   **Rhythm:** An 8px base unit governs all dimensions.
*   **Rubric Spacing:** Large vertical padding (16px–24px) is applied to rubric rows to ensure that judges using tablets can tap specific grade levels accurately without "fat-fingering" adjacent options.

## Elevation & Depth
Depth is used sparingly to maintain a "clean and flat" aesthetic while indicating interactivity.

*   **Tonal Layering:** The primary canvas uses the Neutral background. Cards and table containers use a pure white (#FFFFFF) surface to "pop" forward.
*   **Subtle Shadows:** Use a single-level ambient shadow for cards: `0px 4px 12px rgba(44, 62, 80, 0.08)`. This creates a soft lift that distinguishes project containers from the background.
*   **Interactive States:** On hover or focus, elements (like interactive rubric cells) should transition to a subtle Tonal Layer (Light Orange or Light Grey) rather than increasing shadow depth, preserving the professional, flat look.

## Shapes
A **Rounded** (Level 2) shape language is applied to soften the technical nature of the application and improve the "mobile-friendly" tactile feel.

*   **Containers & Cards:** 0.5rem (8px) for standard cards and input fields.
*   **Badges & Action Buttons:** 1rem (16px) for a "Pill" style to distinguish them from structural data containers.
*   **Selection States:** Selection indicators in rubrics use the standard 8px radius to match the overall container language.

## Components
Consistent component behavior is vital for the grading workflow:

*   **Data Tables:** Use a "zebra-stripe" alternative—instead of background colors, use `1px` horizontal dividers in `#E2E8F0`. Header cells should have a secondary charcoal background with white text.
*   **Status Badges:**
    *   *Pending:* Charcoal Grey text on a light grey background.
    *   *Completed:* White text on Success Green background.
*   **Interactive Rubric Rows:** Large, clickable blocks. When a grade is selected, the entire cell should fill with a 10% opacity version of the Primary Orange with a 2px solid Orange border.
*   **Input Fields:** Text areas for feedback must have a minimum height of 120px to encourage detailed comments. Use a 1px border that thickens and turns Orange on focus.
*   **Buttons:**
    *   *Primary:* Solid Orange background, white text.
    *   *Secondary:* Charcoal outline, charcoal text.
    *   *Action:* All buttons must have a minimum height of 48px to meet touch-accessibility standards for mobile/tablet use.