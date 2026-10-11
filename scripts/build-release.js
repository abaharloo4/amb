import fs from 'fs';
import path from 'path';
import { execSync } from 'child_process';
import { createRequire } from 'module';

const require = createRequire(import.meta.url);
const archiver = require('archiver');

const distDir = path.resolve('dist');
const releaseZip = path.resolve('release.zip');

console.log('--- 🚀 Starting Release Build for cPanel Hosting ---');

// 1. Build frontend assets
console.log('1. Building frontend production assets...');
execSync('npm run build', { stdio: 'inherit' });

// 2. Prepare clean distribution package
console.log('2. Creating standalone release archive...');
if (fs.existsSync(releaseZip)) {
    fs.unlinkSync(releaseZip);
}

const output = fs.createWriteStream(releaseZip);
const archive = archiver('zip', {
    zlib: { level: 9 } // Maximum compression
});

output.on('close', function () {
    const sizeMb = (archive.pointer() / 1024 / 1024).toFixed(2);
    console.log(`✅ Release archive generated successfully!`);
    console.log(`📦 File: release.zip (${sizeMb} MB)`);
    console.log(`✨ Ready for direct upload and extraction on ParsPack cPanel public_html!`);
});

archive.on('error', function (err) {
    throw err;
});

archive.pipe(output);

// Files and folders to exclude from production release
const excludeList = [
    'node_modules',
    '.git',
    '.github',
    'tests',
    '.env',
    '.env.example',
    'release.zip',
    'dist',
    'storage/logs/*.log',
    'database/database.sqlite' // Do not overwrite prod database if fresh
];

// Add project files to zip
archive.glob('**/*', {
    cwd: process.cwd(),
    ignore: [
        'node_modules/**',
        '.git/**',
        '.github/**',
        'tests/**',
        '.env',
        'release.zip',
        'dist/**',
        'storage/logs/**'
    ],
    dot: true
});

archive.finalize();
