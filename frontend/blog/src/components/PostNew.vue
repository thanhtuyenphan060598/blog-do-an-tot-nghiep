<template>
     <div class="sidebar__feed-item ">
            <h4 class="word-break mr-5 ">
              <router-link @click.native="linkPost()" :to="{name:'article',params:{id:item.id}}" class="link">{{item.title}}</router-link>
            </h4>
            <div class="sidebar__feed-item__info full-width">
              <div class="stats text-nowrap">
                <div class="points stats-item text-nowrap d-inline">
                  
                </div>
                <span class="stats-item text-muted mr-2" data-tippy="" data-original-title="Câu trả lời: 0"><i aria-hidden="true" class="stats-item__icon fa fa-reply mr-1"></i>0</span>
                <span class="stats-item text-muted mr-2" data-tippy="" data-original-title="Lượt xem: 30"><i aria-hidden="true" class="stats-item__icon fa fa-eye mr-1"></i>{{item.view}}</span>
                <span class="stats-item text-muted mr-2" data-tippy="" data-original-title="Bình luận: 0"><i aria-hidden="true" class="stats-item__icon fa fa-comment mr-1"></i>{{item.comments_count}}</span>
              </div>
            </div>
            <div class="sidebar__feed-item__subtitle"><a href="/u/HoangBee" class="link link--plain text-muted">
            {{item.user.name}}</a>
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
      // Link đển 1 bài viết khác
        linkPost() {
            this.$emit('postNew')
            window.location.href = window.location.href + '#bai-viet-moi-nhat'

        },
        
    },
}
</script>