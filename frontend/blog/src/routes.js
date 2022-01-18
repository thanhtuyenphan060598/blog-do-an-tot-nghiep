import Register from './components/Register.vue'
import Login from './components/Login.vue'
import ArticleHome from './components/ArticleHome.vue'
import ListPost from './components/List/ListPost.vue'
import CreatePost from './components/List/CreatePost.vue'
import Article from './components/Article.vue';
import Information from './components/information/Information.vue'
import InformationUser from './components/information/InformationUser.vue'
import Password from './components/information/Password.vue'
import PostManager from './components/PostManager/PostManager.vue'
import EditPost from './components/PostManager/EditPost.vue'



const routes = [
  // {
  //   path: '/auth/:provider/callback',
  //   component: {
  //     template: '<div class="auth-component"></div>'
  //   }
  // },
  { path: '/register', component: Register, name:'register' },
  { path: '/login', component: Login, name:'login' },
  { 
    path: '/articlehome', 
    component: ArticleHome, 
    name:'articlehome',
    children : [
      { path: '/newest', component: ListPost, name:'listpost'},
    ]
  },
  { path: '/post/create', component: CreatePost, name:'createpost' },
  { path: '/post/user/:current_page', component:PostManager , name:'postuser' },
  { path: '/post/user/edit/:edit', component:EditPost , name:'postuserEdit' },
  { path: '/article/:id', component: Article, name:'article',props:true },
  { path: '/information', 
    component: Information, 
    name:'information', 
    children : [
      { path: '/information/user', component: InformationUser, name:'informationuser'},
      { path: '/information/password', component: Password, name:'password'},
    ]
},

  
]
export default routes