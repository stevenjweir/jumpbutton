<template>
    <div class="article-block">
        <i class="drag-icon material-icons">
            drag_handle
        </i>
        <label :for="'articleBlock_' + block.articleBlockType + '_' + block.id" class="control-label block-label">Heading</label>
        <block-delete-btn :block="block"></block-delete-btn>
        <h2 :class="'block-container-' + block.id">
            <textarea v-autosize="block.text_content" class="form-control article-heading heading" :name="'articleBlock_' + block.articleBlockType + '_' + block.id" v-model="block.text_content" :id="block.id" placeholder="Article Heading" rows="1"></textarea>
        </h2>
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
        props: [
            'block',
        ],
        mixins:[
            mixin
        ],
        methods: {
            //
        }
    }
</script>