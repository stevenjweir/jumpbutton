<template>
    <div class="article-block">
        <i class="drag-icon material-icons">
            drag_handle
        </i>
        <label :for="'articleBlock_' + block.articleBlockType + '_' + block.id" class="control-label block-label">Link</label>
        <block-delete-btn :block="block"></block-delete-btn>
        <div class="fast-travel" :class="'block-container-' + block.id">
            <div class="ft-link">
                <i class="material-icons">link</i>
                <textarea v-autosize="block.text_content" v-model="block.text_content" :id="'block-link-text' + block.id" :name="'articleBlock_' + block.articleBlockType + '_' + block.id" class="form-control" placeholder="Link title" rows=1></textarea>
            </div>
            <div class="ft-controls">
                <div class="ft-c-message">
                    <textarea v-autosize="block.extra_content" v-model="block.extra_content" :id="'block-link-url' + block.id" :name="'articleBlock_' + block.articleBlockType + '_' + block.id + '_extraContent'" class="form-control" placeholder="Url" rows=1></textarea>
                </div>
            </div>
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