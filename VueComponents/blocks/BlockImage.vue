<template>
    <div class="article-block">
        <i class="drag-icon material-icons">
            drag_handle
        </i>
        <label class="control-label block-label">Image</label>
        <block-delete-btn :block="block"></block-delete-btn>
        <div class="img-container" :class="'block-container-' + block.id" :id="'image-articleBlock-container-' + block.id">
            <image-upload :entity-type="'articleBlock'" :entity-id="block.id" :original-src="block.src" :endpoint="block.endpoints.block_remote_path" :aspect-ratio="'1.77'" mode="edit"></image-upload>
            <div class="image-upload-spinner" :id="'crop-articleBlock-spinner-' + block.id" style="display: none;">
                <i class="material-icons">cloud_upload</i>
            </div>
            <div class="image-upload-complete" :id="'crop-articleBlock-complete-' + block.id" style="display: none;">
                <i class="material-icons">done</i>
            </div>
            <div class="caption">
                <textarea v-autosize="block.text_content" v-model="block.text_content" :id="'block-link-text' + block.id" :name="'articleBlock_' + block.articleBlockType + '_' + block.id" class="form-control" placeholder="Image caption" rows=1></textarea>
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