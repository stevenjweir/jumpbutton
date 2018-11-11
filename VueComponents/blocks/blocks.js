var trumbowyg = require('vue-trumbowyg');

export default {
    mounted: function () {
        //
    },
    computed: {
        trumbowygConfig: function () {
            return {
                blockText: {
                    btns: [
                        ['bold', 'italic'],
                        ['unorderedList', 'orderedList'],
                        ['link'],
                        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                        ['undo', 'redo'],
                        ['removeformat'],
                        ['horizontalRule'],
                        ['viewHTML']
                    ],
                    removeformatPasted: true,
                    autogrow: true,
                    svgPath: '/images/icons/trumbowyg.svg'
                }
            };
        },
    },
    methods: {
        addBlock: function (type, article_id) {
            event.preventDefault();

            var ajax_data = {
                template_item_id: type,
                article_id: article_id
            };

            $.ajax({
                type: 'POST',
                url: '/admin/article/builder/add-item',
                data: ajax_data,
                dataType: 'json',
                encode: true,
                success: function (response) {
                    EventBus.$emit('block.added.article.' + article_id, {
                        block: Object.assign({}, response.data)
                    });
                }
            });
        },
        removeBlock: function (block, article_id) {
            //Delete article blocks ajax
            bootbox.confirm({
                message: "Are you sure you want to delete this block? Remember, this cannot be undone!",
                buttons: {
                    cancel: {
                        label: 'No'
                    },
                    confirm: {
                        label: 'Yes'
                    }
                },
                callback: function callback(answer) {
                    //If YES Answer, AJAX Override the Main Featured Article
                    if (answer) {
                        $.ajax({
                            url: '/admin/article/builder/delete-item',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                block_id: block.id
                            },
                            success: function success(response) {
                                EventBus.$emit('block.removed.article.' + article_id, response);
                            },
                            error: function error(response) {
                                console.log(response);
                            }
                        });
                    }
                }
            });
        }
    }
}