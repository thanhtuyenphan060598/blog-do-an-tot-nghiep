import Vue from 'vue'
import App from './App.vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import routes from './routes.js'
import '@/assets/css/main.css'
import VueQuillEditor from 'vue-quill-editor'
import 'quill/dist/quill.core.css' // import styles
import 'quill/dist/quill.snow.css' // for snow theme
import 'quill/dist/quill.bubble.css' // for bubble theme
import Paginate from 'vuejs-paginate'
import store from './store'
import ScrollBar from 'vue2-scrollbar'
import Scrollspy from 'vue2-scrollspy';
import VueClipboard from 'vue-clipboard2'
import VueSocialauth from 'vue-social-auth'
// use default options
axios.defaults.baseURL = 'http://localhost:8000/api/';

Vue.use(VueClipboard)
Vue.use(Scrollspy);
Vue.use(ScrollBar)
Vue.component('paginate', Paginate)
Vue.use(VueQuillEditor, /* { default global options } */)
Vue.use(VueRouter)
Vue.config.productionTip = false
Vue.use(VueAxios, axios)

Vue.use(VueSocialauth, {

  providers: {
    google: {
      clientId: '166900061497-me7cb617qgudabt5gf9rl7i4mdit9qt8.apps.googleusercontent.com',
      clientSecret: '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',
      redirectUri: 'http://localhost:8080/auth/google/callback' // Your client app URL
    }
  }
})

const router = new VueRouter({
  routes,
  mode:'history'
}) 
 
new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
