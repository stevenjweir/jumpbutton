<template>
    <div>
        <div class="article-builder">
            <!-- Saving Indicator -->
            <div class="article-builder-saving" :class="{ 'is-saving' : isSaving }">
                <i class="material-icons">save</i>
            </div>
            <!-- Header Image Upload -->
            <label class="control-label text-center article-header-label">HEADER</label>
            <div class="article-header">
                <image-upload :entity-type="'articleHeader'" :entity-id="article.id" :original-src="article.header_image" :endpoint="article.endpoints.header_remote_path" :aspect-ratio="'1.77'" :mode="mode"></image-upload>
            </div>
            <!--Article Form-->
            <div class="article">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card admin-card" :class="{ 'live' : form.live }">
                            <div class="row toggles">
                                <div class="form-group col-4 text-center">
                                <span class="live-toggle">
                                    <div class="checkbox">
                                        <input v-model="form.live" class="js-live-toggle" type="checkbox" :id="'live_' + article.id" :name="'live_' + article.id" :data-article-id="article.id"/>
                                        <label></label>
                                    </div>
                                    <label class="control-label text-center">STATUS</label>
                                </span>
                                </div>
                                <div class="form-group col-4 text-center">
                                <span class="jump-toggle">
                                    <div class="checkbox">
                                        <input v-model="form.featured" class="js-featured-toggle" type="checkbox" :id="'featured_' + article.id" :name="'featured_' + article.id" :data-article-id="article.id" />
                                        <label></label>
                                    </div>
                                    <label class="control-label text-center">FEATURED</label>
                                </span>
                                </div>
                                <div class="form-group col-4 text-center">
                                <span class="jump-toggle">
                                    <div class="checkbox">
                                        <input v-model="form.main_featured" class="js-main-featured-toggle" type="checkbox" :id="'main_featured_' + article.id" :name="'main_featured_' + article.id" :data-article-id="article.id" />
                                        <label></label>
                                    </div>
                                    <label class="control-label text-center">MAIN FEAT.</label>
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="admin_notes" class="control-label">Admin Notes</label>
                                <textarea v-autosize="form.admin_notes" v-model="form.admin_notes" name="admin_notes" id="admin_notes" class="form-control admin-notes" rows="1" placeholder="Optional notes for Admins"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <card-builder :article="this.article" :mode="mode"></card-builder>
                    </div>
                </div>
                <div class="article-title">
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label for="topics" class="control-label">Topics</label>
                            <select ref="topic_select" id="topics" v-model="form.topics" name="topics[]" multiple>
                                <option v-for="(topic_title, topic_id) in topics" :value="topic_id">{{ topic_title }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="game_id" class="control-label">Game</label>
                            <select ref="game_select" id="game_id" v-model="form.game_id" name="game_id">
                                <option v-for="(game_title, game_id) in games" :value="game_id">{{ game_title }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="title" class="control-label">Title</label>
                            <h1>
                                <textarea v-autosize="form.title" v-model="form.title" type="text" name="title" id="title" class="form-control" autocomplete="off" required autofocus rows="1" v-on:keyup="processTitle"></textarea>
                            </h1>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="slug" class="control-label">Slug</label>
                            <span class="btn btn-primary btn-sm btn-process-slug" @click="reAutoSlug" v-if="form.slug_manual">
                                <i class="material-icons">
                                    refresh
                                </i>
                            </span>
                            <textarea v-autosize="form.slug" v-model="form.slug" type="text" name="slug" id="slug" class="form-control" required rows="1" v-on:keyup="disableAutoSlug"></textarea>
                            <input type="hidden" name="slug_manual" v-model="form.slug_manual">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="start_date" class="control-label">Start Date</label>
                            <datetime v-model="form.start_date" value-zone="GMT" type="datetime" hidden-name="start_date" input-id="start_date" input-class="form-control"></datetime>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="expiry_date" class="control-label">Expiry Date (Optional)</label>
                            <span class="btn btn-primary btn-sm btn-process-slug" @click="clearExpiryDate" v-if="form.expiry_date">
                                <i class="material-icons">
                                    clear
                                </i>
                            </span>
                            <datetime v-model="form.expiry_date" value-zone="GMT" type="datetime" hidden-name="expiry_date" input-id="expiry_date" input-class="form-control"></datetime>
                        </div>
                    </div>
                </div>
                <!-- Block Builder -->
                <div class="article-body" v-if="article.id">
                    <div class="article-blocks">
                        <!--Article Blocks Go Here-->
                        <draggable @start="dragging = true" @end="draggedBlock()" :list="blocks" :options="draggableOptions">
                            <div v-for="block in blocks">
                                <template-block-heading v-if="block.article_block_type_id == 1" :block="block"></template-block-heading>
                                <template-block-sub-heading v-if="block.article_block_type_id == 2" :block="block"></template-block-sub-heading>
                                <template-block-text v-if="block.article_block_type_id == 3" :block="block"></template-block-text>
                                <template-block-image v-if="block.article_block_type_id == 4" :block="block"></template-block-image>
                                <template-block-video v-if="block.article_block_type_id == 5" :block="block"></template-block-video>
                                <template-block-link v-if="block.article_block_type_id == 6" :block="block"></template-block-link>
                                <template-block-quote v-if="block.article_block_type_id == 7" :block="block"></template-block-quote>
                                <template-block-image-gallery v-if="block.article_block_type_id == 8" :block="block"></template-block-image-gallery>
                            </div>
                        </draggable>
                    </div>
                    <!-- Add new buttons -->
                    <template-block-buttons :article_id="article.id"></template-block-buttons>
                </div>
            </div>
        </div>
        <div class="gamepad-buttons">
            <div class="btn-wrapper">
                <span class="btn back-to-top" data-toggle="tooltip" data-placement="left" title="Scroll to top">
                    <i class="material-icons">keyboard_arrow_up</i>
                </span>
                <span class="btn cancel-btn" data-toggle="tooltip" data-placement="left" title="Close">
                    <i class="material-icons">close</i>
                </span>
                <span @click.prevent="saveForm" class="btn save-btn" data-toggle="tooltip" data-placement="left" title="Save">
                    <i class="material-icons">save</i>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    var _ = require('lodash');
    var moment = require('moment');
    var Selectize = require('vue2-selectize');
    var draggable = require('vuedraggable');

    module.exports = {

        components: {
            Selectize,
            draggable,
            'card-builder': require('./CardBuilder'),

            //Template Block Components for Admin Article Builder
            'template-block-buttons': require('./ArticleBlocks/BlockButtons'),
            'template-block-heading': require('./ArticleBlocks/BlockHeading'),
            'template-block-image': require('./ArticleBlocks/BlockImage'),
            'template-block-image-gallery': require('./ArticleBlocks/BlockImageGallery'),
            'template-block-link': require('./ArticleBlocks/BlockLink'),
            'template-block-quote': require('./ArticleBlocks/BlockQuote'),
            'template-block-sub-heading': require('./ArticleBlocks/BlockSubHeading'),
            'template-block-text': require('./ArticleBlocks/BlockText'),
            'template-block-video': require('./ArticleBlocks/BlockVideo'),
        },

        data: function () {
            return {
                blocks: this.article.blocks,
                form: {
                    id: this.article.id,
                    live: this.article.live,
                    featured: this.article.featured,
                    main_featured: this.article.main_featured,
                    admin_notes: this.article.admin_notes,
                    game_id: this.article.game_id,
                    title: this.article.title,
                    card_title: this.article.card_title,
                    card_description: this.article.card_description,
                    card_title_manual: this.article.card_title_manual,
                    slug: this.article.slug,
                    slug_manual: this.article.slug_manual,
                    start_date: this.article.start_date ? moment(this.article.start_date.date).toISOString() : null,
                    expiry_date: this.article.expiry_date ? moment(this.article.expiry_date.date).toISOString() : null,
                    topics: _.map(this.article.topics, function (topic) {
                        return topic.id;
                    })
                },
                draggableOptions: {
                    handle:'.drag-icon'
                },
                dragging: false,
                isSaving: false
            }
        },

        props: [
            'article',
            'games',
            'topics',
            'mode'
        ],

        //
        watch: {
            game_id: function () {
                this.emitChange();
            },
            slug: function () {
                this.emitChange();
            },
        },

        created: function() {
            var _this = this;
        },

        mounted: function () {

            var _this = this;

            $(this.$refs.game_select).selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false
            }).on('change', function () {
                _this.form.game_id = $(this).val();
            });

            $(this.$refs.topic_select).selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false
            }).on('change', function () {
                _this.form.topics = $(this).val();
            });

            EventBus.$on('block.added.article.' + _this.article.id, function (payload) {
                this.blocks.push(payload.block);
            }.bind(this));

            EventBus.$on('block.removed.article.' + _this.article.id, function (payload) {
                var remove_this = _.findIndex(this.blocks, { id: parseInt(payload.block_id) });
                this.blocks.splice(remove_this, 1);
            }.bind(this));

        },

        computed: {
            //
        },

        methods: {
            processTitle: function () {
                this.processSlug();
                this.processCardTitle();
            },
            processSlug: function () {
                if(!this.form.slug_manual) {
                    this.form.slug = this.form.title.toLowerCase().replace(/[\. ,:-_]+/g, '-');
                }
                else {
                    this.form.slug = this.form.slug.toLowerCase().replace(/[\. ,:-_]+/g, '-');
                }
            },
            processCardTitle: function () {
                if(!this.form.card_title_manual) {
                    this.form.card_title = this.form.title;
                }
            },
            disableAutoSlug: function () {
                if(!this.form.slug_manual) {
                    this.form.slug_manual = true;
                }
                this.processSlug();
            },
            disableAutoCardTitle: function () {
                if(!this.form.card_title_manual) {
                    this.form.card_title_manual = true;
                }
            },
            reAutoSlug: function () {
                this.form.slug_manual = false;
                this.processSlug();
            },
            reAutoCardTitle: function () {
                this.form.card_title_manual = false;
                this.processCardTitle();
            },
            clearStartDate: function () {
                this.form.start_date = null;
            },
            clearExpiryDate: function () {
                this.form.expiry_date = null;
            },
            emitChange: function () {
                this.$emit('input', this.$data);
            },
            draggedBlock: function() {
                jQuery.ajax({
                    method: 'POST',
                    url: '/admin/article/resequence',
                    data: {
                        _token: window.csrfToken,
                        blocks: this.blocks
                    },
                    success: function (response) {
                        console.log(response)
                    }
                })
            },
            showSaved: function(response) {

                var self = this;

                self.isSaving = true;

                setTimeout(function(){
                    self.isSaving = false;
                }, 2000);

            },
            showError: function(response) {
                alert(response);
            },
            saveForm: function() {
                var self = this;

                jQuery.ajax({
                    method: 'POST',
                    url: '/admin/article/update',
                    data: {
                        _token: window.csrfToken,
                        form: self.form,
                        blocks: self.blocks
                    },
                    before: function() {
                        self.isSaving = true;
                    },
                    success: function (response) {
                        console.log(response);
                        self.showSaved(response);
                    },
                    error: function (response) {
                        console.log(response);
                        self.showError(response);
                    }
                })
            }
        }
    }
</script>
