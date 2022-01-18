<template>
    <div id="#">
      <div class="d-flex flex-row-reverse" ref="wrap">
        <a @click.prevent="showTag()" href="#" class="fill_tag">
          <i aria-hidden="true" class="fa fa-th-list"></i>
        </a>
        <div class="tags" ref="tagsToggle">
          <div class="d-flex flex-wrap">
            <router-link 
              v-for="(tag,index) in tagsGet"
              :key="index" 
              :to="{name:'listpost'}"
              class="el-tag tag el-tag--info el-tag--mini"
              @click.native="fillTag(tag.id)"
              >
              {{tag.name_tag}}
            </router-link>
          </div>
        </div>
        
      </div>
        <Post 
        v-for="(item,index) in StatePosts.data"
        :key="index"
        :item="item"
        />
      
        <paginate
        :page-count="StatePosts.last_page"
        :page-range="3"
        :margin-pages="1"
        :click-handler="clickCallback"
        :prev-text="'Prev'"
        :prev-class="'prev'"
        :next-class="'next'"
        :next-text="'Next'"
        :container-class="'pagination'"
        :page-class="'page-itemm'"
        :active-class = "'active-page'"
        >
        </paginate>

    </div>
</template>

<script>
import Post from '../List/Post.vue'
import {mapActions, mapGetters} from 'vuex'

export default {
    data() {
      return {
        tagsGet: []
      }
    },
//=========================================================
    components : {
        Post,

    },
//=========================================================
    computed : {
      ...mapGetters(['StatePosts']),
    },
//=========================================================
     methods: {
       ...mapActions(['GetPosts']),
      // Phân trang cho bài viết
      clickCallback (pageNum) {
      window.location.href = window.location.href + '#'
      this.$store.dispatch('GetPosts',pageNum)
      this.$router.push('/newest?page='+pageNum)
      //   let token = window.localStorage.getItem('token')
      //    this.axios.get('articles?page='+pageNum,
      //   {
      //     headers : {
      //       Accept : 'application/json',
      //       Authorization : 'Bearer ' + token
      //     } 
      //   }
      // )
      // .then(response => {
      //   this.$store.commit('setPosts',response.data.articles)
      //   this.$router.push('/newest?page='+this.StatePosts.current_page)
        
      // })
    },
//=========================================================
    // Lấy danh sách các thẻ bài viết
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
      // hiện các thẻ bài viết
      showTag() {
        let a = this.$refs.tagsToggle
        let b = this.$refs.wrap
        if (a.style.width == '100%') {
            a.style.width = '0'
        }
        else {
            a.style.width = '100%'
            b.style.height = '40px'
        }
      },
//=========================================================
      //Lọc ra các bài viết từ các thẻ
      fillTag(tag) {
             this.axios.get('articles?tag='+tag,
        {
          headers : {
            Accept : 'application/json'
          } 
        }
      )
      .then(response => {
        this.$store.commit('setPosts',response.data.articles)
      })
        }
  },
//========================================================= 
 // Trước khi components được tạo gọi hàm
  beforeCreate() {
      this.GetPosts
  },
//=========================================================
  // Sau khi components đã được hiển thị gọi hàm
  mounted() {
      this.getTags()
  },
  
}
</script>

<style scoped>
.tags {
  position: relative;
  width:0;
  overflow: hidden;
  transition: width 1.5s
}
.tags div{
  position:absolute;
  right:0px
}
.tags a {
  background-color: #5198A6;
  color:white;
}
.tags a:hover {
 background-color: #7B69BE;
}
.fill_tag {
  font-size: 20px;
}
/* .ps {
  height: 400px;
} */
</style>