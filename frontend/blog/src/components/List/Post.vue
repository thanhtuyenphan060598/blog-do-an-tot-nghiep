<template>
    <div class=" post-feed-item d-flex mt-2">
        <avatar
            class="mr-2"
            style="width:40px !important;
            height:40px !important;
            font-size:15px !important;
            line-height:40px !important;
            display:inline-block;"
            :username="userName">
        </avatar>
        <div class="post-feed-item__info">
            <div class="post-meta--inline">
                <div class="user--inline d-inline-flex" style="flex-shrink:0;">
                    <span>
                        <span class="el-popover__reference-wrapper">
                            <span href="#" class="mr-3 el-popover__reference text-info" aria-describedby="el-popover-5265" tabindex="0">{{userName}}</span>
                        </span>
                    </span>
                </div>
                <div class="post-meta d-d-inline-flex align-items-center flex-wrap">
                    <div class="text-muted mr-5">
                        <span class="mr-3" >{{item.created_at}}</span>
                        <span class="post-reading_time mr-3 is-divide text-muted">{{item.updated_at}} đọc</span>
                    </div>
                </div>
            </div>
            <div class="post-title--inline">
                <h3 class="word-break mr-5 ">
                    <router-link @click.native="linkTitle()" :to="{name:'article',params:{id:item.id}}" class="link">{{item.title}}</router-link>
                </h3>
                <div class="tags">
                    <a 
                    v-for="(tag,index) in item.tags"
                    :key="index" 
                    href="#" 
                    class="el-tag tag el-tag--info el-tag--mini"
                    >
                    {{tag.name_tag}}
                    </a>
                </div>
            </div>
            <a href="#" class="el-tag tag el-tag--info el-tag--mini text-white"
            style="background-color:#5C8AC5;
            text-decoration:none;
            "
            > Tóm tắt nội dung : </a>
            <div class="mb-contents">
               <p>{{summary}}<span class="text-muted">.....</span>
               </p>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="starts">
                        <span class="stats-item text-muted mr-2" data-tippy="" data-original-title="Lượt xem: 7"><i aria-hidden="true" class="stats-item__icon fa fa-eye mr-1"></i>{{item.view}}</span>
                        <span class="stats-item text-muted mr-2" data-tippy="" data-original-title="Bookmark: 0"><i aria-hidden="true" class="stats-item__icon fa fa-bookmark mr-1"></i>0</span>
                        <span class="stats-item text-muted mr-2" data-tippy="" data-original-title="Bình luận: 0"><i aria-hidden="true" class="stats-item__icon fa fa-comments mr-1"></i>{{item.comments_count}}</span>
                    </div>
                </div>
                <div class="points d-flex align-items-center mr-3">
                    <div class="carets">
                        <i aria-hidden="true" class="fa fa-caret-up"></i>
                        <span class="text-muted">{{countRate}}</span>
                        <i aria-hidden="true" class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div>
        </div>
         <hr style="border-color : #3C485C;">
    </div>
</template>
<script>
import Avatar from 'vue-avatar'
const { convert } = require('html-to-text')
export default {
    props : ["item"],
    data() {
        return {
        }
    },
//=========================================================
    computed : {
        // Tính toán hiển thị đánh giá của người dùng cho bài viết
        countRate() {
            let like = 0
            let dislike = 0
            this.item.rates.forEach(rate => {
                if(rate.like === 1) {
                    like = like + 1
                }
                else {
                    dislike = dislike + 1
                }
            })
            
            return like - dislike
            
        },
        //=========================================================
        // Tóm tắt nội dung bài viết
        summary() {
            let content = this.item.content.slice(0,1000)
            let convertContent = convert(content)
            return convertContent
        },
        //=========================================================
        // Viết hoa tài khoản
        userName() {
            return this.item.user.name.toUpperCase()
        },
    },
    methods : {
        linkTitle() {
            window.location.href = window.location.href + '#'
        }
    },
    //=======================================================
    components : {
        Avatar
    }
    
   
}
</script>
<style>


</style>