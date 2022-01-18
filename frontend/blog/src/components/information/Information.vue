<template>
    <section class="el-container viblo-container d-flex">
        <aside class="el-aside viblo-aside">
            <ul role="menu" class="el-menu el-menu--inline">
                <li role="menuitem" tabindex="-1" class="el-menu-item is-active">
                     <router-link :to="{name:'informationuser'}">
                         <i class="fa fa-user mr-2"></i>
                         Thông Tin Cá Nhân
                     </router-link>
                </li>
                <li role="menuitem" tabindex="-1" class="el-menu-item is-active">
                     <router-link :to="{name:'password'}">
                         <i class="fa fa-address-card mr-2"></i>
                         Đổi mật khẩu
                    </router-link>
                </li>
                
            </ul>
        </aside>
        <div class="el-main ml-5 w-75 p-4">
            <router-view></router-view>
        </div>
        
    </section>
</template>
<script>
export default {
    
}
</script>