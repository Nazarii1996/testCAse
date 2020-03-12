<template>
    <div>
        <div v-for="reply in items">

        </div>
    </div>
</template>

<script>
    import Reply from './Reply.vue';

    export default {
        props: ['data'], // accepts data for replies

        components: {Reply},

        data() {
            return {
                items: this.data
            }
        }
    }
</script>
