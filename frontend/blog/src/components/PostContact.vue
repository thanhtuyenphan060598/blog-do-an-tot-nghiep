<template>
    <div class="item swpider-slide swiper-slide-active" 
        style="width:100%;">
        <div class="card shadow-sm default">
            <div class="card-body">
                <div class="post-card__title text-dark word-break" style="-webkit-box-orient:vertical;">
                    <router-link @click.native="linkPost()" :to="{name:'article',params:{id:item.id}}" class="link">{{item.title}}
                    
                    </router-link>
                </div>
                <div class="post-card__author">
                    <a href="#" class="text-primary">{{item.user.name}}</a>
                </div>
                <span title="10 phút đọc" class="post-reading_time post-card__time text-muted">{{item.updated_at}}</span>
                <div class="d-flex justify-content-between">
                    <div class="post-stats ">
                        <span class="stats-item mr-05" data-tippy="" data-original-title="Lượt xem"><i aria-hidden="true" class="fa fa-eye"></i>{{item.view}}</span>
                        <span class="stats-item mx-05" data-tippy="" data-original-title="Bookmark"><i aria-hidden="true" class="fa fa-bookmark"></i>0</span>
                        <span class="stats-item mx-05" data-tippy="" data-original-title="Bình luận"><i aria-hidden="true" class="fa fa-comments"></i>{{item.comments_count}}</span>
                    </div>
                    <div class="points d-flex align-items-center mr-3">
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['item'],
    data() {
        return {
        }
    },
    methods : {
        // Link đến 1 bài viết khác 
        linkPost() {
            this.$emit('postLink')
            
            window.location.href = window.location.href + '#bai-viet-lien-quan'
        }
    }
}
</script>