<template>
    <div id="#" class="container-fluid post-new">
        <div class="position-fixed login position-relative"
            v-if="showLogin"
        >
            <i @click="showLogin = false" class="fa fa-times-circle close position-absolute" aria-hidden="true"></i>
            <Login></Login>
        </div>
        <section id="content" class="container ml-5 pr-5 my-3 my-lg-5 d-flex" 
        style="height:auto !important;
                position : relative !important;
        "
        >
            <div class="row" style="height:auto !important;">
                <div class="hidden-md-down post-action ml-auto pr-4">
                    <div class="post-actions d-flex post-action__fixed flex-column align-items-center mx-auto">
                        <div class=" votes votes--side post-actions__vote mb-1 text-center">
                            <span @click="like(up=1)" :class="{select: userLike==1 && isLoggedIn}" class="icon-btn vote text-muted "><i @click="userCheck(1)" class="fa fa-caret-up" aria-hidden="true"></i></span>
                            <div  class="points text-muted">{{number}}</div>
                            <span @click="like(down=0)" :class="{select: userLike==0 && isLoggedIn}" class="icon-btn vote text-muted"><i @click="userCheck(0)" class="fa fa-caret-down" aria-hidden="true"></i></span>
                            <button @click="deleteLike()" type="button" class="btn btn-primary"> <span @click="userCheck()"> Hủy </span></button>
                        </div>
                    </div>
                </div>
                <article 
                class="post col-md-9 col-lg-7 mr-3 post-detail noselect"
                itemscope itemtype="http://schema.org/Article"
                style="height:auto !important;"
                >
                    <div class="d-flex justify-content-between mb-5">
                        <div>
                            <span class="text-info mr-2">{{articleShow.user.name}}</span>
                            <span class="text-muted mr-4">{{articleShow.user.email}}</span>
                            <button
                                
                                @click="copy()"
                                v-clipboard:copy="url"
                                type="button" 
                                class="btn btn-secondary btn-share"
                                >chia sẻ
                                    <i aria-hidden="true" class="fa fa-link text-white ml-1"></i>
                            </button>
                            <div class="text-muted mt-3">Đã xem {{articleShow.updated_at}}</div>
                        </div>
                        <div>
                            <span class="text-muted">Đã đăng vào {{articleShow.created_at}}</span>
                            <div class="d-flex align-items-center">
                                <div class="starts">
                                    <span class="stats-item stats-item__post text-muted mr-2" data-tippy="" data-original-title="Lượt xem: 7"><i aria-hidden="true" class="stats-item__icon fa fa-eye mr-1"></i>{{articleShow.view}}</span>
                                    <span class="stats-item stats-item__post text-muted mr-2" data-tippy="" data-original-title="Bookmark: 0"><i aria-hidden="true" class="stats-item__icon fa fa-bookmark mr-1"></i>0</span>
                                    <span class="stats-item stats-item__post text-muted mr-2" data-tippy="" data-original-title="Bình luận: 0"><i aria-hidden="true" class="stats-item__icon fa fa-comments mr-1"></i>{{articleShow.comments_count}}</span>
                                </div>
                            </div>
                            <div style="line-height:50px">
                                
                            </div>
                        </div>

                    </div>
                    <h1 itemprop="name" class="post-title mb-3 pb-3 md-h1 border-bottom" >
                        {{articleShow.title}}
                        
                    </h1>

                    <div class="post-content" v-html="articleShow.content"></div>

                </article>
                
                <comment-list
                    @checkLike="userCheckComment()"
                    :item="articleShow.tags"
                    class="post col-md-9 col-lg-7 mx-auto post-detail noselect"
                    style="height:auto !important;"
                />
            </div>
            <div class="post-new__left">
                <div class="post_new__sticky">
                    <div class="section-title d-flex align-items-end mb-3 ">
                        <a class="mt-1" href="#">
                            <h4 class="text-uppercase mb-0">Bài viết mới nhất</h4>
                        </a>
                        <hr class="section-title__filler bg-primary">
                    </div>
                    <PostNew
                    v-for="(item,index) in Postnew"
                    :key="index"
                    :item="item"
                    @postNew="getArticle"
                    >
                    </PostNew> 
                </div>
            </div>
        </section>
        <div class="py-3 px-5"><h3>Bài viết liên quan : </h3></div>
        <div class="d-flex pb-5 px-5">
                <PostContacts
                v-for="(item,index) in postContactShow"
                :key="index"
                :item="item"
                class="mr-2"
                @postLink="getArticle"
                >
                </PostContacts>
        </div>
        
    </div>
