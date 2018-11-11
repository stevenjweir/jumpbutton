<template>
    <div class="article-block">
        <label class="control-label block-label">Add a Block</label>
        <div class="block-buttons">
            <button class="block-button block-button-heading" type="button" @click="addBlock(1, article_id)" data-toggle="tooltip" data-placement="top" title="Heading">
                <i class="material-icons md-36">title</i>
            </button>
            <button class="block-button block-button-subheading" type="button" @click="addBlock(2, article_id)" data-toggle="tooltip" data-placement="top" title="Subheading">
                <i class="material-icons">subtitles</i>
            </button>
            <button class="block-button block-button-text" type="button" @click="addBlock(3, article_id)" data-toggle="tooltip" data-placement="top" title="Text">
                <i class="material-icons">format_align_left</i>
            </button>
            <button class="block-button block-button-image" type="button" @click="addBlock(4, article_id)" data-toggle="tooltip" data-placement="top" title="Image">
                <i class="material-icons">photo</i>
            </button>
            <button class="block-button block-button-video" type="button" @click="addBlock(5, article_id)" data-toggle="tooltip" data-placement="top" title="Video">
                <i class="material-icons">ondemand_video</i>
            </button>
            <button class="block-button block-button-link" type="button" @click="addBlock(6, article_id)" data-toggle="tooltip" data-placement="top" title="Link">
                <i class="material-icons">link</i>
            </button>
            <button class="block-button block-button-quote" type="button" @click="addBlock(7, article_id)" data-toggle="tooltip" data-placement="top" title="Quote">
                <i class="material-icons">format_quote</i>
            </button>
            <button class="block-button block-button-gallery disabled" type="button" @click="addBlock(8, article_id)" data-toggle="tooltip" data-placement="top" title="Gallery" disabled="disabled">
                <i class="material-icons">photo_library</i>
            </button>
        </div>
    </div>
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
            'article_id'
        ],
        methods: {
            //
        }
    }

</script>