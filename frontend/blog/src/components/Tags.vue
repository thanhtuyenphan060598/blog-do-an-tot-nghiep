<template>
    <div>
        <button @click="selectTag()"
            :class="{select:item.select}" type="button" class="btn btn-light mt-2 mr-2">
            {{item.name_tag}}
        </button>
    </div>
</template>
<script>
export default {
    props:["item"],
    data() {
        return {
            
        }
    },
    methods : {
        // Fire 1 sụ kiện để hiển thị chọn các thẻ
        selectTag() {
            this.item.select = !this.item.select
            this.$emit('selectTags')

      },
    }
}
</script>
<style scoped>
    .select {
    background-color: red;
  }
</style>