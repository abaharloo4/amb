import fs from 'fs';
import path from 'path';

const ICONS_DIR = path.resolve('resources/icons');
const OUTPUT_DIR = path.resolve('public/build');
const OUTPUT_FILE = path.join(OUTPUT_DIR, 'icons.svg');

// List of required icons from Docs/icons.md
const REQUIRED_ICONS = [
    // General
    'menu', 'x', 'search', 'plus', 'minus', 'check', 'check-circle-2', 'x-circle',
    'alert-triangle', 'info', 'help-circle', 'loader-2', 'external-link', 'copy',
    'download', 'upload', 'link', 'filter', 'arrow-up-down', 'layout-grid', 'list',
    'eye', 'eye-off', 'pencil', 'trash-2', 'save', 'more-horizontal', 'more-vertical',
    'calendar', 'clock', 'bell', 'settings', 'user', 'users', 'lock', 'unlock',
    'home', 'globe', 'sun', 'moon', 'monitor',
    // Navigation
    'arrow-right', 'arrow-left', 'arrow-up', 'arrow-down', 'arrow-up-right',
    'chevron-right', 'chevron-left', 'chevron-up', 'chevron-down',
    // Brand concepts & portfolio
    'code', 'terminal', 'layers', 'layout', 'pen-tool', 'rocket', 'gauge',
    'puzzle', 'palette', 'cpu', 'box', 'git-branch', 'mail', 'phone',
    'message-square', 'map-pin', 'file-text', 'award', 'briefcase', 'graduation-cap',
    'quote', 'star',
    // Admin
    'layout-dashboard', 'folder', 'image', 'inbox', 'list-checks', 'shield', 'activity', 'tag', 'key'
];

// Brand SVGs not in standard Lucide
const BRAND_ICONS = {
    'github': `<path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>`,
    'linkedin': `<path fill="currentColor" d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.45 1.45 0 1 0 0-2.9 1.45 1.45 0 0 0 0 2.9m1.37 9.74v-8.37H5.1v8.37h2.73z"/>`,
    'telegram': `<path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.75-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/>`,
    'instagram': `<rect width="20" height="20" x="2" y="2" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>`
};

if (!fs.existsSync(ICONS_DIR)) {
    fs.mkdirSync(ICONS_DIR, { recursive: true });
}
if (!fs.existsSync(OUTPUT_DIR)) {
    fs.mkdirSync(OUTPUT_DIR, { recursive: true });
}

let symbols = [];
const lucidePath = path.resolve('node_modules/lucide-static/icons');

REQUIRED_ICONS.forEach((name) => {
    const srcFile = path.join(lucidePath, `${name}.svg`);
    if (fs.existsSync(srcFile)) {
        let content = fs.readFileSync(srcFile, 'utf8');
        // Save to resources/icons
        fs.writeFileSync(path.join(ICONS_DIR, `${name}.svg`), content);

        // Strip outer svg tag and keep inner elements
        const inner = content
            .replace(/<svg[^>]*>/, '')
            .replace(/<\/svg>/, '')
            .trim();

        symbols.push(`  <symbol id="icon-${name}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">\n    ${inner}\n  </symbol>`);
    } else {
        console.warn(`Warning: Icon not found: ${name}`);
    }
});

// Add brand icons
for (const [name, svgContent] of Object.entries(BRAND_ICONS)) {
    fs.writeFileSync(path.join(ICONS_DIR, `${name}.svg`), `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">${svgContent}</svg>`);
    symbols.push(`  <symbol id="icon-${name}" viewBox="0 0 24 24">\n    ${svgContent}\n  </symbol>`);
}

const sprite = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none;">\n${symbols.join('\n')}\n</svg>\n`;

fs.writeFileSync(OUTPUT_FILE, sprite);
console.log(`Successfully generated SVG sprite at ${OUTPUT_FILE} with ${symbols.length} icons.`);
