import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import Toaster from '../../vendor/masmerise/livewire-toaster/resources/js';
import moment from '@victoryoalli/alpinejs-moment'
import timeout from '@victoryoalli/alpinejs-timeout'

Alpine.plugin(timeout)

Alpine.plugin(moment)

Alpine.plugin(Toaster);

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
