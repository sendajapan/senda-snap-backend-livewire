# Privacy Policy Page Generation Prompt

## Task
Create a professional, comprehensive Privacy Policy and Terms of Service web page based on the provided JSON data file (`privacy_policy_data.json`).

## Requirements

### 1. Page Structure
- Create a single HTML page that includes both Privacy Policy and Terms of Service
- Use semantic HTML5 elements for proper structure
- Include a navigation menu/table of contents at the top with anchor links to all major sections
- Add a header with the app name "SendaSnap" and a professional logo placeholder
- Include a footer with contact information and last updated date

### 2. Content Organization
- Display all sections from the JSON file in a clear, hierarchical structure
- Use appropriate heading levels (h1, h2, h3) for proper document outline
- Include section numbers or clear visual hierarchy
- Make the content scannable with bullet points, numbered lists, and clear paragraphs

### 3. Styling and Design
- Create a modern, professional design that is:
  - Clean and minimalist
  - Easy to read with proper spacing
  - Mobile-responsive (works on phones, tablets, and desktops)
  - Accessible (WCAG 2.1 AA compliant)
- Use a color scheme that is professional (suggest: dark text on light background, or use the app's brand colors if available)
- Ensure proper typography with:
  - Clear font hierarchy
  - Readable font sizes (minimum 16px for body text)
  - Adequate line spacing
  - Proper contrast ratios

### 4. Features to Include
- **Table of Contents**: Clickable links that jump to each section
- **Print-Friendly**: CSS that optimizes the page for printing
- **Last Updated Date**: Prominently display the date from the JSON
- **Contact Information**: Easy-to-find contact details
- **Smooth Scrolling**: When clicking anchor links, use smooth scroll behavior
- **Back to Top Button**: A floating button to return to the top of the page

### 5. Technical Requirements
- Use modern CSS (CSS3) with Flexbox or Grid for layout
- Make it responsive using media queries
- Ensure cross-browser compatibility (Chrome, Firefox, Safari, Edge)
- Use semantic HTML for SEO and accessibility
- Include proper meta tags for SEO
- Add Open Graph tags for social media sharing

### 6. Content Formatting
- Format all lists (bullet points, numbered lists) from the JSON properly
- Use proper emphasis (bold, italic) where appropriate
- Include proper spacing between sections
- Use visual separators (dividers, borders) between major sections
- Highlight important information (contact details, last updated date)

### 7. Accessibility Features
- Proper ARIA labels where needed
- Keyboard navigation support
- Screen reader friendly structure
- High contrast mode support
- Focus indicators for interactive elements

### 8. Additional Elements
- Add a "Download PDF" button (you can create a print-to-PDF version)
- Include breadcrumbs navigation
- Add social sharing buttons (optional)
- Include a language selector if needed (for future internationalization)

## Output Format
Provide:
1. **HTML file** (`privacy-policy.html`) - Complete standalone HTML page with embedded CSS
2. **Separate CSS file** (optional, `privacy-policy.css`) - If you prefer external stylesheet
3. **Brief documentation** - Explain the structure and any design decisions

## Design Inspiration
- Look at privacy policies from major tech companies (Google, Apple, Microsoft) for professional layout inspiration
- Use a clean, legal document style that's easy to read
- Consider using a sidebar navigation for desktop view
- Use collapsible sections for mobile view to save space

## Important Notes
- The JSON file contains all the content needed - extract and format it properly
- Ensure all contact information placeholders (like "[Your Company Address]") are clearly marked for the user to fill in
- Make sure the page loads quickly and is optimized
- Test the page on multiple screen sizes
- Ensure all links work correctly
- The page should be self-contained and easy to host on any web server

## Example Structure
```
┌─────────────────────────────────┐
│        Header (Logo + Title)     │
├─────────────────────────────────┤
│    Table of Contents (Nav)      │
├─────────────────────────────────┤
│                                 │
│    Privacy Policy Section       │
│    - Introduction               │
│    - Information Collection     │
│    - How We Use Information     │
│    - Data Storage               │
│    - User Rights                │
│    - etc.                       │
│                                 │
├─────────────────────────────────┤
│                                 │
│    Terms of Service Section     │
│    - Acceptance of Terms        │
│    - User Accounts              │
│    - Acceptable Use             │
│    - etc.                       │
│                                 │
├─────────────────────────────────┤
│        Footer (Contact Info)    │
└─────────────────────────────────┘
```

## Deliverables
1. Complete HTML file with all content from JSON
2. CSS file (embedded or separate)
3. Brief README explaining how to use and customize the page

---

**Instructions for AI Client:**
Please read the `privacy_policy_data.json` file carefully and create a professional, comprehensive privacy policy and terms of service web page following all the requirements above. The page should be production-ready and suitable for hosting on a website or including in a mobile app's web view.