</template>
<script>
import Login from "./Login.vue"
import CommentList from './comment/CommentList.vue'
import PostContacts from './PostContact.vue'
import PostNew from './PostNew.vue'
import {mapGetters,mapActions} from 'vuex'
export default {
    props : ["id"],
    data() {
        return {
            userLike:null,
            url:null,
            articleShow:{},
            postContactShow:[],
            rates : {
                like : null,
                user_id: null,
                article_id: null
            },
            number : null,
            Postnew : null,
            showLogin:null
            
        }
    },
//=========================================================
    computed : {
        isLoggedIn : function(){ return this.$store.getters.isAuthenticated},
        ...mapGetters(['StateUser']),
    },
//=========================================================
    methods : {
        ...mapActions(['GetPosts']),
        // Xóa đánh giá của 1 người dùng
        deleteLike() {
            let token = window.localStorage.getItem('token')
             this.axios.post('/delete/like/'+this.StateUser.id,
        {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
      )
      .then(() => {
          this.getRate()
          this.userLike = null
      })

        },
//=========================================================
        // Lấy và hiển thị 1 bài viết
        getArticle(){ 
            let token = window.localStorage.getItem('token')
            this.axios.get('articles/'+this.$route.params.id,
        {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
      )
      .then(response => {
        this.articleShow = response.data.article
        this.postContactShow = response.data.postContact
        this.Postnew = response.data.postNew
        this.articleShow.view++
        this.axios.put('articles/view/'+this.id,{view : this.articleShow.view},
            {
            headers : {
                Accept : 'application/json',
                Authorization : 'Bearer ' + token
            } 
            }
        )
      })
        },
//=========================================================
        // đánh giá bài viết của người dùng
        like(num) {
            let token = window.localStorage.getItem('token')
            this.rates.article_id = this.$route.params.id
            this.rates.user_id =this.StateUser.id
            this.rates.like = num 
             this.axios.post('review',this.rates,
        {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
      )
      .then((response) => {
          if(response.data === "likeExits") {
              alert('chỉ được đánh giá 1 lần')
          }
          this.getRate() 
           
          //this.GetPosts()
      })

        },
//=========================================================
        // Lấy ra đánh giá của 1 bài viết
         getRate() {
             let token = window.localStorage.getItem('token')
            this.axios.get('review/rate/'+this.$route.params.id,
        {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
      )
      .then((response) => {
          this.number = response.data.result
      })
        },
//=========================================================
        // Chia sẻ bài viết
        copy() {
            this.url = window.location.href
        },
        checkUserLike() {
            let token = window.localStorage.getItem('token')
            this.axios.get('user/like?user='+this.StateUser.id+'&article='+this.$route.params.id,
            {
                headers : {
                    Accept : 'application/json',
                    Authorization : 'Bearer ' + token
                }
            }
          )
          .then(response => {
            this.userLike = response.data.userLike.like
          })
        },
//===========================================================
        // Hiển thị form login nếu user chưa đăng nhập
        userCheck(like) {
            if(!this.isLoggedIn) {
                this.showLogin = true
            }
            else {
                this.userLike = like
            }
        },
        userCheckComment() {
             if(!this.isLoggedIn) {
                this.showLogin = true
            }
        }
    
    },
//=========================================================
    mounted() {
        this.getArticle()
        this.getRate()
        this.checkUserLike()
    },
//=========================================================
    components : {
        CommentList,
        PostContacts,
        PostNew,
        Login
    }
}
</script>

<style scoped>
    .close {
        top:60px;
        left:810px;
        color:red;
        cursor: pointer;
    }
    .login {
        z-index: 1000;
        width: 100%;
        top:50px;
        left:0;
        bottom:0;
        background-color: rgba(65, 66, 66, 0.568);
    }
    .select i:first-child{
        color: #1244e9 ;
    }
    .stats-item__post {
        font-size: 20px !important;
        margin-right: 30px !important;
    }
    .btn-share {
        padding:2px 7px !important;
        font-size: 15px !important;
    }
    .post-new {
        position:relative;
    }
    .post-new__left {
        position:absolute;
        top:0;
        right:-50px;
        width: 25%;
        height:100%;
    }
    .row {
        margin-left:-160px !important;
    }
    .post_new__sticky {
        position: sticky;
        top:100px
    }
</style>
