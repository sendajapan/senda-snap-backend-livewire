---
name: baseline-ui
description: >-
  Establishes and applies baseline UI patterns for consistent, minimal, and robust interfaces.
  Use when starting a new screen or component, standardizing defaults, defining base styles,
  or when the user mentions baseline UI, default styles, UI foundations, or consistent starting point.
---

# Baseline UI

## When to Apply

Activate when:

- Starting a new page, modal, or component from scratch
- Standardizing default styles or component foundations
- Defining base typography, spacing, or color usage
- Aligning new UI with existing patterns (headers, cards, tables)
- When the user asks for a baseline, default, or minimal starting UI

## Principles

- **Start from project defaults**: Use DESIGN_SYSTEM.md and standard Tailwind spacing/typography (`p-4`, `gap-3`, `text-base`, `text-lg`) plus the module variant (e.g. cyan for Shipment Schedule) so new UI matches the rest of the app.
- **One root container**: Use a single root wrapper (e.g. `div` with `flex flex-col gap-4`) for the component or page section; apply layout and gap there.
- **Reuse existing components**: Prefer `x-page-header`, `x-table-card`, Flux components, and existing Blade components over custom markup when they fit.
- **Minimal first**: Add only what’s needed for the first version—no extra decoration or optional states until required.
- **Consistent structure**: Match the order used elsewhere (e.g. header with actions → filters → content area → pagination).

## Baseline Page Structure

- **Page**: Page header (title, description, primary action) + main content (table card or list).
- **Modal**: Heading, body (form or content), footer with primary/secondary actions.
- **Table row**: Same column order and alignment as sibling pages; use semantic text classes for cells.

## Cross-Check

- Does this use the same layout pattern as similar pages (e.g. Users, Ports)?
- Are design system tokens used instead of arbitrary values where possible?
- Is the correct module variant (color) applied for this feature?
