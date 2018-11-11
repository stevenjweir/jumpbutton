<template>
    <span class="block-delete-btn" @click.prevent="removeBlock(block, block.article_id)">
        <i class="material-icons">delete</i>
    </span>
</template>
<script>
    import mixin from './blocks';

    export default {
        data: function () {
            return {
                //
            }
        },
        mixins:[
            mixin
        ],
        props: [
            'block'
        ],
        methods: {
            //
        }
    }

</script>