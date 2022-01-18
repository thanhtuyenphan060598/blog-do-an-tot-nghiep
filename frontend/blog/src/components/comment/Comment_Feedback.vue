<template>
    <div class="row bg-comment">
        <div class="col-12 text-info d-flex justify-content-between">
            <span href="#">{{item.user_name}}</span>
            <div>
                <span v-if="item.user_name == StateUser.name" class="icon-delete mr-2" @click="showEdit=!showEdit"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                <span v-if="item.user_name == StateUser.name" class="icon-delete" @click="deleteComment(item.id)"><i class="fa fa-times-circle text-danger " aria-hidden="true"></i></span>
            </div>
        </div>
        <div class="col-12 text-dark">
            <span v-if="showEdit">{{item.description}}</span>
            <input class="w-100" v-if="!showEdit" v-model="item.description">
            <div class="d-flex justify-content-end"><button @click="editComment(item.id)" v-if="!showEdit" type="button" class="btn btn-info mt-2">Lưu</button></div>
        </div>
        <div 
        class="col-12 text-muted"
        style="font-size:13px"
        >
            Bình luận
            {{item.created_at}}
        </div>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    props: ['item'],
    data() {
        return {
            showEdit:true,
            
        }
    },
    computed : {
        ...mapGetters(['StateUser'])
    },
    methods : {
        //Xóa phản hồi bình luận
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
            this.$emit('commentFeedbackDestroy')
            alert('Xóa bình luận thành công')
        })
      }
        },
        
        //=========================================================
        // Sửa phản hồi bình luận của người dùng
        editComment(comment) {
          let token = window.localStorage.getItem('token')
          if(this.StateUser){
          this.axios.post('/comment/edit/'+comment,this.item,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' +token
                    } 
          }
        )
        .then(() => {
            this.$emit('commentFeedbackEdit')
            this.showEdit=true
            alert('Lưu thành công')
        })
          }
        },
    }
}
</script>
<style scoped>
    .icon-delete {
        cursor: pointer;
    }
</style>