<template>
    <div class="article-block">
        <i class="drag-icon material-icons">
            drag_handle
        </i>
        <label :for="'articleBlock_' + block.articleBlockType + '_' + block.id" class="control-label block-label">Text</label>
        <block-delete-btn :block="block"></block-delete-btn>
        <div :class="'block-container-' + block.id" >
            <trumbowyg v-model="block.text_content" :name="'articleBlock_' + block.articleBlockType + '_' + block.id" :class="'form-control wysiwyg'" :id="block.id" :config="trumbowygConfig.blockText" placeholder="Article Text Block" rows=1></trumbowyg>
        </div>
        <hr>
    </div>
</template>
<script>
    import mixin from './blocks';

    export default {
        components: {
            'block-delete-btn': require('./BlockDeleteButton'),
        },
        data: function () {
            return {
                //
            }
        },
        computed: {
            //
        },
        mixins:[
            mixin
        ],
        props: [
            'block',
        ],
        methods: {
            //
        }
    }
</script>