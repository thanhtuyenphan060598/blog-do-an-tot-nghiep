<template>
    <div class="row bg-comment">
        <div class="col-12 text-info d-flex justify-content-between">
            <span href="#">{{comment.user_name}}</span>
            
            <div>
                <span v-if="comment.user_name == StateUser.name" class="icon-delete mr-2" @click="showEdit = !showEdit"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                <span v-if="comment.user_name == StateUser.name" class="icon-delete" @click="deleteComment(comment.id)"><i class="fa fa-times-circle text-danger " aria-hidden="true"></i></span>
            </div>
        </div>
        <div class="col-12 text-dark">
            <span v-if="showEdit">{{comment.description}}</span>
            <input class="w-100" v-if="!showEdit" v-model="comment.description">
            <div class="d-flex justify-content-end"><button @click="editComment(comment.id)" v-if="!showEdit" type="button" class="btn btn-info mt-2">Lưu</button></div>
        </div>
        <div 
        class="col-12 text-muted"
        style="font-size:13px"
        >
            Bình luận
            {{comment.created_at}}
        <a href="#" @click.prevent="showFeedback = !showFeedback" class="comment_feedback ml-3 d-inline-block text-decoration-none">Phản hồi</a>
        <div class="row bg-comment" v-if="showFeedback">
            <div class="col-12 text-info d-flex justify-content-between">
                <span href="#">{{StateUser.name}}</span>
            </div>
            <div class="col-12 text-dark">
                <input class="w-100" v-model="commentFeedBack.description">
                <div class="d-flex justify-content-end"><button @click="commentFeedback(comment.id)" type="button" class="btn btn-info mt-2">Phản hồi</button></div>
            </div>
        </div>
        <commentFeedback
        @commentFeedbackEdit="getCommentFeedback()"
        @commentFeedbackDestroy="getCommentFeedback()"
        v-for="(item,index) in comment.comments" :key="index"
        :item="item"
        />
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import commentFeedback from './Comment_Feedback.vue'
export default {
    props:['comment'],
    data() {
        return {
            showFeedback:false,
            showEdit:true,
            commentFeedBack : {
                user_name : null,
                description : '',
            }
        }
    },
//=========================================================
    computed : {
        ...mapGetters(['StateUser'])
    },
//=========================================================
    methods : {
        // Phản hồi bình luận
        commentFeedback(comment) {
            let token = window.localStorage.getItem('token')
            this.commentFeedBack.user_name = this.StateUser.name
          if(this.StateUser){
          this.axios.post('/comment/feedback/'+comment,this.commentFeedBack,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' +token
                    } 
          }
        )
        .then(() => {
            this.$emit('commentFeedback')
            this.commentFeedBack.description = ''
            this.showFeedback = false
            alert('Phản hồi thành công')
        })
      }
        },
        //Xóa bình luận của người dùng
        deleteComment(comment) {
          let token = window.localStorage.getItem('token')
          if(this.StateUser){
          this.axios.post('/comment/delete/'+comment,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' +token
                    } 
          }
        )
        .then(() => {
            this.$emit('commentDestroy')
            alert('Xóa bình luận thành công')
        })
      }
        },
        
        //=========================================================
        // Sửa bình luận của người dùng
        editComment(comment) {
          let token = window.localStorage.getItem('token')
          if(this.StateUser){
          this.axios.post('/comment/edit/'+comment,this.comment,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' +token
                    } 
          }
        )
        .then(() => {
            this.$emit('commentEdit')
            this.showEdit=true
            alert('Lưu thành công')
        })
          }
        },
        getCommentFeedback() {
            this.$emit('commentFeedbackDestroy')
        }

    },
    components: {
        commentFeedback
    },
}
</script>

<style scoped>
    .icon-delete {
        cursor: pointer;
    }
    .comment_feedback {
        font-size:15px;
    }
</style>