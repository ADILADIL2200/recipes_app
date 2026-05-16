import './bootstrap';
import { createIcons, icons } from 'lucide';

// renders every <i data-lucide="..."> on the page
document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});