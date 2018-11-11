<template>
    <div>
        <div class="card admin-card card-builder">
            <image-upload :entity-type="'articleCard'" :entity-id="parent_article.id" :original-src="parent_article.card_image" :endpoint="article.endpoints.card_remote_path" :aspect-ratio="'1.77'" :mode="mode"></image-upload>
            <div class="article-card-builder-details">
                <label for="card_title" class="control-label">Article Card Title</label>
                <span class="btn btn-primary btn-sm btn-process-slug" @click="this.$parent.reAutoCardTitle" v-if="this.$parent.form.card_title_manual">
                    <i class="material-icons">
                        refresh
                    </i>
                </span>
                <textarea v-autosize="this.$parent.form.card_title" v-model="this.$parent.form.card_title" type="text" name="card_title" id="card_title" class="form-control" required rows="1" v-on:keydown="this.$parent.disableAutoCardTitle"></textarea>
                <input type="hidden" name="card_title_manual" v-model="this.$parent.form.card_title_manual">
                <label for="card_description" class="control-label">Card Description</label>
                <textarea v-autosize="form.card_description" v-model="form.card_description" type="text" name="card_description" id="card_description" class="form-control" required rows="1"></textarea>
            </div>
        </div>
        <hr>
    </div>
</template>
<script>
    module.exports = {
        props: [
            'article',
            'mode'
        ],
        mounted: function () {
            //
        },
        data: function () {
            return {
                parent_article: this.article,
                form: {
                    title: this.$parent.form.title,
                    card_description: this.$parent.form.card_description,
                    title_manual: this.$parent.form.card_title_manual
                }
            }
        },
        methods: {
            //
        }
    }
</script>