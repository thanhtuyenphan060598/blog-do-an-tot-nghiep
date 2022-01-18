<template>
    <div id="bai-viet-moi-nhat" class="container vue-tempalte">
        <!-- Header -->
        <header id="bai-viet-lien-quan">
            <!-- Navigation -->
        <nav class="navbar shadow bg-white rounded justify-content-between flex-nowrap flex-row fixed-top">
            <div class="container">
                    <a class="navbar-brand float-left" @click.prevent="reload()" href="#" target="_blank">
                    <img src="../../assets/img/logo_full.svg" alt="" width="70" height="24">
                    </a>
                    <ul class="main-menu" >
                        <router-link @click.native="this.$store.dispatch('GetPosts')" class="main-menu__item active" :to="{name:'listpost'}">Bài viết</router-link>
                        <router-link class="main-menu__item active" :to="{name:'listpost'}">Hỏi đáp</router-link>
                        <router-link class="main-menu__item active" :to="{name:'listpost'}">Thảo luận</router-link>
                        
                       
                    </ul>
                    <div class="topnav search-container">
                        
                            <input type="text" v-model="search" placeholder="Search.." name="search">
                            <button @click="searchPost()" type="button"><i class="fa fa-search"></i></button>
                        
                    </div>
                    <ul class="nav navbar-nav flex-row float-right">
                        <span v-if="isLoggedIn">
                            <li class="nav-item position-relative w-100 ml-1">
                                <a class="text-decoration-none" @click="toggle()" href="#">{{ StateUser.name }}
                                <avatar
                                style="width:30px;
                                height:30px;
                                font-size:13px !important;
                                line-height:33px !important;
                                display:inline-block;
                                "
                                 :username="StateUser.name"></avatar>
                                </a>
                                <ul class="nav-item__profile" ref="toggleList">
                                    <li @click="hidden()">
                                        <router-link :to="{name:'informationuser'}" >
                                             <i class="fa fa-user mr-3"></i>
                                            Trang cá nhân
                                        </router-link>
                                    </li>
                                    <li @click="hidden()">
                                        <router-link :to="{name:'postuser',params:{current_page:1}}" >
                                             <i class="fa fa-user mr-3"></i>
                                            Quản lý bài viết
                                        </router-link>
                                    </li>
                                    <li @click="hidden()">
                                        <a href="#" @click.prevent="logout()" >
                                            <i class="fa fa-sign-out mr-3" aria-hidden="true"></i>
                                            Đăng xuất
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </span>
                        <span class="nav navbar-nav flex-row float-right" v-else>
                            <li class="nav-item">
                                <router-link class="nav-link pr-3 " :to="{name:'login'}">Sign In</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="btn btn-outline-primary" :to="{name:'register'}">Sign Up</router-link>
                            </li>
                        </span>
                    </ul>
            </div>
        </nav>
</header>

        
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
import Avatar from 'vue-avatar'
export default {
    name: 'Header',
    data() {
        return {
            search:''
        }
  },
  components :{
      Avatar
  },
//=========================================================
  computed : {
      isLoggedIn : function(){ return this.$store.getters.isAuthenticated},
      ...mapGetters(['StateUser'])
  },
//=======================================================================
  mounted() {
      this.checkUser()
  },
//=========================================================
  methods: {
    //
    checkUser() {
        let token = window.localStorage.getItem('token')
        this.axios.get('/user/check/'+this.StateUser.id,
            {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
                    } 
            }
        )
        .then((response) => {
            if(response.data.user) {
                window.localStorage.removeItem('token')
                this.logout()
            }
        })
    },
    // Đăng xuất tài khoản
    async logout() {
        let token = window.localStorage.getItem('token')
        await this.axios.post('/logout',this.StateUser,
            {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
                    } 
            }
        )
        .then(() => {
            window.localStorage.removeItem('token')
        })
        await this.$store.commit('LogOut')
        this.$router.push('/login')
    },
    //=========================================================
    // Load lại trang khi bấm vào logo
    reload() {
      this.$store.dispatch('GetPosts')
      this.$router.push({name:'listpost'})
    },
    //=========================================================
    // hiện thanh điều hướng
    toggle() {
        let a = this.$refs.toggleList
        if (a.style.height == '162px') {
            a.style.height = '0px'
        }
        else {
            a.style.height = '162px'
        }
    },
    //=========================================================
    // ẩn thanh điều hướng
    hidden() {
        let a = this.$refs.toggleList
        a.style.height = '0px'
    },
    //=========================================================
    // Tìm kiếm bài viết
    searchPost() {
        this.axios.get('articles?search='+this.search,
        {
          headers : {
            Accept : 'application/json'
          } 
        }
      )
      .then(response => {
        this.$store.commit('setPosts',response.data.articles)
        this.$router.push({name:'listpost'})
        
      })
    },
  },
}
</script>