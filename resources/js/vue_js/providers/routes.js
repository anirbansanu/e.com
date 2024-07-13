// PATH = resources/js/vue_js/providers/routes.js
import { createRouter, createWebHistory } from 'vue-router';
import Root from '../root.vue';
import Step1 from '../admins/pages/Step1.vue';
import Step2 from '../admins/pages/Step2.vue';
import Step3 from '../admins/pages/Step3.vue';

const routes = [
  {
    path: '/',
    name: 'root',
    component: Root,
    children: [
      {
        path: '',
        name: 'step1',
        component: Step1
      },
      {
        path: 'step2',
        name: 'step2',
        component: Step2
      },
      {
        path: 'step3',
        name: 'step3',
        component: Step3
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
