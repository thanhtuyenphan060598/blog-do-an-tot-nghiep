<template>
    <div 
    class="container w-25 bg-light pt-4 mt-5 px-4 rounded py-5 my-5 "
    style="box-shadow:0px 0px 10px gray"
    >
            <form @submit.prevent="login()">
                <h3>Sign In</h3>
                <div :class="{'invalid-feedback' :errors }"
                v-if="errors"
                style="font-size:1em;
                margin-bottom:10px;
                "
                >{{errors}}</div>
                <div class="form-group">
                    <label>UserName</label>
                    <input type="text" :class="{'is-invalid':errors}" class="form-control form-control-lg" v-model="users.username"/>
                    
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" :class="{'is-invalid':errors}" class="form-control form-control-lg" v-model="users.password"/>
                    
                </div>

                <button type="submit" class="btn btn-dark btn-lg btn-block"> Sign In</button>
                
                <p class="forgot-password text-right mt-2 mb-4">
                    <router-link to="/forgot-password">Forgot password ?</router-link>
                </p>

                <div class="social-icons">
                    <ul>
                        <li><a href="#" @click.prevent="AuthProvider('google')"><i class="fa fa-google"></i></a></li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    </ul>
                </div>
                
            </form>
           
        
    </div>
</template>

<script>
import {mapActions} from 'vuex'
    
    export default {
        name: "Login",
        data() {
            return {
              users : {
                username:'',
                password:'',
                google_id:''
              },
              errors: null,
            }
        },
//=========================================================        
        methods: {
          ...mapActions(['setUser']),
          //=========================================================
          // Đăng nhập người dùng
          login() {
            this.axios.post('login',this.users)
            .then(response => {
                window.localStorage.setItem('token',response.data.access_token)
                window.localStorage.setItem('token_type',response.data.token_type)
                this.setUser(response.data.users)
                
                window.location.replace('/newest')
            })
            .catch(error => {
                this.errors = error.response.data.errors
            })
          },
          AuthProvider(provider) {

              var self = this

              this.$auth.authenticate(provider).then(response =>{

                self.SocialLogin(provider,response)

                }).catch(err => {
                    console.log({err:err})
                })

            },

            SocialLogin(provider,response){

                this.$http.post('/sociallogin/'+provider,response).then(response => {
                    this.users.password = response.data.user.google_id
                    this.users.username = response.data.user.username
                    this.login()

                }).catch(err => {
                    console.log({err:err})
                })
            },
        },
        
    }
</script>