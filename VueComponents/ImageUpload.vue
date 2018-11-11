<template>
    <div class="image-uploader" :id="'image-' + entityType + '-uploader-' + entityId">
        <label v-if="this.mode === 'edit'" :for="'image-' + entityType + '-upload-' + entityId" class="image-uploader-btn" :id="'image-' + entityType + '-upload-btn-' + entityId">
            <i class="material-icons">cloud_upload</i>
        </label>
        <input type='file' :name="'image-' + entityType + '-upload'" :id="'image-' + entityType + '-upload-' + entityId" class="image-upload" :data-entity-type="entityType" :data-entity-id="entityId" :data-remote-path="endpoint" :data-aspect-ratio="aspectRatio" style="display: none;"/>
        <div class="image-uploader-controls" style="display: none;" :id="'crop-' + entityType + '-controls-' + entityId">
            <span class="image-crop-accept" :id="'image-crop-' + entityType + '-accept-' + entityId" :data-entity-type="entityType" :data-entity-id="entityId" :data-remote-path="endpoint">
                <i class="material-icons">done</i>
            </span>
            <span class="image-crop-destroy" :id="'image-crop-' + entityType + '-destroy-' + entityId" :data-entity-type="entityType" :data-entity-id="entityId">
                <i class="material-icons">clear</i>
            </span>
        </div>
        <div class="image-uploader-imgs">
            <img :id="'crop-image-' + entityType + '-' + entityId" src="" alt="your image" style="display: none;"/>
            <img :id="'image-' + entityType + '-' + entityId" :src="originalSrc" alt="Image" />
        </div>
        <div class="image-uploader-spinner" :id="'crop-' + entityType + '-spinner-' + entityId" style="display: none;">
            <i class="material-icons">cloud_upload</i>
        </div>
        <div class="image-uploader-complete" :id="'crop-' + entityType + '-complete-' + entityId" style="display: none;">
            <i class="material-icons">cloud_done</i>
        </div>
    </div>
</template>
<script>
    module.exports = {
        props: [
            'mode',
            'entityType',
            'entityId',
            'originalSrc',
            'endpoint',
            'aspectRatio'
        ],
        mounted: function () {
            //
        },
        data: function () {
            return {
                //
            }
        },
        methods: {
            //
        }
    }
</script>