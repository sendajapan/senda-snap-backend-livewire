---
name: fixing-motion-performance
description: >-
  Fixes animation and motion performance and respects user motion preferences. Use when
  addressing jank, 60fps animations, prefers-reduced-motion, or when the user mentions
  motion performance, animation lag, reduced motion, or smooth transitions.
---

# Fixing Motion & Performance

## When to Apply

Activate when:

- Fixing janky or laggy animations or transitions
- Implementing or adjusting `prefers-reduced-motion` support
- Optimizing CSS or JS that affects scroll, resize, or transition performance
- When the user mentions motion performance, animation performance, reduced motion, or smooth transitions

## Performance

- **Prefer CSS over JS for animation**: Use `transition-*` and `@keyframes` for show/hide and simple motion; avoid animating layout-heavy properties (e.g. `height`, `width`) when `transform` or `opacity` can achieve the effect.
- **Contain layout/paint where possible**: Use `contain: layout` or `contain: paint` on animated containers when it’s safe to reduce scope of layout/paint.
- **Avoid animating expensive properties**: Prefer `transform` and `opacity`; be cautious with `box-shadow`, `filter`, and properties that trigger layout (e.g. `top`/`left` instead of `transform`).
- **Debounce or throttle**: Resize/scroll handlers and frequent updates should be debounced or throttled so they don’t run every frame.
- **Livewire**: Keep DOM updates minimal; use `wire:key` on list items so only changed nodes update. Avoid large full-page re-renders for small state changes when possible.

## Reduced Motion

- **Respect `prefers-reduced-motion`**: When the user has “reduce motion” enabled, shorten or remove non-essential motion.
- **CSS**: Use `@media (prefers-reduced-motion: reduce)` to disable or shorten transitions and animations for users who prefer reduced motion.
- **Example**:
  - Normal: `transition duration-200`
  - Reduced: `@media (prefers-reduced-motion: reduce) { * { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }` (project-wide) or scope to specific components and tone down only decorative motion.
- **Alpine / JS**: For JS-driven animations, check `window.matchMedia('(prefers-reduced-motion: reduce)').matches` and skip or shorten animations when true.
- **Flux / Livewire**: If the stack uses transitions (e.g. modal open/close), ensure reduced-motion is considered in the theme or override transition duration when preferred.

## Project Context

- This app uses Tailwind and Flux; transitions often use classes like `transition duration-200` or `x-collapse`. Prefer existing transition utilities and add reduced-motion overrides in `resources/css/app.css` or component-level styles if needed.
- **DESIGN_SYSTEM.md** may define motion or animation guidelines; align with those when present.

## Checklist

- [ ] Animations/transitions feel smooth (no obvious jank).
- [ ] No unnecessary layout thrashing (e.g. read-then-write in a loop).
- [ ] Reduced-motion preference shortens or removes non-essential motion.
- [ ] Heavy handlers (resize, scroll) are debounced/throttled.
