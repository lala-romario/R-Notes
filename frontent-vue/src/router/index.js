import { createRouter, createWebHistory } from 'vue-router'
import Homeview from '../views/Homeview.vue'
import Signup from '@/views/Signup.vue'
import Signin from '@/views/Signin.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Homeview,
    },
    {
      path: '/signup',
      name: 'Signup',
      component: Signup
      
    },
    {
      path: '/signin',
      name: 'signin',
      component: Signin
    },
    {
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      
    },
  ],
})

export default router
