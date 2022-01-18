<template>
    <div class="row">
        <h1 class="col-12 card-title">Thông tin cá nhân</h1>
        <p class="col-12 card-subtitle">
            Quản lý thông tin cá nhân của bạn.
        </p>
        <div class="col-12 ">
            <avatar class="mx-auto" src="" :username="StateUser.name"></avatar>
        </div>
        
        <!-- <div class="col-md-9">
            <input id="customFile" ref="file" type="file" v-on:change="handleFileObject()" class="form-control">
        </div>
        <div class="col-md-3">
            <button class="btn btn-success btn-block" @click="uploadImage">Upload Image</button>
        </div> -->
        <div class="col-12 h3 text-center py-2 my-3">
           <small class="text-muted"> {{StateUser.name}}</small>
        </div>
        <form class="col-12" @submit.prevent="submit()">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="inputEmail4">Tên tài khoản</label>
                <input type="text" class="form-control" id="inputEmail4" :value="StateUser.username" disabled>
                </div>
                <div class="form-group col-md-12">
                <label for="inputPassword4">Tên hiển thị</label>
                <input type="text" class="form-control" id="inputPassword4" :value="StateUser.name" disabled> 
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Địa chỉ</label>
                <input v-model="information.address" type="text" class="form-control">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputCity">Số điện thoại</label>
                <input v-model="information.phone" type="text" class="form-control" id="inputCity">
                </div>
                <div class="form-group col-md-3">
                <label for="inputState">Giới tính</label>
                <select v-model="information.gender" id="inputState" class="form-control">
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                    <option value="3">Khác</option>
                </select>
                </div>
                <div class="form-group col-md-3">
                <label for="inputZip">Ngày sinh</label>
                <input ref="formatDate" v-model="information.date_of_birth" type="date" class="form-control" id="inputZip">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
import Avatar from 'vue-avatar'
import _ from 'lodash'
export default {
    data() {
        return {
            information : {
                user_id : null,
                address : '',
                phone : '',
                gender : null,
                date_of_birth : ''
            },
            thumbnail: null,
            thumbName: null,
            showForm: true,
            errors: null,
        }
    },
//=========================================================
    computed : {
        ...mapGetters(['StateUser']),
        
    },
//=========================================================
    methods : {
        // Thêm thông tin cá nhân của người dùng
        submit() {
            let token = window.localStorage.getItem('token')
             this.information.user_id = this.StateUser.id
             this.information.phone = Number(this.information.phone)
            this.axios.post('information',this.information,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
                    } 
        }
            )
            .then(()=> {
            alert('Cap nhat thanh cong',)
            })
        },
        //=========================================================
        // lấy thông tin cá nhân của người dùng
        getInfo() {
            let token = window.localStorage.getItem('token')
            this.axios.get('information/'+this.StateUser.id,
          {
          headers : {
                Accept : 'application/json',
                Authorization : 'Bearer ' + token
                    } 
        }
            )
            .then(response => {
                let info = response.data.userInfo[0]
                this.information.address = info.address
                this.information.phone = info.phone
                this.information.gender = info.gender
                this.information.date_of_birth = info.date_of_birth
            })
        },
        uploadImage() {
        this.errors = null

        let formData = new FormData()
        formData.append('thumbnail', this.thumbnail)


        this.axios.post('upload/img/'+this.StateUser.id, formData, {
            headers: {
              'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
            }
          }
        ).then(response => {
          this.showForm = false
          this.article = response.data.data
        }).catch(err => {
          if (err.response.status === 422) {
            this.errors = []
            _.each(err.response.data.errors, error => {
              _.each(error, e => {
                this.errors.push(e)
              })
            })

          }
        });
      },
      
      handleFileObject() {
        this.thumbnail = this.$refs.file.files[0]
        this.thumbName = this.thumbnail.name
      }
    
      
    },
//=========================================================
    mounted() {
        this.getInfo()
    },
    components : {
        Avatar
    }
}
</script>