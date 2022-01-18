<template>
    <div class="row">
        <h1 class="col-12 card-title">Đổi mật khẩu</h1>
        <p class="col-12 card-subtitle">
            Thay đổi mật khẩu cho tài khoản của bạn. Bạn nên đặt mật khẩu mạnh để chặn những truy cập trái phép vào tài khoản của mình
        </p>
        <div class="form-group col-md-12 mt-4">
            <label class="password" for="inputEmail4">Mật khẩu hiện tại</label>
            <input type="password" class="form-control" id="inputEmail4" v-model="password.passwordPresent">
        </div>
        <div class="form-group col-md-12">
            <label class="password" for="inputPassword4">Mật khẩu mới</label>
            <input type="password" class="form-control" id="inputPassword4" v-model="password.passwordNew"> 
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button type="button" @click="passwordChange()" class="btn btn-primary">Đổi mật khẩu</button>
        </div>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    data() {
        return {
            password : {

                passwordPresent : '',
                passwordNew : ''
            }
        }
    },
//=========================================================
    computed : {
        ...mapGetters(['StateUser'])
    },
//=========================================================
    methods : {
        // Đổi mật khẩu người dùng
        passwordChange() {
            let token = window.localStorage.getItem('token')
            this.axios.post('password/'+this.StateUser.id,this.password,
                {
                headers : {
                    Accept : 'application/json',
                    Authorization : 'Bearer ' + token
                    }
                } 
            )
            .then(() => {
                alert('Doi mat khau thanh cong')
                this.$router.push('user')
            })
        }
    }
}
</script>