//store/modules/auth.js
import axios from 'axios'

const state = {
    user: null,
    posts: null,
};
const getters = {
    isAuthenticated: state => !!state.user,    
    StatePosts: state => state.posts,
    StateUser: state => state.user,

};
const actions = {
    setUser(context,user) {
        user.name = user.name.toUpperCase()
        context.commit('setUser',user)
    },

    async GetPosts({ commit },pageNum){
        let token = window.localStorage.getItem('token')
        let response = await 
        axios.get('articles?page='+pageNum,
       {
         headers : {
           Accept : 'application/json',
           Authorization : 'Bearer ' + token
         } 
       }
     )
        
       await commit('setPosts', response.data.articles)
    },
};
const mutations = {
    setUser(state, user){
        state.user = user
    },
    setPosts(state, posts){
        state.posts = posts
    },
    LogOut(state){
        state.user = null
    },
    
};
export default {
  state,
  getters,
  actions,
  mutations,
};