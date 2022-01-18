<template>
  <!-- Two-way Data-Binding -->
  <div class="container ">
     <div class="table-title bg-primary mt-5 py-2 px-4 rounded ">
                <div class="row">
                    <div class="col-sm-5 text-white" >
                        <h3 style="line-height:40px">Tạo <b>Bài</b> <b>Viết</b></h3>
                    </div>
                </div>
    </div>
    <form @submit.prevent="createPost()" class="px-3">
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
        class="d-inline-block mr-3"
        @selectTags ="selectTag()"
        v-for="(item,index) in tagsGet"
        :key="index"
        :item="item"
      />
      <label for="" class="d-block font-weight-bold">Nội dung : </label>
      <quill-editor
          class="mt-3 mb-5"
          ref="myQuillEditor"
          v-model="listPost.content"
          :options="editorOption"
      />
      
          <!-- @blur="onEditorBlur($event)"
          @focus="onEditorFocus($event)"
          @ready="onEditorReady($event)" -->
      <button type="submit" class="btn btn-primary mb-5">Tạo</button>
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
        listPost : {
          title : '',
          category_id : '',
          tagsId : [],
          content: '',
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
      // Chọn các thẻ bài viết
      selectTag() {
        let tagsPost = []
        tagsPost = this.tagsGet.filter(tag => tag.select === true )
        this.listPost.tagsId = tagsPost.map(tag => tag.id)
      },
      //=========================================================
      // Lấy các thẻ bài viết
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
      // Lấy danh mục bài viết
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
      // thêm bài viết của người dùng
      createPost() {
        let token = window.localStorage.getItem('token')
        this.listPost.user_id = this.StateUser.id
        this.axios.post('articles',this.listPost,
          {
          headers : {
            Accept : 'application/json',
            Authorization : 'Bearer ' + token
          } 
        }
        )
        .then(()=> {
          console.log()
          alert('Thêm thành công',)
          this.GetPosts()
          this.$router.push({name:'listpost'})
        })
      }
    },
//=========================================================
    components : {
      Tags
    },
//=========================================================
  // Gọi hàm khi các components đã render
    mounted() {
      this.getTags()
      this.getCategories()
    },

    
  }
</script>
<style scoped>
  
  Tags {
    cursor: pointer;
  }
</style>