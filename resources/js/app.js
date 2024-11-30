import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'
import sidebarData from './sidebar';

window.Alpine = Alpine;
Alpine.data('sidebarData', sidebarData);
Alpine.plugin(collapse)
Alpine.start();

