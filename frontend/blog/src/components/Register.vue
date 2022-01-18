<template>
    <div 
    class="container w-25 bg-light pt-4 mt-5 px-4 rounded py-5 my-5"
    style="box-shadow:0px 0px 10px gray"
    >
              <form @submit.prevent="register()">
                  <h3>Sign Up</h3>
                  
                  <div class="form-group">
                      <label>Full Name</label>
                      <input 
                      type="text" 
                      class="form-control form-control-lg" 
                      v-model="users.name"/>
                  </div>
                  <div class="form-group">
                      <label>UserName</label>
                      <input 
                      type="text" 
                      :class="{'is-invalid':errors.username}"
                      class="form-control form-control-lg" 
                      v-model="users.username"/>
                      <div class="invalid-feedback" v-if="errors.username">{{errors.username[0]}}</div>
                  </div>

                  <div class="form-group">
                      <label>Email address</label>
                      <input 
                      type="email" 
                      :class="{'is-invalid':errors.email}" 
                      class="form-control form-control-lg" 
                      v-model="users.email"/>
                      <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                  </div>

                  <div class="form-group">
                      <label>Password</label>
                      <input 
                      type="password" 
                      :class="{'is-invalid':errors.password}" 
                      class="form-control form-control-lg" 
                      v-model="users.password" />
                      <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                  </div>
                      <button type="submit" class="btn btn-dark btn-lg btn-block" >
                      Sign Up
                      </button>
                      
                    

                  <p class="forgot-password text-right">
                      Already registered 
                      <router-link :to="{name: 'login'}">sign in?</router-link>
                  </p>
              </form>
      
    </div>
</template>

<script>

export default {
  name : "Register",
  data() {
    return {
      users : {
        name : '',
        username : '',
        password : '',
        email : ''
      },
      errors:{},
    }
  },
  methods: {
    // Đăng ký tài khoản
    register() {
      this.axios.post('register',this.users)
      .then(() => {
        alert('thanh cong')
        this.$router.push('/login')
      })
      .catch(error => {
       this.errors = error.response.data.errors
       console.log(this.errors)
      })
    }
      
  },
}

</script>

<style>

</style>
