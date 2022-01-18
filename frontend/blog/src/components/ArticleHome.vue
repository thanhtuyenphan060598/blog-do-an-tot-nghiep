<template>
    <div>
        <div class="bg-dark py-md-1 py-5">
            <div class="container">
                <div class="w-100 d-flex justify-content-between">
                    <ul class="flex-grow-1 flex-wrap d-block pt-3 py-3 text-white d-flex align-items-center justify-content-between list-unstyled">
                        <router-link 
                        :to="{name:'listpost'}" 
                        class="text-warning nav-article position-relative"
                        style="text-decoration:none;"
                        @click.native="loadNew()"
                        >
                        MỚI NHẤT
                        <span></span>
                        </router-link>

                        <router-link 
                        :to="{name:'listpost'}" 
                        class="text-warning nav-article position-relative"
                        style="text-decoration:none;"
                        @click.native="fillCategory(category.id)"
                        v-for="(category,index) in categoriesGet"
                        :key="index"
                        >
                        {{category.name_category}}
                        <span></span>
                        </router-link>

                    </ul>
                        <div class="my-2 flex-grow-1">
                        <span v-show="isLoggedIn">   
                            <router-link :to="{name:'createpost'}" class="btn btn-primary float-right text-uppercase hidden-md-down ">
                                <i aria-hidden="true" class="fa fa-pencil"></i> 
                                Viết bài
                            </router-link>
                        </span>
                        </div>
                    
                </div>    
            </div>
        </div>
        <div>
            <div class="p-4 text-white text-center h4 font-weight-bold py-1" style="background: linear-gradient(to right, rgb(131, 96, 195), rgb(46, 191, 145));">
                <a href="https://facebook.com/groups/viblo.community.official" target="_blank" rel="noopener" class=" text-white">
                    &gt;&gt; Tham gia Facebook group "Viblo Community" để cùng nhau học tập và kết nối &lt;&lt;
                </a>
            </div>
        </div>
        <div class="container pt-3 ">
            <div class="d-flex justify-content-between">
                <div class="bg-white" style="width:73%;">
                    <router-view></router-view>
                </div>
                <div class="hidden-md-down " style="width:25%">
                    <div class="sidebar-wrapper sticky-top">
                        <div class="" style="top:80px; overflow-y:hidden;">
                            <div class="main-feed__sidebar">
                                <div class="main-feed__sidebar_questions-feed">
                                    <div class="section-title d-flex align-items-end mb-3">
                                        <a class="mt-1" href="#">
                                        <h4 class="text-uppercase mb-0">Lượt xem nhiều</h4>
                                        </a>
                                        <hr class="section-title__filler bg-primary">
                                    </div>
                                        <Sidebar
                                        v-for="(item,index) in listPostView"
                                        :key="index"
                                        :item=item
                                        >
                                        </Sidebar>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from './main/Sidebar'
import {mapGetters} from 'vuex'
export default {
    name:'List',
    data() {
        return {
            listPostView : null,
            categoriesGet:[]
        }
    },
//=========================================================
    mounted(){
       this.getPostView()
       this.getCategories()
    },
//=========================================================
    components : {
        Sidebar,
    },
//=========================================================
    computed : {
      isLoggedIn : function(){ return this.$store.getters.isAuthenticated},
      ...mapGetters(['StatePosts'])
    },
//=========================================================
    methods: {
        // Lấy danh sách đánh giá của nhiều bài viết
            getPostView() {
            this.axios.get('view/post',
                {
                headers : {
                    Accept : 'application/json',
                        } 
                }
            )
            .then((response) => {
                this.listPostView = response.data.articles
                
                
            })
        },
        //=========================================================
        // lấy danh sách chuyên mục của nhiều bài viết
        getCategories() {
        this.axios.get('categories',
        {
          headers : {
            Accept : 'application/json',
          } 
        }
      )
      .then(response => {
        this.categoriesGet = response.data.categories
      })
      },
        //=========================================================
        loadNew() {
            this.$store.dispatch('GetPosts')
        },
        //=========================================================
        // Lọc bài viết theo danh mục
        fillCategory(category) {
             this.axios.get('articles?category='+category,
        {
          headers : {
            Accept : 'application/json'
          } 
        }
      )
      .then(response => {
        this.$store.commit('setPosts',response.data.articles)
      })
        }
    }
}
</script>

<style scoped>
 .sticky-top {
     top:80px;
     margin-bottom: 90px;
 }
</style>