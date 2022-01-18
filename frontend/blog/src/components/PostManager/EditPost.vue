<template>
  <div class="container ">
     <div class="table-title bg-primary mt-5 py-2 px-4 rounded ">
                <div class="row">
                    <div class="col-sm-5 text-white" >
                        <h3 style="line-height:40px">Sửa <b>Bài</b> <b>Viết</b></h3>
                    </div>
                </div>
    </div>
            
            <form @submit.prevent="updatePost()" class="px-3">
            <div class="form-group mb-3 mt-2">
                <h3>Tiêu đề</h3>
                <input type="text" v-model="listPost.title" class="form-control" placeholder="Tieu de" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            
            <div class="form-group mb-3 mt-3">
                <label for="" class="d-block font-weight-bold">Danh mục : </label>
                <select name="" id="" class="pr-3" v-model="listPost.category_id">
                    <option value="">----vui lòng chọn danh mục----</option>
                    <option 
                    v-for="(categories,index) in categoriesGet" 
                    :key="index" 
                    :value="categories.id">
                    {{categories.name_category}}
                    </option>
                </select>
                
            </div>
            <label for="" class="d-block font-weight-bold">Thẻ bài viết : </label>
            <Tags
                class="d-inline-block"
                @selectTags ="selectTag()"
                v-for="(item,index) in tagsGet"
                :key="index"
                :item="item"
            />
            <label for="" class="d-block font-weight-bold mt-4">Nội dung : </label>
            <quill-editor
                class="mt-3 mb-2"
                ref="myQuillEditor"
                v-model="listPost.content"
                :options="editorOption"

            />
            
                <!-- @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)" -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mb-5">Sửa</button>
                    <button 
                    type="button" 
                    class="btn btn-primary mb-5"
                    @click="$router.push({name:'postuser'})"
                    >Hủy</button>
                </div>
            </form>
  
</div>     
</template>

<script>
import Tags from '../Tags.vue'
import {mapGetters,mapActions} from 'vuex'
  export default {
    data () {
      return {
        editorOption: {
          // Some Quill options...
          placeholder: 'No need space new line',
        },
        tagsGet: [],
        categoriesGet : [],
        post: {},
        listPost : {
          title : '',
          category_id : '',
          tagsId : [],
          content: null,
          user_id: null
        }

      }
    },
//=========================================================
    computed : {
      ...mapGetters(['StateUser'])

    },
//=========================================================
    methods : {
      ...mapActions(['GetPosts']),
      //=========================================================
      selectTag() {
        let tagsPost = []
        tagsPost = this.tagsGet.filter(tag => tag.select === true )
        this.listPost.tagsId = tagsPost.map(tag => tag.id)
      },
      //=========================================================
      getTags() {
        let token = window.localStorage.getItem('token')
        this.axios.get('tag',
        {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
      )
      .then(response => {
        this.tagsGet = response.data.tags
      })
      },
      //=========================================================
      getCategories() {
        let token = window.localStorage.getItem('token')
        this.axios.get('categories',
        {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
      )
      .then(response => {
        this.categoriesGet = response.data.categories
      })
      },
      //=========================================================
      updatePost() {
        this.listPost.user_id = this.StateUser.id
        let token = window.localStorage.getItem('token')
        this.axios.put('articles/'+this.$route.params.edit,this.listPost,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
        )
        .then(()=> {
          console.log()
          alert('Sửa thành công',)
          this.GetPosts()
          this.$router.push({name:'listpost'})
        })
      },
      //=========================================================
      getPost() {
        let token = window.localStorage.getItem('token')
          this.axios.get('articles/'+this.$route.params.edit+'/edit',
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
                    } 
          })
          .then( response => {
            
            let post = response.data.article
            this.listPost.title = post.title
            this.listPost.category_id = post.category_id
            post.tags.forEach( tag => {
                this.tagsGet.forEach(tagGet => {
                  if(tag.id == tagGet.id) {
                    tagGet.select=true
                  }
                })
            })
            
            this.listPost.content = post.content
            
          })
      }
    },
//=========================================================
    components : {
      Tags
    },
//=========================================================
    mounted() {
      this.getTags()
      this.getCategories()
      this.getPost()
    }
    
  }
</script>

<style scoped>
  
  Tags {
    cursor: pointer;
  }
</style>