---
name: fixing-accessibility
description: >-
  Fixes and improves accessibility (a11y) in the UI. Use when addressing WCAG compliance,
  screen reader support, keyboard navigation, focus management, color contrast, or when
  the user mentions accessibility, a11y, screen reader, keyboard nav, focus, or contrast.
---

# Fixing Accessibility

## When to Apply

Activate when:

- Fixing reported accessibility issues or audit findings
- Adding or correcting labels, roles, or ARIA attributes
- Improving keyboard navigation or focus order
- Addressing color contrast or visible focus indicators
- Supporting reduced motion or other user preferences
- When the user asks for accessibility fixes or a11y improvements

## Quick Fixes

- **Form inputs**: Every input has an associated visible `<label>` or `aria-label`; use `<flux:field>` with `<flux:label>` where possible.
- **Buttons**: Use `<button>` or appropriate role; avoid clickable `<div>` without role and keyboard support. Icon-only buttons need `aria-label` or `title`.
- **Headings**: Use a single `<h1>` per view and logical order (`h1` → `h2` → `h3`); don’t skip levels.
- **Focus**: Ensure focus is visible (e.g. `focus:ring-2 focus:ring-*`); avoid `outline: none` without a replacement. After opening modals or dynamic content, move focus into them when appropriate.
- **Contrast**: Text and interactive elements meet contrast requirements; check in both light and dark mode if the app supports it.
- **Links vs buttons**: Use `<a href="...">` for navigation, `<button>` for actions that don’t change URL; don’t use `<a href="#">` for non-navigation actions.
- **Lists**: Use `<ul>`/`<ol>` and `<li>` for list content so screen readers can announce list length and position.
- **Images**: Decorative images use `alt=""` or `role="presentation"`; meaningful images have concise, descriptive `alt` text.

## Livewire / Dynamic Content

- **Livewire loading**: Ensure loading states don’t remove focus from the trigger; avoid trapping focus unless in a modal.
- **Modals**: Trap focus inside the modal while open; return focus to the trigger on close. Use `flux:modal` patterns that support this.
- **Alpine / JS**: If you add custom interactive widgets, ensure they’re keyboard operable and have correct roles/ARIA where needed.

## Testing Hints

- Tab through the page: order should be logical and nothing should be unreachable.
- Use a screen reader (e.g. NVDA, VoiceOver) on key flows to catch missing labels or confusing structure.
- Check with browser zoom and/or `prefers-reduced-motion` if relevant.

## Reference

- **DESIGN_SYSTEM.md**: Project accessibility section and existing patterns.
- **WCAG 2.x**: Level AA as a practical target for contrast, labels, and keyboard support.
