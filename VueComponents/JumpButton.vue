<template>
    <a :href="url" class="the-jump-button the-jump-button-sml" @click="playSound">
        <div class="jmp-btn-rflct1"></div>
        <div class="jmp-btn-rflct2"></div>
        <div class="jmp-btn-shdw1"></div>
        <div class="jmp-btn-shdw2"></div>
        <div class="jmp-btn-rim">
            <div class="jmp-btn-cont">
                <div class="jmp-btn" id="jumpbutton">
                    <span class="jmp-btn-rflct1"></span>
                    <span class="jmp-btn-rflct2"></span>
                    <img :src="icon" alt="JumpButton">
                </div>
            </div>
        </div>
    </a>
</template>

<script>
    module.exports = {
        /**
         * This is the data which can be modified by the component, in this component we have clicked.
         * This tracks how many times the button has been clicked.
         */
        data: function () {
            return {
                url: this.btn_url,
                icon: this.btn_icon
            }
        },

        props: [
            'btn_url',
            'btn_icon',
        ],

        methods: {
            //Play Button Sound on Press
            playSound : function () {
                var snd = new Audio("/sounds/button.mp3");
                snd.play();
            }
        }
    }
</script>