<template>
    <div>
        <hr  style="border-color : #DEE2E6;">
        <div class="mb-4 mt-2 d-flex align-items-center">
            <h4 class="mb-0">Tags : </h4>
            <a href="#" 
            class="el-tag tag el-tag--info el-tag--mini ml-2"
            v-for="(tag,index) in item"
            :key="index"
            style="font-size:15px !important;"
            > 
            {{tag.name_tag}} 
            </a>
        </div>
        <div class="ah-frame-bg">
            <div class="d-flex justify-content-start comment-list">
            <i class="fa fa-comments" aria-hidden="true"></i>
            <span> Bình luận </span>
            </div>
            <div >
                <textarea v-model="comment.description" class="content-of-comment w-100" placeholder="Nhập bình luận của bạn tại đây" maxlength="5000" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button @click="createComment()" type="button" class="btn btn-info">Bình luận</button>
            </div>
            <comment
            @commentFeedback="getComment()"
            @commentDestroy="getComment()"
            @commentEdit="getComment()"
            @commentFeedbackDestroy="getComment()"
            v-for="(comment,index) in listComment "
            :key="index"
            :comment="comment"
            />
            
        </div>
    </div>
</template>
<script>
import Comment from './Comment.vue'
import {mapGetters,mapActions} from 'vuex'
export default {
    props:['item'],
    data() {
        return {
            comment : {
                user_name : null,
                description : '',
                article_id:null
            },
            listComment : []
        }
    },
//=========================================================
    computed : {
        ...mapGetters(['StateUser'])
    },
//=========================================================
    methods : {
        ...mapActions(['GetPosts']),
        // Thêm bình luận cho người dùng
        createComment() {
        this.$emit('checkLike')
        let token = window.localStorage.getItem('token')
        this.comment.user_name = this.StateUser.name
        this.comment.article_id = this.$route.params.id
        
        this.axios.post('comment/'+this.comment.article_id,this.comment,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
        )
        .then(() => {
            this.comment.description = ''
            this.getComment()
            
            //this.GetPosts()
        })
      },
      //=========================================================
      // Lấy danh sách tất cả bình luận của 1 bài viết
      getComment() {
          let token = window.localStorage.getItem('token')
          if(this.StateUser){
          this.comment.article_id = this.$route.params.id
          this.axios.get('comments/'+this.comment.article_id,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
                    } 
          }
        )
        .then((response) => {
            this.listComment = [...response.data.getComments.comments].reverse()
        })
      }
      }
    },
    //=========================================================
    components : {
        Comment
    },
//=========================================================
    mounted() {
        this.getComment()
    },
    // beforeDestroy() {
    //     this.GetPosts()
    // }
}
</script>